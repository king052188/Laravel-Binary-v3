DROP TABLE IF EXISTS `user_activation_code`;
CREATE TABLE `user_activation_code` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `reference` varchar(50) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `amount` decimal(18,2) DEFAULT NULL,
  `generated_by` int(11) DEFAULT NULL,
  `generated_for` int(11) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `user_genealogy_summary`;
CREATE TABLE `user_genealogy_summary` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `member_uid` varchar(30) DEFAULT NULL,
  `position_id` tinyint(4) DEFAULT NULL,
  `type_id` tinyint(4) DEFAULT NULL,
  `points` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_genealogy_transaction`;
CREATE TABLE `user_genealogy_transaction` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction` varchar(50) DEFAULT NULL,
  `sponsor_id` varchar(30) DEFAULT NULL,
  `placement_id` varchar(30) DEFAULT NULL,
  `member_uid` varchar(30) DEFAULT NULL,
  `activation_code` varchar(10) DEFAULT NULL,
  `position_` tinyint(4) DEFAULT NULL,
  `status_` tinyint(4) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `user_wallet`;
CREATE TABLE `user_wallet` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `member_uid` varchar(30) DEFAULT NULL,
  `t_number` varchar(30) DEFAULT NULL,
  `t_description` varchar(500) DEFAULT NULL,
  `t_type` tinyint(2) DEFAULT NULL,
  `t_role` tinyint(1) DEFAULT NULL,
  `t_amount` decimal(18,2) DEFAULT NULL,
  `t_status` tinyint(2) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `member_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_uid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fb_primary_photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `streets` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connected_to` int(11) NOT NULL,
  `activation_id` int(11) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_user_token_unique` (`user_token`),
  UNIQUE KEY `users_member_uid_unique` (`member_uid`),
  UNIQUE KEY `users_fb_uid_unique` (`fb_uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'570ba9b8e185cae072abc5843cc55124','8011-2120-0000-0000',NULL,NULL,'king.a','$2y$10$LnrolhQ42OQTjh3hRWZCjO.prBjMetyCowzV0v7NJewWaQLZmuvzO','king paulo','aquino',NULL,NULL,NULL,'king@gmail.com','09177715380',0,0,20,2,'9UE6eS9tJjWHYLQY36keyWA2h7EWjrBUD6qT5oUvDIJjCpByhFRac6tyHI0d','2017-11-28 18:55:50','2017-11-28 18:55:50'),(2,'acecbe4619c788e7381b5e6f4d2d5bd0','8011-2165-3432-2157',NULL,NULL,'mark.f','$2y$10$btriHH.N88ZUyBA6Ma99YeDzZ6wm.hRLF1Y3ihAcEU8gXkPODfXSO','mark','fernandezm',NULL,NULL,NULL,'mark@gmail.com','1213233232',1,0,2,2,'THEPr42QYgIZal0jWXb2LDvUSmfTTuUowUMa5h1cElCHbvsM7nc4yXcnA338','2017-11-20 19:55:43','2017-11-20 19:55:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;


