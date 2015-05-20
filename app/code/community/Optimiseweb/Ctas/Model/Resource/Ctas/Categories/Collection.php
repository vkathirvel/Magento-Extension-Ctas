<?php

/**
 * Optimiseweb Ctas Model Resource Ctas Categories Collection
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Resource_Ctas_Categories_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     *
     */
    protected $_joinCtas = false;

    /**
     * Construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ctas/ctas_categories');
    }

    /**
     * Join Ctas
     * 
     * @return 
     */
    public function joinCtas()
    {
        if (!$this->_joinCtas) {
            $this->getSelect()->join(
                array('ctas_table' => Mage::getSingleton('core/resource')->getTableName('ctas/ctas')), 'ctas_table.cta_id = main_table.cta_id', array('ctas_table.*')
            );
            $this->_joinCtas = true;
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
        $store_ids = array();
        foreach ($store as $store_id) {
            $store_ids[] = array('eq' => $store_id);
            $store_ids[] = array('like' => '%,' . $store_id . ',%');
            $store_ids[] = array('like' => $store_id . ',%');
            $store_ids[] = array('like' => '%,' . $store_id);
        }
        if (count($store_ids) > 0) {
            $this->addFieldToFilter('ctas_table.store_ids', array($store_ids));
        }
        return $this;
    }

    /**
     * Add Cta Filter
     * 
     * @param type $ctaIds
     * @return 
     */
    public function addCtaFilter($ctaIds = NULL)
    {
        if (!$this->_joinCtas) {
            $this->joinCtas();
        }
        if (!is_null($ctaIds) AND ! is_array($ctaIds)) {
            $ctaIds = array($ctaIds);
        }
        if (!is_null($ctaIds)) {
            $this->addFieldToFilter('main_table.cta_id', array('in' => $ctaIds));
        }
        return $this;
    }

    /**
     * Add Category Filter
     * 
     * @param type $categoryId
     * @return 
     */
    public function addCategoryFilter($categoryIds = NULL)
    {
        if (!$this->_joinCtas) {
            $this->joinCtas();
        }
        if (!is_null($categoryIds) AND ! is_array($categoryIds)) {
            $categoryIds = array($categoryIds);
        }
        if (!is_null($categoryIds)) {
            $this->addFieldToFilter('main_table.category_id', array('in' => $categoryIds));
        }
        return $this;
    }

    /**
     * Get Ctas Identifiers Array
     * 
     * @return type
     */
    public function getCtasIdentifiersArray()
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
     * Get Ctas Identifiers and Position Array
     * 
     * @return type
     */
    public function getCtasIdentifiersAndPositionsArray()
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
