<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Libs\CheckField;

abstract class AbstractField {

    /**
     * @var array
     */
    private $data;

    /**
     * 规则名称
     *
     * @return string
     */
    abstract function getName();

    /**
     * 获取经过规则计算后的值
     *
     * @return mixed
     */
    abstract function getValue();

    /**
     * @return array
     */
    public function getData(): array {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data) {
        $this->data = $data;
    }



}