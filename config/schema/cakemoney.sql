CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `account` int(11) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
);

CREATE TABLE `journals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `debit_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `description` text,
  `asset` int(11) NOT NULL,
  `liability` int(11) NOT NULL,
  `income` int(11) NOT NULL,
  `expense` int(11) NOT NULL,
  `equity` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `day` int(11) NOT NULL,
  `week` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `templates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `debit_id` int(11) NOT NULL,
  `credit_id` int(11) NOT NULL,
  `amount` int(11),
  `summary` varchar(255),
  `description` text,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
);
