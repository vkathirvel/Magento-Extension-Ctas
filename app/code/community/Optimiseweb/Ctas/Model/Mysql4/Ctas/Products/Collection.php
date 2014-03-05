<?php

/**
 * Optimiseweb Ctas Model Mysql4 Ctas Products Collection
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Mysql4_Ctas_Products_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ctas/ctas_products');
    }

    public function withCtaData($productId)
    {
        $this->addFieldToFilter('product_id', $productId);
        $this->getSelect()->order('position ASC');
        $this->getSelect()->join(array('ctas_table' => Mage::getSingleton('core/resource')->getTableName('ctas/ctas')), 'ctas_table.cta_id = main_table.cta_id', array('ctas_table.*'));
        return $this;
    }

}
