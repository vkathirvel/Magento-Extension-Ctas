<?php

/**
 * Optimiseweb Ctas Model Mysql4 Ctas
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Mysql4_Ctas extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        $this->_init('ctas/ctas', 'cta_id');
    }

    /**
     * Retrieve load select with filter by identifier, store and activity
     *
     * @param type $identifier
     * @return type
     */
    protected function _getLoadByIdentifierSelect($identifier)
    {
        $select = $this->_getReadAdapter()->select()->from(array('cta' => $this->getMainTable()))->where('cta.identifier = ?', $identifier);
        return $select;
    }

    /**
     * Process data before saving
     *
     * @param Mage_Core_Model_Abstract $object
     * @return type
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if (!$this->getIsUniqueIdentifier($object)) {
            Mage::throwException(Mage::helper('ctas')->__('Identifier already exists.'));
        }
        if (!$this->isValidIdentifier($object)) {
            Mage::throwException(Mage::helper('ctas')->__('The Identifier contains capital letters or disallowed symbols.'));
        }
        if ($this->isNumericIdentifier($object)) {
            Mage::throwException(Mage::helper('ctas')->__('The Identifier cannot consist only of numbers.'));
        }
        return parent::_beforeSave($object);
    }

    /**
     * Check for unique identifier
     *
     * @param Mage_Core_Model_Abstract $object
     * @return boolean
     */
    public function getIsUniqueIdentifier(Mage_Core_Model_Abstract $object)
    {
        $select = $this->_getLoadByIdentifierSelect($object->getData('identifier'));

        $storeIds = explode(',', $object->getStoreIds());

        if ($object->getId()) {
            $select->where('cta.cta_id <> ?', $object->getId());
        }

        if ($this->_getWriteAdapter()->fetchAll($select)) {
            $query_results = $this->_getWriteAdapter()->fetchAll($select);

            foreach ($query_results as $query_result) {
                $fetchedStoreIds = explode(',', $query_result['store_ids']);

                foreach ($storeIds as $storeId) {
                    if (($storeId == '0') OR in_array('0', $fetchedStoreIds) OR in_array($storeId, $fetchedStoreIds)) {
                        return false;
                    }
                }
            }
        }
        return true;
    }

    /**
     *  Check whether identifier is numeric
     *
     * @param Mage_Core_Model_Abstract $object
     * @return type
     */
    protected function isNumericIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[0-9]+$/', $object->getData('identifier'));
    }

    /**
     *  Check whether identifier is valid
     *
     * @param Mage_Core_Model_Abstract $object
     * @return type
     */
    protected function isValidIdentifier(Mage_Core_Model_Abstract $object)
    {
        return preg_match('/^[a-z0-9][a-z0-9_\/-]+(\.[a-z0-9_-]+)?$/', $object->getData('identifier'));
    }

    /**
     * Retrieves CTA from DB by passed identifier.
     *
     * @param string $identifier
     * @return string|false
     */
    public function loadByIdentifier(Mage_Core_Model_Abstract $object,
                                     $identifier)
    {
        $select = $this->_getLoadByIdentifierSelect($identifier);

        $query_results = $this->_getWriteAdapter()->fetchAll($select);

        $ctaId = FALSE;

        foreach ($query_results as $query_result) {
            $fetchedStoreIds = explode(',', $query_result['store_ids']);

            foreach ($fetchedStoreIds as $fetchedStoreId) {
                if (($fetchedStoreId == '0') OR ( $fetchedStoreId == Mage::app()->getStore()->getId())) {
                    $ctaId = $query_result['cta_id'];
                }
            }
        }
        //$ctaId = $this->_getReadAdapter()->fetchOne($select);
        if ($ctaId) {
            $this->load($object, $ctaId);
            return $this;
        } else {
            return FALSE;
        }
    }

}
