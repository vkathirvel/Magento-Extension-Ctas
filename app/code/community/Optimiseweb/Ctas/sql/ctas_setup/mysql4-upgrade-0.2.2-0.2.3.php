<?php

/**
 * Optimiseweb Ctas Installer
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
$table = $this->getConnection()
    ->newTable($this->getTable('ctas/ctas_products'))
    ->addColumn('rel_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'identity' => true,
            'nullable' => false,
            'primary' => true,
        ), 'Relation ID')
    ->addColumn('cta_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',
        ), 'CTA ID')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned' => true,
            'nullable' => false,
            'default' => '0',
        ), 'Product ID')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'nullable' => false,
            'default' => '0',
        ), 'Position')
    ->addIndex($this->getIdxName('ctas/ctas_products', array('product_id')), array('product_id'))
    ->addForeignKey($this->getFkName('ctas/ctas_products', 'cta_id', 'ctas/ctas', 'cta_id'), 'cta_id', $this->getTable('ctas/ctas'), 'cta_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey($this->getFkName('ctas/ctas_products', 'product_id', 'catalog/product', 'entity_id'), 'product_id', $this->getTable('catalog/product'), 'entity_id', Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->setComment('CTAs to Products Linkage Table');
$this->getConnection()->createTable($table);
