<?php

/**
 * author: Jayin <tonjayin@gmail.com>
 */

namespace Mirror\Libs\Sender;

use Message\Libs\Message;
use Message\Libs\Sender;

/**
 * 邮件通知
 */
class EmailSender extends Sender {

    /**
     * 发送消息操作
     *
     * @param Message $message
     * @return boolean
     */
    function doSend(Message $message) {
        $res = sendMail($message->getReceiver(), '警报', $message->getContent());
        if($res){
            return true;
        }
        return false;
    }
}