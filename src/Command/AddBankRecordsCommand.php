<?php

namespace App\Command;

use App\Entity\Bank;
use App\Entity\BankBranch;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Doctrine\DBAL\Connection;

class AddBankRecordsCommand extends Command
{
    // コマンド名
    protected static $defaultName = 'app:add-bank-records';

    // エンティティマネージャー
    private $entityManager;
    // DBAL接続
    private $connection;

    public function __construct(EntityManagerInterface $entityManager, Connection $connection)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->connection = $connection;
    }

    protected function configure()
    {
        $this->setDescription('Add bank records from external API.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // テーブルをトランケート
        $this->truncateTables($output);

        // HTTPクライアントの作成
        $client = HttpClient::create();

        try {
            // APIからデータを取得
            $response = $client->request('GET', 'https://bank.teraren.com/banks.json?per=100000');

            // レスポンスをJSON形式でデコード
            $data = $response->toArray();

            // データベースにレコードを追加
            foreach ($data as $bankData) {
                $bank = new Bank();
                $bank->setBankName($bankData['name']);
                $bank->setBankCode($bankData['code']);

                $this->entityManager->persist($bank);
            }

            // エンティティの変更をデータベースに反映
            $this->entityManager->flush();

            $output->writeln('Bank records added successfully.');
        } catch (ExceptionInterface $e) {
            // エラーが発生した場合の処理
            $output->writeln('An error occurred: ' . $e->getMessage());
        }

        // GMOあおぞらネットのBankエンティティを取得
        $bank = $this->entityManager->getRepository(Bank::class)->findOneBy(['bank_name' => 'GMOあおぞらネット']);

        // Bankエンティティが見つからない場合はエラーを出力して終了
        if (!$bank) {
            $output->writeln('GMOあおぞらネットの銀行情報が見つかりませんでした。');
            return Command::FAILURE;
        }

        // GMOあおぞらネットのbank_codeを取得
        $bankCode = $bank->getBankCode();

        // HTTPクライアントの作成
        $client = HttpClient::create();

        try {
            // APIからデータを取得
            $response = $client->request('GET', 'https://bank.teraren.com/banks/'.$bankCode.'/branches.json?per=100000');

            // レスポンスをJSON形式でデコード
            $data = $response->toArray();

            // データベースにレコードを追加
            foreach ($data as $branchData) {
                $branch = new BankBranch();
                $branch->setBranchName($branchData['name']);
                $branch->setBranchCode($branchData['code']);
                $branch->setBank($bank);

                $this->entityManager->persist($branch);
            }

            // エンティティの変更をデータベースに反映
            $this->entityManager->flush();

            $output->writeln('Bank branch records added successfully.');
        } catch (ExceptionInterface $e) {
            // エラーが発生した場合の処理
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function truncateTables(OutputInterface $output)
    {
        // 外部キー制約を一時的に無効化
        $this->disableForeignKeyConstraints();

        try {
            // Bankテーブルをトランケート
            $this->entityManager->createQuery('DELETE FROM App\Entity\Bank')->execute();

            // BankBranchテーブルをトランケート
            $this->entityManager->createQuery('DELETE FROM App\Entity\BankBranch')->execute();

            $output->writeln('Bank and BankBranch tables truncated successfully.');
        } catch (\Exception $e) {
            // エラーが発生した場合の処理
            $output->writeln('An error occurred: ' . $e->getMessage());
            return Command::FAILURE;
        }

        // 外部キー制約を再度有効化
        $this->enableForeignKeyConstraints();
    }

    private function disableForeignKeyConstraints()
    {
        // 外部キー制約を一時的に無効化
        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS=0');
    }

    private function enableForeignKeyConstraints()
    {
        // 外部キー制約を再度有効化
        $this->connection->executeStatement('SET FOREIGN_KEY_CHECKS=1');
    }
}
