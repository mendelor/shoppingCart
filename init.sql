CREATE DATABASE mydb;
USE mydb;
CREATE TABLE IF NOT EXISTS `products` ( `id` int(10) NOT NULL AUTO_INCREMENT, `name` varchar(250) NOT NULL, `code` varchar(100) NOT NULL, `price` double(9,3) NOT NULL, `image` varchar(250) NOT NULL, PRIMARY KEY (`id`), UNIQUE KEY `code` (`code`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `products` (`name`, `code`, `price`, `image`) VALUES  ('Sledgehammer', 'aaa', 125.75, 'product-images/1.jpg'), ('Axe', 'bbb', 190.50, 'product-images/2.jpg'), ('Bandsaw', 'ccc', 562.131, 'product-images/3.jpg'), ('Chisel', 'ddd', 12.9, 'product-images/4.jpg'), ('Hacksaw', 'eee', 18.45, 'product-images/5.jpg');
