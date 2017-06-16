<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Model;

use Common\Model\RelationModel;

class MirrorAlertModel extends RelationModel {

    /**
     * 启用
     */
    const ENABLE_YES = 1;
    /**
     * 禁用
     */
    const ENABLE_NO = 1;
    /**
     * 关联表
     *
     * @var array
     */
    protected $_link = array(
        //关联滤芯
        'checkerData' => array(
            "mapping_type" => self::HAS_ONE,
            "class_name" => 'Mirror/MirrorChecker',
            "foreign_key" => "id",
            "mapping_key" => "checker_id",
//            "mapping_order" => "filter_order ASC",
//            "mapping_fields" => "id,username,nickname,store_id"
        ),

    );


}