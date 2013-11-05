<?php

$stmt = $db->prepare('DROP TABLE IF EXISTS `tbl_blog`;

CREATE TABLE `tbl_blog` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `author` char(100) NULL DEFAULT NULL,
  `date` timestamp NULL DEFAULT NULL,
  `title` char(100) DEFAULT NULL,
  `content` char(200) DEFAULT NULL,
  `_version` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;');
$stmt->execute();
$stmt->closeCursor();

?>