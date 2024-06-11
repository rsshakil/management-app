<?php

namespace App\EventListener;

use App\Entity\RequestLogs;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class RequestListener
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();

        // リクエストがPOSTメソッドであることを確認
        if ($request->isMethod('POST')) {
            // RequestLogsエンティティを作成
            $requestLog = new RequestLogs();

            // リクエスト時間をセット
            $requestLog->setRequestTime(new \DateTime());

            // リクエストデータをセット
            $requestLog->setRequestData(json_encode([
                'method' => $request->getMethod(),
                'path' => $request->getPathInfo(),
                'content' => $request->getContent(),
                // 他にも必要な情報があれば追加する
            ]));

            // エンティティをデータベースに保存
            $this->entityManager->persist($requestLog);
            $this->entityManager->flush();
        }
    }
}
