<?php

/**
 * create-table.php
 * Creates Tab;e
 * @author Tayyib Oladoja
 * @version 1.0
 * @date 10-05-2016
 * @website www.tayyiboladoja.com
 * @package Email Tracker
**/
	
		$connection = new PDO ( "mysql:host=$mysql_hostname;dbname=$mysql_dbname", $mysql_username, $mysql_password);
		//check if table exist	
		if ($connection->query ("DESCRIBE email_log"  )) {
			//table Exist
		} 
		//Table does not exist
		else {
		
			$connection->query ("CREATE TABLE `email_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11),
  `recipent_name` varchar(220) DEFAULT NULL,
  `email_address` varchar(220) DEFAULT NULL,
  `subject` varchar(220) DEFAULT NULL,
  `ip` varchar(220) DEFAULT NULL,
  `city` varchar(220) DEFAULT NULL,
  `country` varchar(220) DEFAULT NULL,
  `device_info` varchar(22000) DEFAULT NULL,
  `count_open` int(11),
  `date_sent` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `first_opened` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_opened` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)  
)");
		}
?>



