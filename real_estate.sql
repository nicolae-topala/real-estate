/*
SQLyog Community v13.1.7 (64 bit)
MySQL - 8.0.23 : Database - real-estate
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`real-estate` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `real-estate`;

/*Table structure for table `ad_types` */

DROP TABLE IF EXISTS `ad_types`;

CREATE TABLE `ad_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `ad_types` */

insert  into `ad_types`(`id`,`name`) values 
(1,'Apartment'),
(2,'House'),
(3,'Infield');

/*Table structure for table `advertisements` */

DROP TABLE IF EXISTS `advertisements`;

CREATE TABLE `advertisements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `title` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `description_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_advertisements_admin` (`admin_id`),
  KEY `fk_advertisements_descriptions` (`description_id`),
  CONSTRAINT `fk_advertisements_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_advertisements_descriptions` FOREIGN KEY (`description_id`) REFERENCES `descriptions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=146 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `advertisements` */

insert  into `advertisements`(`id`,`admin_id`,`title`,`date`,`description_id`) values 
(1,1,'Cool apartment','2021-03-14 20:48:35',1),
(126,1,'New apartment in Illidza','2021-06-07 08:10:27',213129),
(127,1,'NEED MONEY ! SELLING APARTMENT','2021-06-07 08:25:49',213130),
(128,1,'very cheap ! call me','2021-06-07 08:30:51',213130),
(129,1,'Selling apartment with 4 rooms','2021-06-07 08:34:33',213131),
(130,1,'Apartment 42.6 m2...= 19.150 dollars... ','2021-06-07 08:37:56',213132),
(131,1,'Superb apartment directly from the owner !!!','2021-06-07 08:43:25',213133),
(132,1,'3-room apartment, new, autonomous furniture','2021-06-07 08:49:45',213134),
(133,1,'Apartment','2021-06-07 08:56:05',213135),
(134,1,'Great AD !','2021-06-07 20:22:51',213136),
(135,1,'New ad','2021-06-07 20:25:46',213137),
(136,1,'Great apartment','2021-06-07 21:03:08',213138),
(137,1,'Empty AD','2021-06-10 10:56:47',213139),
(139,1,'Beatiful House','2021-06-10 13:55:05',213141),
(140,1,'Infield for construction','2021-06-10 14:03:21',213142),
(141,99,'1 room 32 M2, floor 1/4','2021-06-10 14:16:30',213143),
(142,99,'str. Drumul Crucii, Buiucani, 1 room!','2021-06-10 14:22:07',213144),
(143,99,'Melestiu 22/2, new block, Eurorepair, Botany','2021-06-10 14:28:08',213145),
(144,99,'Apartment for sale with 2 rooms','2021-06-10 14:32:38',213146),
(145,99,'4 room apartment for sale','2021-06-10 14:38:29',213147);

/*Table structure for table `descriptions` */

DROP TABLE IF EXISTS `descriptions`;

CREATE TABLE `descriptions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `address` varchar(124) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_id` int NOT NULL,
  `type_id` int NOT NULL,
  `price` int NOT NULL,
  `floor` tinyint DEFAULT NULL,
  `space` int DEFAULT NULL,
  `rooms` tinyint DEFAULT NULL,
  `text` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail_id` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_descriptions_type` (`type_id`),
  KEY `fk_descriptions_locations` (`location_id`),
  KEY `fk_descriptions_thumbnail_id` (`thumbnail_id`),
  CONSTRAINT `fk_descriptions_locations` FOREIGN KEY (`location_id`) REFERENCES `locations` (`id`),
  CONSTRAINT `fk_descriptions_thumbnail_id` FOREIGN KEY (`thumbnail_id`) REFERENCES `photos` (`id`),
  CONSTRAINT `fk_descriptions_type` FOREIGN KEY (`type_id`) REFERENCES `ad_types` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=213148 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `descriptions` */

insert  into `descriptions`(`id`,`address`,`location_id`,`type_id`,`price`,`floor`,`space`,`rooms`,`text`,`thumbnail_id`) values 
(1,'Street nr.4',1,1,2500,8,65,3,'The best appartment',1),
(213129,'Ibrahima Hafiza Ridžanovića 24',1,1,40000,1,65,2,'This is a nice apartment, out of the city noisiness ! Please contact me by my phone number.',81),
(213130,'Butmirska cesta 58, Ilidža 71214',1,1,13456,4,40,1,'Call me for info !',1),
(213131,'bd. Grigore Vieru 5',3,1,90000,2,80,4,'I am selling a 4-room apartment in the center of Chisinau. The apartment is on two levels:\r\n1 level:\r\n-salon\r\n-kitchen\r\n-sanitary block\r\nLevel 2:\r\n-2 bedrooms\r\n-guest room\r\n-bathroom',84),
(213132,'str. Cartușa 93',3,1,19150,9,43,2,'The residential block will be thermally insulated with mineral wool and polystyrene.\r\n\r\n  KLEEMAN super-quiet elevator.\r\n\r\n  In the courtyard of the apartment building will be arranged a playground for children.\r\n  The complex has storage rooms, underground parking and storage\r\n\r\n  Commissioning - third quarter 2022.',88),
(213133,'str. Bogdan Voievod 42',3,1,123568,6,75,2,'we offer an apartment in a new building located on Bogdan Voievod Street, in the immediate vicinity of: Pan-Com. The property is presented with individual design and premium quality finishes, the total area of the apartment is 75 m2 and is divided into: 2 bedrooms, living room, kitchen, bathroom. - individual design - double-glazed windows with 2 rows of glass - central heating - metal door - the warm floor is covered with tiles and parquet - video surveillance - secure access - air conditioning - It has underground parking and closet (sold separately) we are waiting to watch!',92),
(213134,'str. Vasile Vărzaru 21',3,1,55700,4,68,3,'We offer for sale a 3-room apartment, located in sect. Hammer.\r\nArea with well-developed infrastructure.\r\nThe total area of 68 m2, series 102.\r\nIn the immediate vicinity of: park, kindergarten, school, market, sports club, bank, pharmacy, etc.',1),
(213135,'str. Mirce acel Batrin 21',3,1,80500,4,84,2,'',97),
(213136,'address',3,1,123435,2,43,1,'TEST TEST TEST TEST TEST ',1),
(213137,'Middle of city',3,1,543660,4,56,2,'',1),
(213138,'Trying new stuff',3,1,54360,2,123,5,'',1),
(213139,'0',1,1,0,0,0,0,'',1),
(213141,'Near Sarajevo',1,2,500000,0,250,10,'Great location.\r\nWe offer for sale this house on 2 levels located with a total area of 200 sqm + 7.5ari.\r\nCompartmented into:\r\nI Level - hall, wardrobe, kitchen, living room with exit to the summer terrace, bathroom and a bedroom\r\nLevel II - 3 bedrooms, hall, bathroom, 2 balconies.\r\nGarage.\r\nCellar\r\nFeatures and finishes:\r\n* German double glazed windows Premium class\r\n* Alba variant\r\n* autonomous heating (warm floors)\r\n* connected to all communications;\r\n* is in the immediate vicinity of: kindergarten, school, market, cafes, bank, pharmacies, etc.\r\nEasy access to public transport in any direction\r\n\r\n',101),
(213142,'Outside Sarajevo',1,3,500000,0,15000,0,'The land has direct access to:\r\nAqueduct!\r\nGas pipeline!\r\nElectricity!\r\nSewerage!',103),
(213143,'Sarmisegetusa 32',3,1,24800,1,32,1,'One bedroom apartment, floor 1-4, 32 M2, recently finished repair, partially furnished!\r\nNear the park lazo and roses\r\nFor details, call 078450542\r\nThe price is only discussed on the spot,',107),
(213144,'Drumul Crucii 99 Drumul Crucii 99',3,1,21700,5,34,1,'For sale apartment in block of flats series 102, located in the Buiucani sector, Drumul Crucii street! The property is divided into: 1 room, kitchen, balcony, bathroom and hall.',112),
(213145,'str. Melestiu Street 22/2',3,1,68250,9,722,3,'For your attention, we offer for sale a spacious and bright apartment, individually planned in Chisinau, 2 rooms + living room, with a total area of 72 m2, located just a few steps away from Valea Trandafirilor Park, Melestiu Street 22/2, Center sector. ',118),
(213146,'str. Hâncești 142',3,1,39950,2,63,2,'Finishing version - White version, with double glazing and armored door at the entrance. Autonomous heating on the apartment, with boiler and radiators installed.',120),
(213147,'Ciocana , str. Igor Vieru 14',3,1,57500,1,120,4,'Landscaping:\r\n\r\n     1. Open parking.\r\n     2. There are several commercial spaces on the ground floor.\r\n     3. Sports and play area (recreation area).',128);

/*Table structure for table `locations` */

DROP TABLE IF EXISTS `locations`;

CREATE TABLE `locations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `locations` */

insert  into `locations`(`id`,`name`) values 
(1,'Sarajevo'),
(2,'Bucharest'),
(3,'Chisinau'),
(4,'London'),
(5,'Paris');

/*Table structure for table `photos` */

DROP TABLE IF EXISTS `photos`;

CREATE TABLE `photos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `description_id` int NOT NULL,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_photos_descriptions` (`description_id`),
  CONSTRAINT `fk_photos_descriptions` FOREIGN KEY (`description_id`) REFERENCES `descriptions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `photos` */

insert  into `photos`(`id`,`description_id`,`name`) values 
(1,1,'default.png'),
(80,213129,'UwogMQdV6WGNrTZk.png'),
(81,213129,'EuLKW85SI4YNjkPC.png'),
(82,213129,'qDaeZW0w2Fc5K8GA.png'),
(83,213131,'dg8tOirJSnKeuHwv.png'),
(84,213131,'fqyozlVZrNvLCk9R.png'),
(85,213131,'fsVTQxDzanq0IS2p.png'),
(86,213131,'Gd3cKoINU69WYZe8.png'),
(87,213132,'basZg32vpLeXyn4t.png'),
(88,213132,'LOlMK750CQJbBP1p.png'),
(89,213132,'loyDmv2tjERqiPAa.png'),
(90,213132,'ODTYQmxZHjM8vA0L.png'),
(91,213133,'MSLxjyXs1chBKZ8W.png'),
(92,213133,'YcTsWf542UkiJw1C.png'),
(93,213133,'EY8ArZxDONG67IJc.png'),
(94,213133,'TtmeyniUIR8Qhxsb.png'),
(95,213133,'DbdOVhPy6vQfMS8w.png'),
(96,213133,'olHpsZ7YbQ4ijSve.png'),
(97,213135,'3zyTNCqlFdVxZp4Q.png'),
(98,213135,'dAu8bQHKRVFo0Wnz.png'),
(99,213135,'2hJncQtisvkm6Y4V.png'),
(100,213135,'girve9Gd0REyx8LJ.png'),
(101,213141,'jPU7oz3IcyXRFJT6.png'),
(102,213142,'7CpmugWdiJ5aFrw8.png'),
(103,213142,'81u3SZpU4OJDhfxc.png'),
(104,213142,'rYj1l9M7nXVF842O.png'),
(105,213143,'QvJRelYVoyT81jxA.png'),
(106,213143,'B1OyZeXwE8tiznNl.png'),
(107,213143,'mBzaxc5hI9l2w8Fj.png'),
(108,213143,'lqxLN193roi4TMDp.png'),
(109,213143,'Zi1VlhGatKdFON34.png'),
(110,213144,'9o51BDnWCi8QdwEF.png'),
(111,213144,'3zQBMv0lUkjDCqV1.png'),
(112,213144,'Axwc8fFNLV2YQ4GP.png'),
(113,213144,'RzyqBQkeU9gLTI81.png'),
(114,213145,'cZ2HxoUmpbuNnvDJ.png'),
(115,213145,'p5GmqvnPz6J7F2g4.png'),
(116,213145,'IuEgv6SNAMO0qLPr.png'),
(117,213145,'rsalvm9zWqcHwbAF.png'),
(118,213145,'5P9jUZ2VfbizIuL4.png'),
(119,213146,'sVmoSX6zt4923cQZ.png'),
(120,213146,'jTEm4D1hrsz3IgBQ.png'),
(121,213146,'nji1fE4L2kbKpvNy.png'),
(122,213146,'wCEAHGv2jkD0ST8r.png'),
(123,213146,'boPNkh3tRYVg8zHf.png'),
(124,213147,'tUJiIS5s4wbkMVZq.png'),
(125,213147,'NL0HUTvCAimXZOcK.png'),
(126,213147,'vhSuB9o8WCAp67nZ.png'),
(127,213147,'kTirYKMo4aN7lWVQ.png'),
(128,213147,'f6adKusngMJY9elm.png');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `first_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_level` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `token` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'PENDING',
  `token_created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`first_name`,`last_name`,`email`,`password`,`telephone`,`admin_level`,`created_at`,`token`,`status`,`token_created_at`) values 
(1,'Nicolae','Topala','proawp5415@gmail.com','202cb962ac59075b964b07152d234b70','3248975',1,'2021-03-20 13:15:43',NULL,'ACTIVE','2021-06-10 10:56:46'),
(99,'Test','Test','test@real-estate.live','202cb962ac59075b964b07152d234b70','123',0,'2021-06-10 14:10:02',NULL,'ACTIVE',NULL);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
