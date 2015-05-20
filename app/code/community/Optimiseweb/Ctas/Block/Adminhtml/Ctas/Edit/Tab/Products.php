<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Edit Tab Products
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('products_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('in_products' => 1));
    }

    /**
     * Prepare Collection
     * 
     * @return 
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('catalog/product_collection');
        $collection->addAttributeToSelect('*');
        $id = $this->getRequest()->getParam('id');
        if (!isset($id)) {
            $id = 0;
        }
        $constraint = '{{table}}.cta_id=' . $id;
        $collection->joinField('position', 'ctas/ctas_products', 'position', 'product_id=entity_id', $constraint, 'left');
        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    /**
     * Add Column Filter To Collection
     * 
     * @param type $column
     * @return 
     */
    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare Columns
     */
    protected function _prepareColumns()
    {
        $this->addColumn('in_products', array(
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_products',
                'values' => $this->_getSelectedProducts(),
                'align' => 'center',
                'index' => 'entity_id'
        ));

        $this->addColumn('product_entity_id', array(
                'header' => Mage::helper('ctas')->__('ID'),
                'width' => 1,
                'align' => 'center',
                'index' => 'entity_id'
        ));

        $this->addColumn('product_name', array(
                'header' => Mage::helper('ctas')->__('Name'),
                'index' => 'name'
        ));

        $this->addColumn('product_sku', array(
                'header' => Mage::helper('ctas')->__('SKU'),
                'index' => 'sku'
        ));

        $this->addColumn('product_type', array(
                'header' => Mage::helper('ctas')->__('Type'),
                'width' => 1,
                'align' => 'center',
                'index' => 'type_id',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('product_attribute_set', array(
                'header' => Mage::helper('ctas')->__('Attrib. Set'),
                'width' => 1,
                'align' => 'center',
                'index' => 'attribute_set_id',
                'type' => 'options',
                'options' => $sets,
        ));

        $this->addColumn('product_status', array(
                'header' => Mage::helper('ctas')->__('Status'),
                'width' => 1,
                'align' => 'center',
                'index' => 'status',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('product_visibility', array(
                'header' => Mage::helper('ctas')->__('Visibility'),
                'width' => 1,
                'align' => 'center',
                'index' => 'visibility',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));

        $this->addColumn('product_price', array(
                'header' => Mage::helper('ctas')->__('Price'),
                'type' => 'currency',
                'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
                'index' => 'price'
        ));

        $this->addColumn('position', array(
                'header' => Mage::helper('ctas')->__('Position'),
                'name' => 'position',
                'type' => 'number',
                'validate_class' => 'validate-number',
                'index' => 'position',
                'editable' => true,
        ));
    }

    /**
     * Get Selected Products
     * 
     * @return type
     */
    protected function _getSelectedProducts()
    {
        $products = array_keys($this->getSelectedProducts());
        return $products;
    }

    /**
     * Get Selected Products
     * 
     * @return type
     */
    public function getSelectedProducts()
    {
        $id = $this->getRequest()->getParam('id');
        if (!isset($id)) {
            $id = 0;
        }
        $collection = Mage::getResourceModel('ctas/ctas_products_collection');
        $collection->addFieldToFilter('cta_id', $id);
        $productIds = array();
        foreach ($collection as $product) {
            $productIds[$product->getProductId()] = array('position' => $product->getPosition());
        }
        return $productIds;
    }

    /**
     * Get Row URL
     * 
     * @param type $item
     * @return string
     */
    public function getRowUrl($item)
    {
        return '#';
    }

    /**
     * Get Grid URL
     * 
     * @return type
     */
    public function getGridUrl()
    {
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/productsgrid', array('id' => $this->getRequest()->getParam('id'), '_current' => TRUE));
    }

    /**
     * Prepare Mass Action
     * 
     * @return 
     */
    protected function _prepareMassaction()
    {
        return $this;
    }

}
