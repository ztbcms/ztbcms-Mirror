CREATE TABLE `cms_mirror_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL COMMENT '所属任务ID',
  `url` varchar(1024) NOT NULL DEFAULT '' COMMENT '网址',
  `start_time` bigint(13) NOT NULL COMMENT '开始时间',
  `end_time` bigint(13) NOT NULL COMMENT '结束时间',
  `status_code` varchar(4) NOT NULL DEFAULT '' COMMENT '状态码',
  `msg` varchar(256) NOT NULL DEFAULT '' COMMENT '信息',
  `result` int(11) NOT NULL DEFAULT '0' COMMENT '0为正常，非0为错误',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE `cms_mirror_task` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL COMMENT '网址',
  `next_time` int(11) NOT NULL COMMENT '下一次执行时间',
  `minute` int(11) NOT NULL DEFAULT '1' COMMENT '多少分钟重复一次',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;