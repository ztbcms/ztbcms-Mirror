<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Controller;

use Common\Controller\AdminBase;
use Mirror\Service\AlerterService;

class IndexController extends AdminBase {

    function checker_list() {
        $this->display();
    }

    /**
     * 获取Cheker列表操作
     */
    public function getCheckerList() {
        $where = [];
        if (I('where')) {
            $where = I('where');
            foreach ($where as $key => $item) {
                if ($item == '') {
                    unset($where[$key]);
                }
            }
        }

        $order = 'id desc';
        $page = I('page', 1);
        $limit = I('limit', 20);
        $db = D('Mirror/MirrorChecker');
        $lists = $db->where($where)->order($order)->page($page, $limit)->select();
        $total = $db->where($where)->count();
        $data = [
            'items' => $lists ? $lists : [],
            'limit' => $limit,
            'page' => $page,
            'total' => $total,
            'page_count' => ceil($total / $limit),
        ];

        $this->ajaxReturn(self::createReturn(true, $data));
    }

    function create_checker() {
        $this->display();
    }

    function do_create_checker() {
        $data = I('post.');
        $result = D('Mirror/MirrorChecker')->add($data);
        $this->ajaxReturn(self::createReturn(true, $result, '操作成功'));
    }

    function edit_checker() {
        $this->display();
    }

    function do_edit_checker() {

    }

    function view_checker() {
        $this->display();
    }

    function alert_list() {
        $this->display();
    }

    /**
     * 获取Alert列表操作
     */
    public function getAlertList() {
        $where = [];
        if (I('where')) {
            $where = I('where');
            foreach ($where as $key => $item) {
                if ($item == '') {
                    unset($where[$key]);
                }
            }
        }

        $order = 'id desc';
        $page = I('page', 1);
        $limit = I('limit', 20);
        $db = D('Mirror/MirrorAlert');
        $lists = $db->where($where)->order($order)->page($page, $limit)->relation(true)->select();
        $total = $db->where($where)->count();
        $data = [
            'items' => $lists ? $lists : [],
            'limit' => $limit,
            'page' => $page,
            'total' => $total,
            'page_count' => ceil($total / $limit),
        ];

        $this->ajaxReturn(self::createReturn(true, $data));
    }

    function create_alert() {
        $check_fields = AlerterService::getCheckFields()['data'];
        
        $this->assign('check_fields', $check_fields);
        $this->display();
    }

    function do_create_alert() {
        $data = I('post.');
        $result = D('Mirror/MirrorAlert')->add($data);
        $this->ajaxReturn(self::createReturn(true, $result, '操作成功'));
    }

    function edit_alert() {
        $this->display();
    }

    function do_edit_alert() {

    }

    /**
     * 日志列表
     */
    function logs(){
        $this->display();
    }

    /**
     * 获取日志列表接口
     */
    function getLogs(){
        $where = [];
        if (I('where')) {
            $where = I('where');
            foreach ($where as $key => $item) {
                if ($item == '') {
                    unset($where[$key]);
                }
            }
        }

        $order = 'id desc';
        $page = I('page', 1);
        $limit = I('limit', 20);
        $db = D('Mirror/MirrorLog');
        $lists = $db->where($where)->order($order)->page($page, $limit)->select();
        $total = $db->where($where)->count();

        $data = [
            'items' => $lists ? $lists : [],
            'limit' => $limit,
            'page' => $page,
            'total' => $total,
            'page_count' => ceil($total / $limit),
        ];

        $this->ajaxReturn(self::createReturn(true, $data));
    }


}