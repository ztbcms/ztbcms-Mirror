<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Service;

use Message\Service\MessageService;
use Mirror\Libs\CheckField\AbstractField;
use Mirror\Libs\Message\MirrorAlertMessage;
use System\Service\BaseService;

class AlerterService extends BaseService {

    /**
     * 判定该alert是否需要发警报
     *
     * @param $alert_id
     */
    static function handleAlert($alert_id) {
        $db = D('Mirror/MirrorAlert');
        $alert = $db->where(['id' => $alert_id])->find();
        $checker = self::getCheckerById($alert['checker_id']);
        $now = time();
        //过去的X分中国年
        $start_time = $now - $alert['minute'] * 60 * 60;
        $end_time = $now;

        $logs = self::getLogs($alert_id['checker_id'], $start_time, $end_time);

        $check_field = self::instanceField($alert['check_field']);

        $check_field->setData($logs);

        $cal_check_value = $check_field->getValue();

        $msg = null;
        if ($alert['check_operator'] == 'GT') {
            if ($cal_check_value > $alert['check_value']) {

                $msg = new MirrorAlertMessage($alert['type_value'], '你监控的 ' . $checker['url'] . ' ' . $check_field->getName() . '高于' . $alert['check_value']);
            }
        }

        if ($alert['check_operator'] == 'LT') {
            if ($cal_check_value < $alert['check_value']) {
                $msg = new MirrorAlertMessage($alert['type_value'], '你监控的 ' . $checker['url'] . ' ' . $check_field->getName() . '低于' . $alert['check_value']);
            }
        }

        if (!empty($msg)) {
            MessageService::createMessage($msg);
        }

    }

    /**
     * 获取日志
     *
     * @param string $checker_id checker ID
     * @param int $start_time  单位：秒
     * @param int $end_time 单位：秒
     * @return array|mixed
     */
    static function getLogs($checker_id, $start_time, $end_time) {
        $db = D('Mirror/MirrorLog');
        $logs = $db->where([
            'checker_id' => $checker_id,
            'end_time' => [['EGT', $start_time * 1000], ['ELT', $end_time * 1000], 'AND']
        ])->select();

        if (empty($logs)) {
            $logs = [];
        }

        return $logs;

    }

    /**
     * 实例化字段
     *
     * @param string $check_field
     *
     * @return AbstractField
     */
    static function instanceField($check_field) {
        $obj = new $check_field;

        return $obj;

    }

    /**
     * 获取 Checker
     *
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    static function getCheckerById($id) {
        $res = D('Mirror/MirrorChecker')->where(['id' => $id])->find();
        if (empty($res)) {
            throw new \Exception('找不到该Checker信息');
        }

        return $res;
    }

    /**
     * 获取检测字段
     *
     * @return array
     */
    static function getCheckFields(){
        $config_check_fields = C('MIRROR_CHECK_FILE');

        $result = [];
        foreach ($config_check_fields as $index => $config_check_field){
            $check_field = self::instanceField($config_check_field);
            $result[] = [
                'name' => $check_field->getName(),
                'class' => get_class($check_field)
            ];
        }

        return self::createReturn(true, $result);
    }



}