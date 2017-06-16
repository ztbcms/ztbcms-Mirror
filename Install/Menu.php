<?php

return array(
    array(
        //父菜单ID，NULL或者不写系统默认，0为顶级菜单
        "parentid" => 37,
        //地址，[模块/]控制器/方法
        "route" => "Mirror/Index/index",
        //类型，1：权限认证+菜单，0：只作为菜单
        "type" => 0,
        //状态，1是显示，0不显示（需要参数的，建议不显示，例如编辑,删除等操作）
        "status" => 1,
        //名称
        "name" => "监控",
        //备注
        "remark" => "",
        //子菜单列表
        "child" => array(
            array(
                "route" => "Mirror/Index/checker_list",
                "type" => 1,
                "status" => 1,
                "name" => "Checkers列表",
            ),
            array(
                "route" => "Mirror/Index/getCheckerList",
                "type" => 1,
                "status" => 0,
                "name" => "获取Cheker列表操作",
            ),
            array(
                "route" => "Mirror/Index/create_checker",
                "type" => 1,
                "status" => 0,
                "name" => "创建Checker页面",
            ),
            array(
                "route" => "Mirror/Index/do_create_checker",
                "type" => 1,
                "status" => 0,
                "name" => "创建Checker操作",
            ),

            array(
                "route" => "Mirror/Index/do_delete_checker",
                "type" => 1,
                "status" => 0,
                "name" => "删除Checker操作",
            ),

            array(
                "route" => "Mirror/Index/alert_list",
                "type" => 1,
                "status" => 1,
                "name" => "Alert列表",
            ),
            array(
                "route" => "Mirror/Index/getAlertList",
                "type" => 1,
                "status" => 0,
                "name" => "获取Alert列表操作",
            ),

            array(
                "route" => "Mirror/Index/create_alert",
                "type" => 1,
                "status" => 0,
                "name" => "创建Alert页面",
            ),
            array(
                "route" => "Mirror/Index/do_create_alert",
                "type" => 1,
                "status" => 0,
                "name" => "创建Alert操作",
            ),
            array(
                "route" => "Mirror/Index/do_delete_alert",
                "type" => 1,
                "status" => 0,
                "name" => "删除Alert操作",
            ),
            array(
                "route" => "Mirror/Index/logs",
                "type" => 1,
                "status" => 0,
                "name" => "日志列表",
            ),

            array(
                "route" => "Mirror/Index/getLogs",
                "type" => 1,
                "status" => 0,
                "name" => "获取日志列表接口",
            ),

        ),
    ),
);
