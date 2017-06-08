<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Controller;

use Common\Controller\AdminBase;
use Mirror\Jobs\PingWebsiteJob;
use Queue\Libs\Queue;

class TestingController extends AdminBase {

    function push(){
        $q = Queue::getInstance();
        $q->push('default', new PingWebsiteJob(1,'http://zhutibang.cn'));
    }


    function pingWebsite(){
        $job = new PingWebsiteJob(1,'http://doc.ztbweb.cn');
        $job->handle();
    }

}