<?php

/**
 * Optimiseweb Ctas Model Mysql4 Ctas Collection
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Mysql4_Ctas_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ctas/ctas');
    }

    /**
     * Add Store Filter
     * 
     * @param type $store
     * @param type $withAdmin
     * @return 
     */
    public function addStoreFilter($store = NULL, $withAdmin = TRUE)
    {
        if (is_null($store)) {
            $store = Mage::app()->getStore()->getStoreId();
        }
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }
        if (!is_array($store)) {
            $store = array($store);
        }
        if ($withAdmin) {
            $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
        }
        $this->addFieldToFilter('store_ids', array('in' => $store));
        return $this;
    }

    /**
     * Add Identifier Filter
     * 
     * @param type $identifier
     * @return 
     */
    public function addIdentifierFilter($identifier = NULL)
    {
        if (!is_null($identifier)) {
            $this->addFieldToFilter('main_table.identifier', array('eq' => $identifier));
        }
        return $this;
    }

}
