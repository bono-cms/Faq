
/* Optional categories */
DROP TABLE IF EXISTS `bono_module_faq_categories`;
CREATE TABLE `bono_module_faq_categories` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `order` INT NOT NULL COMMENT 'Sort order'
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;

DROP TABLE IF EXISTS `bono_module_faq_categories_translations`;
CREATE TABLE `bono_module_faq_categories_translations` (
    `id` INT NOT NULL,
    `lang_id` INT NOT NULL COMMENT 'Language identification',
    `name` TEXT NOT NULL COMMENT 'Category name',

    FOREIGN KEY (id) REFERENCES bono_module_faq_categories(id) ON DELETE CASCADE,
    FOREIGN KEY (lang_id) REFERENCES bono_module_cms_languages(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;

/* FAQs */
DROP TABLE IF EXISTS `bono_module_faq`;
CREATE TABLE `bono_module_faq` (
    `id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `category_id` INT DEFAULT NULL COMMENT 'Attached Category ID',
    `order` INT NOT NULL COMMENT 'Sort order',
    `published` BOOLEAN NOT NULL COMMENT 'Whether is published or not',

    FOREIGN KEY (category_id) REFERENCES bono_module_faq_categories(id) DELETE SET NULL ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;

DROP TABLE IF EXISTS `bono_module_faq_translations`;
CREATE TABLE `bono_module_faq_translations` (
	`id` INT NOT NULL,
	`lang_id` INT NOT NULL COMMENT 'Language identification',
	`question` TEXT	NOT NULL COMMENT 'Question text',
	`answer` LONGTEXT NOT NULL COMMENT 'Answer text',

    FOREIGN KEY (id) REFERENCES bono_module_faq(id) ON DELETE CASCADE,
    FOREIGN KEY (lang_id) REFERENCES bono_module_cms_languages(id) ON DELETE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = UTF8;
