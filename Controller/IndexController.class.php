<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Controller;

use Common\Controller\AdminBase;

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

    /**
     * 删除 Checker 操作
     */
    function do_delete_checker() {
        $id = I('post.id');

        D('Mirror/MirrorChecker')->where(['id' => $id])->delete();
        D('Mirror/MirrorAlert')->where(['checker_id' => $id])->delete();
        $this->ajaxReturn(self::createReturn(true, null, '操作成功'));
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
        $this->display();
    }

    function do_create_alert() {
        $data = I('post.');
        $data['check_operator'] = trim($data['check_operator']);
        $result = D('Mirror/MirrorAlert')->add($data);
        $this->ajaxReturn(self::createReturn(true, $result, '操作成功'));
    }

    /**
     * Alert 编辑页
     */
    function edit_alert() {
        $id = I('get.alert_id');
        $data = D('Mirror/MirrorAlert')->where(['id' => $id])->find();
        $this->assign('data', $data);
        $this->display('create_alert');
    }

    /**
     * 编辑
     */
    function do_edit_alert() {
        $data = I('post.');
        $data['check_operator'] = trim($data['check_operator']);
        $id = $data['id'];
        unset($data['id']);
        $result = D('Mirror/MirrorAlert')->where(['id' => $id])->save($data);
        $this->ajaxReturn(self::createReturn(true, $result, '操作成功'));
    }

    /**
     * 删除 Alert 操作
     */
    function do_delete_alert() {
        $id = I('post.id');
        D('Mirror/MirrorAlert')->delete($id);
        $this->ajaxReturn(self::createReturn(true, null, '操作成功'));
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