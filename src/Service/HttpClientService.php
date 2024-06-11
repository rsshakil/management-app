<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use GuzzleHttp\Client;

class HttpClientService
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * 指定されたエンドポイントにPOSTリクエストを送信する
     *
     * @param string $url POSTリクエストを送信するエンドポイントのURL
     * @param array $data ポストするデータ
     * @return void
     */
    public function sendPostRequest(string $url, array $data, int &$retryCount = 0): array
    {
        $client = new Client();

        do {
            // POSTリクエストを送信
            $response = $client->post($url, [
                'json' => $data,
            ]);

            // ステータスコードを取得
            $statusCode = $response->getStatusCode();

            // ステータスコードが200以外の場合はリトライ
            if ($statusCode !== 200) {
                usleep(500000); // 0.5秒待機
            }

            $retryCount++;
        } while ($statusCode !== 200 && $retryCount < 10);


        // レスポンスのステータスコードを確認
        //        if ($response->getStatusCode() !== 200) {
        //            throw new \RuntimeException('Failed to send POST request');
        //        }

        // レスポンスを取得
        return json_decode($response->getBody(), true);
    }
}
