<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Libs\Message;

use Message\Libs\Message;
use Mirror\Libs\Sender\EmailSender;

/**
 * 监控警报信息
 */
class MirrorAlertMessage extends Message {


    public function __construct($receiver, $content) {

        $this->setReceiver($receiver);
        $this->setContent($content);
    }


    /**
     * 消息分发渠道
     *
     * @return array Senders数组
     */
    function createSender() {
        return [
            new EmailSender()
        ];
    }
}