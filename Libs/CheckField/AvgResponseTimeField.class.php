<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Libs\CheckField;

class AvgResponseTimeField extends AbstractField {


    /**
     * 规则名称
     *
     * @return string
     */
    function getName() {
        return '平均相应时间';
    }

    /**
     * 获取经过规则计算后的值
     *
     * @return mixed
     */
    function getValue() {
        $data = $this->getData();
        $total = 0;
        $result = 0;
        foreach ($data as $index => $row){
            $total += $row['end_time'] - $row['start_time'];
        }

        if(count($data) > 0){
            $result = ceil($total / count($data));
        }

        return $result;

    }

}