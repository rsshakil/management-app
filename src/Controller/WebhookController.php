<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Security\TokenAuthenticator;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Client;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use App\Entity\RequestLogs;
use App\Entity\BankApplication;
use App\Entity\BankPayment;
use App\Entity\UserToken;
use App\Entity\App;
use App\Entity\BankAccount;
use App\Service\HttpClientService;

class WebhookController extends AbstractController
{
    private $entityManager;
    private $tokenAuthenticator;
    private $log;
    private $httpClientService;

    public function __construct(EntityManagerInterface $entityManager, TokenAuthenticator $tokenAuthenticator, HttpClientService $httpClientService)
    {
        $this->entityManager = $entityManager;
        $this->tokenAuthenticator = $tokenAuthenticator;
        $this->httpClientService = $httpClientService;
        // log 設定
        // $this->log = new Logger('selenium-app');
        // $this->log->pushHandler(new StreamHandler('/var/www/html/webhook.log', Logger::DEBUG));
        // $this->log->pushHandler(new ChromePHPHandler(Logger::DEBUG));
        // $this->log->pushHandler(new FirePHPHandler(Logger::DEBUG));
    }

    /**
     * @Route("/webhook/auth/create/token", methods={"POST"})
     */
    public function createToken(Request $request, EntityManagerInterface $entityManager)
    {
        // JSON形式のリクエストデータをデコード
        $requestData = json_decode($request->getContent(), true);
        // ログにリクエストデータを出力


        // app_user_idが存在するか確認
        if (!isset($requestData['app_user_id'])) {
            return new JsonResponse(['error' => 'app_user_id is required'], Response::HTTP_BAD_REQUEST);
        }

        // app_user_idでUserTokenテーブルからデータを取得
        $user = $entityManager->getRepository(UserToken::class)->findOneBy(['app_user_id' => $requestData['app_user_id']]);

        // UserTokenテーブルに該当するデータがない場合、新規登録を行う
        if (!$user) {
            // UserTokenエンティティを作成してデータをセット
            $user = new UserToken();
            $user->setAppId($requestData['app_id']);
            $user->setAppUserId($requestData['app_user_id']);

            // その他の必要なデータをセット（tokenやexpirationなど）
            $token = $this->generateToken(); // トークンを生成するメソッドを呼び出し
            $user->setToken($token);
            $expiration = new \DateTime();
            $expiration->modify('+1 hour'); // 1時間後の日時を取得
            $user->setExpiration($expiration);

            // エンティティをデータベースに保存
            $entityManager->persist($user);
            $entityManager->flush();
        } else {
            // その他の必要なデータをセット（tokenやexpirationなど）
            $token = $this->generateToken(); // トークンを生成するメソッドを呼び出し
            $user->setToken($token);
            // expirationを現在の日時から1時間延長
            $expiration = new \DateTime();
            $expiration->modify('+1 hour');
            $user->setExpiration($expiration);
            // エンティティをデータベースに保存
            $entityManager->flush();
        }

        // トークンと有効期限を返却
        return new JsonResponse([
            'status' => 200,
            'token' => $user->getToken(),
            'expiration' => $expiration->format('Y-m-d H:i:s')
        ]);
    }

    // トークンを生成するメソッド
    private function generateToken(): string
    {
        // ここでトークンを生成するロジックを実装（40文字のランダムな文字列など）
        return bin2hex(random_bytes(20)); // 例: 40文字のランダムな16進数文字列
    }

    /**
     * @Route("/webhook/bank/application/create", methods={"POST"})
     */
    public function createBankApplication(Request $request, TokenAuthenticator $tokenAuthenticator)
    {
        // JSON形式のリクエストデータをデコード
        $requestData = json_decode($request->getContent(), true);

        // トークン認証を行う
        try {
            // TokenAuthenticator の authenticate メソッドを呼び出して認証を行う
            $passport = $this->tokenAuthenticator->authenticate($request);
            // 認証に成功した場合は、処理を継続する
        } catch (\Exception $e) {
            // 認証に失敗した場合は、適切なエラーレスポンスを返す
            $this->log->error('error：'.$e);
            return new JsonResponse(['error' => 'Authentication failed'], Response::HTTP_UNAUTHORIZED);
        }

        // 最新のリクエストログを取得
        $latestRequestLog = $this->entityManager->getRepository(RequestLogs::class)->findOneBy([], ['id' => 'DESC']);
        // 最新のリクエストログが存在しない場合はエラーを返す
        if (!$latestRequestLog) {
            return new JsonResponse(['error' => 'No request log found'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // 最新のリクエストログのIDを取得
        $requestLogId = $latestRequestLog->getId();

        try {
            // BankApplicationエンティティを作成して保存
            $bankApplication = new BankApplication();
            $bankApplication->setRequestLogId($requestLogId);
            // その他の必要なデータをセット
            $bankApplication->setAppId((int)$requestData['app_id']);
            $bankApplication->setAppUserId($requestData['app_user_id']);
            $bankApplication->setAppUserEmail($requestData['app_user_email']);
            $bankApplication->setAppRequestId($requestData['app_request_id']);
            $bankApplication->setBankAccountId($requestData['bank_account_id']);
            $bankApplication->setEstimateName($requestData['estimate_name']);
            $bankApplication->setEstimateAmount((int)$requestData['estimate_amount']);
            $bankApplication->setBalance((int)$requestData['estimate_amount']);
            $this->entityManager->persist($bankApplication);
            $this->entityManager->flush();
        } catch (\Exception $e) {
            $this->log->error('error：'.$e);
        }

        // リクエストデータのパラメーターを取得
        $amount = $requestData['estimate_amount'];
        $deposit_application_id = $bankApplication->getId();
        $bank_name = 'GMOあおぞらネット';
        $branch_name = 'アドレス';
        $account_type = '普通';
        $account_number = 1234567;
        $account_name = 'ハンターサイト（カ';
        $transfer_name = 'ABC1234567';

        // レスポンスを作成
        $responseData = [
            'status' => 200,
            'deposit_application_id' => $deposit_application_id,
            'bank_name' => $bank_name,
            'branch_name' => $branch_name,
            'account_type' => $account_type,
            'account_number' => $account_number,
            'account_name' => $account_name,
            'transfer_name' => $transfer_name,
            'amount' => $amount,
            'server' => 'bts',
        ];

        // レスポンスをJSON形式で返す
        return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @Route("/webhook/bank/transfer/create", methods={"POST"})
     */
    public function createBankTransfer(Request $request, TokenAuthenticator $tokenAuthenticator)
    {
        // JSON形式のリクエストデータをデコード
        $requestData = json_decode($request->getContent(), true);

        // トークン認証を行う
        try {
            // TokenAuthenticator の authenticate メソッドを呼び出して認証を行う
            $passport = $this->tokenAuthenticator->authenticate($request);
            // 認証に成功した場合は、処理を継続する
        } catch (\Exception $e) {
            // $this->log->error('error：'.$e);
            // 認証に失敗した場合は、適切なエラーレスポンスを返す
            return new JsonResponse(['error' => 'Authentication failed'], Response::HTTP_UNAUTHORIZED);
        }

        // $this->log->error('jsonRequest：', $requestData);


        // リクエストデータのパラメーターを取得
        $amount = $requestData['amount'];
        $deposit_application_id = 10001;
        $bank_name = 'GMOあおぞらネット';
        $branch_name = 'アドレス';
        $account_type = '普通';
        $account_number = 1234567;
        $account_name = 'ハンターサイト（カ';
        $transfer_name = 'ABC1234567';

        // レスポンスを作成
        $responseData = [
            'status' => 200,
            'deposit_application_id' => $deposit_application_id,
            'bank_name' => $bank_name,
            'branch_name' => $branch_name,
            'account_type' => $account_type,
            'account_number' => $account_number,
            'account_name' => $account_name,
            'transfer_name' => $transfer_name,
            'amount' => $amount,
            'server' => 'bts'
        ];

        // レスポンスが成功した場合の処理
        if ($responseData['status'] === 200) {
            // POSTする先のエンドポイント
            /*
            $endpoint = 'http://172.18.0.9/webhook/bank/transfer/create';

            // POSTするデータ
            $postData = [
                // 必要なデータをここにセットする
                'deposit_application_id' => $deposit_application_id,
                'bank_name' => $bank_name,
                'branch_name' => $branch_name,
                'account_type' => $account_type,
                'account_number' => $account_number,
                'account_name' => $account_name,
                'transfer_name' => $transfer_name,
                'amount' => $amount,
            ];

            // Guzzle HTTPクライアントを作成
            $client = new Client();

            try {
                // POSTリクエストを送信
                $response = $client->request('POST', $endpoint, [
                    'json' => $postData,
                ]);
            } catch (RequestException $e) {
                // リクエストが失敗した場合の処理
                $this->log->error('Request failed: ' . $e->getMessage());
                return new JsonResponse(['error' => 'Request failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            */
        }

        // レスポンスをJSON形式で返す
        return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * @Route("/webhook/bank/deposit/get", methods={"POST"})
     */
    public function getBankDeposit(Request $request, TokenAuthenticator $tokenAuthenticator)
    {
        // JSON形式のリクエストデータをデコード
        $requestData = json_decode($request->getContent(), true);


        // リクエストデータのパラメーターを取得
        $bank_statement_id = (int)$requestData['bank_statement_id'];
        $bank_name = 'GMOあおぞらネット';
        $branch_name = 'アドレス';
        $account_type = '普通';
        $account_number = 1234567;
        $account_name = 'ハンターサイト（カ';
        $transfer_name = $requestData['transfer_name'];
        $transfer_amount = (int)$requestData['transfer_amount'];

        // レスポンスを作成
        $responseData = [
            'status' => 200,
            'bank_statement_id' => $bank_statement_id,
            'bank_name' => $bank_name,
            'branch_name' => $branch_name,
            'account_type' => $account_type,
            'account_number' => $account_number,
            'account_name' => $account_name,
            'transfer_name' => $transfer_name,
            'server' => 'bts'
        ];

        // ステータスコードが200以外の場合
        if ($responseData['status'] != 200) {
            // POSTする先のエンドポイント
            /*
            $endpoint = 'http://172.18.0.9/webhook/bank/transfer/create';

            // POSTするデータ
            $postData = [
                // 必要なデータをここにセットする
                'deposit_application_id' => $deposit_application_id,
                'bank_name' => $bank_name,
                'branch_name' => $branch_name,
                'account_type' => $account_type,
                'account_number' => $account_number,
                'account_name' => $account_name,
                'transfer_name' => $transfer_name,
                'amount' => $amount,
            ];

            // Guzzle HTTPクライアントを作成
            $client = new Client();

            try {
                // POSTリクエストを送信
                $response = $client->request('POST', $endpoint, [
                    'json' => $postData,
                ]);
            } catch (RequestException $e) {
                // リクエストが失敗した場合の処理
                $this->log->error('Request failed: ' . $e->getMessage());
                return new JsonResponse(['error' => 'Request failed'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            */
            return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE), $responseData['status'], [], JSON_UNESCAPED_UNICODE);
        }

        // BankApplicationエンティティから条件に一致するレコードを取得
        $bankApplicationRepository = $this->entityManager->getRepository(BankApplication::class);
        $bankApplication = $bankApplicationRepository->createQueryBuilder('ba')
            ->where('ba.estimate_name = :transfer_name')
            ->andWhere('ba.estimate_amount = :transfer_amount')
            ->andWhere('ba.balance >= :balance')
            ->setParameter('transfer_name', $transfer_name)
            ->setParameter('transfer_amount', $transfer_amount)
            ->setParameter('balance', 1)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$bankApplication) {
            $bankApplication = $bankApplicationRepository->createQueryBuilder('ba')
            ->where('ba.estimate_name = :transfer_name')
            ->andWhere('ba.balance >= :balance')
            ->setParameter('transfer_name', $transfer_name)
            ->setParameter('balance', 1)
            ->getQuery()
            ->getOneOrNullResult();
        }

        //            $this->log->error('jsonRequest：', $bankApplication);

        // 条件に一致するレコードが見つかった場合は、BankPaymentエンティティに新しいレコードを追加
        if ($bankApplication) {
            $app = $this->entityManager->getRepository(App::class)->find($bankApplication->getAppId());
            $bankAccount = $this->entityManager->getRepository(BankAccount::class)->find($bankApplication->getBankAccountId());    
            $bankPayment = new BankPayment();
            $bankPayment->setBankApplication($bankApplication);
            $bankPayment->setBankStatementId($bank_statement_id); // 銀行取引ID
            $bankPayment->setAppId($bankApplication->getAppId());
            $bankPayment->setApp($app);
            $bankPayment->setBankAccountId($bankApplication->getBankAccountId());
            $bankPayment->setBankAccount($bankAccount);
            $bankPayment->setAppUserId($bankApplication->getAppUserId());
            $bankPayment->setAppUserEmail($bankApplication->getAppUserEmail());
            $bankPayment->setAppRequestId(1);
            $bankPayment->setTransferName($transfer_name); // 送金者名
            $bankPayment->setTransferAmount($transfer_amount); // 送金
            $amountStatus = ($bankApplication->getEstimateAmount() < $transfer_amount) ? 3 : (($bankApplication->getEstimateAmount() > $transfer_amount) ? 2 : 1 );
            $bankPayment->setAmountStatus($amountStatus);
            $bankPayment->setIsPaid(0);
            $bankPayment->setNotifyStatus(0);
            $bankPayment->setNotifyCount(0);
            // エンティティをデータベースに保存
            $this->entityManager->persist($bankPayment);
            $this->entityManager->flush();

            $newBalance = $bankApplication->getBalance() - $transfer_amount;
            // 新しい残高を設定
            $bankApplication->setBalance($newBalance);
            $this->entityManager->persist($bankPayment);
            // エンティティの変更をデータベースに即時反映
            $this->entityManager->flush();
        }

        // レスポンスをJSON形式で返す
        return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE), Response::HTTP_OK, [], JSON_UNESCAPED_UNICODE);
    }
}
