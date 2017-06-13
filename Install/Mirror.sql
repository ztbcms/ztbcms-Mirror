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

CREATE TABLE `cms_mirror_checker` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `url` int(11) NOT NULL COMMENT '网址',
  `next_time` int(11) NOT NULL COMMENT '下一次执行时间',
  `minute` int(11) NOT NULL DEFAULT '1' COMMENT '多少分钟重复一次',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cms_mirror_alert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` int(11) DEFAULT NULL COMMENT '通知方式',
  `type_value` int(11) DEFAULT NULL COMMENT '通知方式对应值',
  `checker_id` int(11) DEFAULT NULL COMMENT '关联检测器的ID',
  `check_field` int(11) DEFAULT NULL COMMENT '检测字段',
  `check_operator` int(11) DEFAULT NULL COMMENT '比较符号',
  `check_value` int(11) DEFAULT NULL COMMENT '检测比较值',
  `minute` int(11) DEFAULT NULL COMMENT '分钟频率',
  `next_time` int(11) DEFAULT NULL COMMENT '下次检测时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;