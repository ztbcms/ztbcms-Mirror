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
        $lists = M('MirrorChecker')->where($where)->order($order)->page($page, $limit)->select();
        $total = M('MirrorChecker')->where($where)->count();
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

    function create_alert() {
        $this->display();
    }

    function do_create_alert() {

    }

    function edit_alert() {
        $this->display();
    }

    function do_edit_alert() {

    }


}