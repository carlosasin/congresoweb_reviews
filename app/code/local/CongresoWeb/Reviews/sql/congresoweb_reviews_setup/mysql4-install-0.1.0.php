<?php

$installer = $this;

$installer->startSetup();

$installer->run("
    CREATE TABLE IF NOT EXISTS `{$installer->getTable('congresoweb_reviews')}` (
      `review_id` int unsigned NOT NULL auto_increment,
      `customer_id` int(11) unsigned NOT NULL,
      `order_id` int unsigned NOT NULL,
      `title` varchar(255) NOT NULL default '',
      `description` text NOT NULL default '',
      `rating` smallint(2) NOT NULL default '0',
      `created_time` datetime NULL,
      PRIMARY KEY (`review_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();