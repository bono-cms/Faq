
DROP TABLE IF EXISTS `bono_module_faq`;
CREATE TABLE `bono_module_faq` (

    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category_id` INT NOT NULL COMMENT 'Attached Category ID',
    `order` INT NOT NULL COMMENT 'Sort order',
    `published` varchar(1) NOT NULL COMMENT 'Whether is published or not'

) DEFAULT CHARSET = UTF8;

DROP TABLE IF EXISTS `bono_module_faq_translations`;
CREATE TABLE `bono_module_faq_translations` (

	`id` INT NOT NULL,
	`lang_id` INT NOT NULL COMMENT 'Language identification',
	`question` TEXT	NOT NULL COMMENT 'Question text',
	`answer` LONGTEXT NOT NULL COMMENT 'Answer text'

) DEFAULT CHARSET = UTF8;


DROP TABLE IF EXISTS `bono_module_faq_categories`;
CREATE TABLE `bono_module_faq_categories` (
	
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`lang_id` INT NOT NULL COMMENT 'Language identification',
	`name` TEXT NOT NULL COMMENT 'Category name',
	`order` INT NOT NULL COMMENT 'Sort order'
	
) DEFAULT CHARSET = UTF8;
