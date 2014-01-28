<?php

/**
 * Optimiseweb Ctas Installer
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$installer = $this;

$installer->startSetup();

$installer->run("

ALTER TABLE {$this->getTable('ctas')} ADD COLUMN `store_ids` VARCHAR(255) NULL DEFAULT '0' AFTER `identifier`;

");

$installer->endSetup();
