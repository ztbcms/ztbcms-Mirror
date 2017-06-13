<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\CronScript;

use Cron\Base\Cron;
use Mirror\Jobs\PingWebsiteJob;
use Queue\Libs\Queue;

/**
 * 创建检测网址的任务
 */
class CreatePingJob extends Cron {

    //默认队列名
    const QUEUE_MIRROR = 'Mirror';

    /**
     * 执行任务回调
     *
     * @param string $cronId
     */
    public function run($cronId) {
        $now = time();

        $queue = Queue::getInstance();
        $db = D('Mirror/MirrorTask');
        $tasks = $db->where(['next_time' => ['ELT', $now]])->select();
        foreach ($tasks as $index => $task) {
            $queue->push(self::QUEUE_MIRROR, new PingWebsiteJob($task['id'], $task['url']));
            $next_time = $now + doubleval($task['minute']) * 60;
            $db->where(['id' => $task['id']])->save(['next_time' => $next_time]);
        }

    }
}