<?php

/**
 * Optimiseweb Ctas Installer
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('ctas')};

CREATE TABLE {$this->getTable('ctas')} (
	`cta_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`identifier` VARCHAR(255) NOT NULL,
	`description` VARCHAR(255) NULL DEFAULT NULL,
	`image` VARCHAR(255) NULL DEFAULT NULL,
	`alt` VARCHAR(255) NULL DEFAULT NULL,
	`title` VARCHAR(255) NULL DEFAULT NULL,
	`url` VARCHAR(255) NULL DEFAULT NULL,
	`heading` VARCHAR(255) NULL DEFAULT NULL,
	`cta_content` TEXT NULL,
	`external` SMALLINT(6) NOT NULL DEFAULT '0',
	`status` SMALLINT(6) NOT NULL DEFAULT '1',
	`start_date` DATETIME NULL DEFAULT NULL,
	`end_date` DATETIME NULL DEFAULT NULL,
	`created_time` DATETIME NULL DEFAULT NULL,
	`update_time` DATETIME NULL DEFAULT NULL,
	PRIMARY KEY (`cta_id`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;
");

$installer->endSetup();
