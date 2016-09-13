CREATE TABLE `testdb`.`sale_item` (
  `id` INT UNSIGNED auto_increment NOT NULL,
  `title` VARCHAR(255) NULL,
  `price_old` INT UNSIGNED NULL,
  `price_new` INT UNSIGNED NULL,
  `link` VARCHAR(255) NULL,
  `hash` VARCHAR(32) NULL,
  `date_insert` DATE NULL,
  PRIMARY KEY (`id`))
 DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

