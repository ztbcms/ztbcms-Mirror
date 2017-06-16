<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\CronScript;

use Cron\Base\Cron;
use Mirror\Model\MirrorAlertModel;
use Mirror\Service\AlerterService;

/**
 * 更新 Alerter 状态
 */
class UpdateAlerter extends Cron {

    /**
     * 执行任务回调
     *
     * @param string $cronId
     */
    public function run($cronId) {
        $now = time();

        $db = D('Mirror/MirrorAlert');
        $alerts = $db->where(['next_time' => ['ELT', $now], 'enable' => MirrorAlertModel::ENABLE_YES])->select();

        foreach ($alerts as $index => $alert) {
            AlerterService::handleAlert($alert['id']);
            $next_time = $now + $alert['minute'] * 60 * 60;
            $db->where(['id' => $alert['id']])->save(['next_time' => $next_time]);
        }
    }
}