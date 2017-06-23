<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Jobs;

use GuzzleHttp\Client;
use Queue\Libs\Job;
use Queue\Libs\Utils;

class PingWebsiteJob extends Job {

    public $url;
    public $checker_id;

    /**
     * PingWebsiteJob constructor.
     *
     * @param $checker_id
     * @param $url
     */
    public function __construct($checker_id, $url) {
        $this->checker_id = $checker_id;
        $this->url = $url;
    }

    /**
     * 执行任务
     *
     * @return mixed
     */
    function handle() {
        $client = new Client([
            // You can set any number of default request options.
            'timeout' => 30,
        ]);

        $data = [
            'url' => $this->url,
            'create_time' => time(),
            'checker_id' => $this->checker_id
        ];
        $start_time = Utils::now();
        try {
            $response = $client->request('GET', $this->url);
            $statusCode = $response->getStatusCode();
            $data['status_code'] = $statusCode;
            $data['result'] = 0;

        } catch (\Exception $e) {
            $data['result'] = 1;
            $data['msg'] = $e->getMessage();
        } finally {
            $data['response_time'] = Utils::now() - $start_time;

            D('Mirror/MirrorLog')->add($data);
        }
    }
}