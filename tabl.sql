CREATE TABLE `sale_item` (
  `id` INT UNSIGNED auto_increment NOT NULL,
  `title` VARCHAR(255) NULL,
  `image` VARCHAR(255) NULL,
  `price_old` INT UNSIGNED NULL,
  `price_new` INT UNSIGNED NULL,
  `price_diff` INT UNSIGNED NULL,
  `link` VARCHAR(255) NULL,
  `hash` VARCHAR(32) NULL,
  `host` VARCHAR(64) NULL,
  `date_insert` DATETIME NULL,
  PRIMARY KEY (`id`),
 KEY `hash` (`hash`))
 DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;


CREATE TABLE `sale_tag` (
  `id` INT UNSIGNED auto_increment NOT NULL,
  `parent_id`  INT UNSIGNED NULL,
  `title` VARCHAR(255) NULL,
   FOREIGN KEY (`parent_id`) REFERENCES sale_tag(`id`),
  PRIMARY KEY (`id`)) 
 DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;


CREATE TABLE `sale_tag_item` (
  `id` INT UNSIGNED auto_increment NOT NULL,
  `tag_id`  INT UNSIGNED NULL,
  `item_id`  INT UNSIGNED NULL,
   
   FOREIGN KEY (`tag_id`) REFERENCES sale_tag(`id`),
   FOREIGN KEY (`item_id`) REFERENCES sale_item(`id`),
  PRIMARY KEY (`id`)) 
 DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

