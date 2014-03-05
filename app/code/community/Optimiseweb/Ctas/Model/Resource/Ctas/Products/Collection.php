<?php

/**
 * Optimiseweb Ctas Model Resource Ctas Products Collection
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Resource_Ctas_Products_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ctas/ctas_products');
    }

    /**
     * Join Ctas
     * 
     * @param type $storeFilter
     * @param type $storeId
     * @return 
     */
    public function joinCtas($storeFilter = FALSE, $storeId = NULL)
    {
        $this->getSelect()->order('position ASC');
        $this->getSelect()->join(array('ctas_table' => Mage::getSingleton('core/resource')->getTableName('ctas/ctas')), 'ctas_table.cta_id = main_table.cta_id', array('ctas_table.*'));
        if ($storeFilter) {
            $this->_addStoreFilter($storeId);
        }
        return $this;
    }

    /**
     * Add Store Filter
     * 
     * @param type $store
     * @param type $withAdmin
     * @return 
     */
    protected function _addStoreFilter($store = NULL, $withAdmin = TRUE)
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
     * Add Product Filter
     * 
     * @param type $productId
     * @return 
     */
    public function addProductFilter($productId = NULL)
    {
        if (!is_null($productId)) {
            $this->addFieldToFilter('product_id', $productId);
        }
        return $this;
    }

    /**
     * Add Cta Filter
     * 
     * @param type $ctaId
     * @return 
     */
    public function addCtaFilter($ctaId = NULL)
    {
        if (!is_null($ctaId)) {
            $this->addFieldToFilter('main_table.cta_id', $ctaId);
        }
        return $this;
    }

    /**
     * Get Identifiers Array
     * 
     * @return type
     */
    public function getIdentifiersArray()
    {
        $identifiers = array();
        $i = 0;
        foreach ($this as $cta) {
            $identifiers[$i] = $cta->getIdentifier();
            $i++;
        }
        return $identifiers;
    }

    /**
     * Get Identifiers Position Array
     * 
     * @return type
     */
    public function getIdentifiersPositionArray()
    {
        $identifiers = array();
        $i = 0;
        foreach ($this as $cta) {
            $identifiers[$i]['identifier'] = $cta->getIdentifier();
            $identifiers[$i]['position'] = $cta->getPosition();
            $i++;
        }
        return $identifiers;
    }

}
