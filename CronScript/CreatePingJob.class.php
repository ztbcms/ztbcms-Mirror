<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\CronScript;

use Cron\Base\Cron;
use Mirror\Jobs\PingWebsiteJob;
use Mirror\Model\MirrorCheckerModel;
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
        $db = D('Mirror/MirrorChecker');
        $checkers = $db->where(['next_time' => ['ELT', $now], 'enable' => MirrorCheckerModel::ENABLE_YES])->select();
        foreach ($checkers as $index => $checker) {
            $queue->push(self::QUEUE_MIRROR, new PingWebsiteJob($checker['id'], $checker['url']));
            $next_time = $now + doubleval($checker['minute']) * 60;
            $db->where(['id' => $checker['id']])->save(['next_time' => $next_time]);
        }

    }
}