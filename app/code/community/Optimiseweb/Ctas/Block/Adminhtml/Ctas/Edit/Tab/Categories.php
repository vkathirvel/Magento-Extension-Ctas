<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Edit Tab Categories
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Edit_Tab_Categories extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('categories_grid');
        $this->setDefaultSort('position');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setDefaultFilter(array('in_categories' => 1));
    }

    /**
     * Prepare Collection
     * 
     * @return 
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('catalog/category_collection');
        $collection->addAttributeToSelect('*');
        $id = $this->getRequest()->getParam('id');
        if (!isset($id)) {
            $id = 0;
        }
        $constraint = '{{table}}.cta_id=' . $id;
        $collection->joinField('position', 'ctas/ctas_categories', 'position', 'category_id=entity_id', $constraint, 'left');
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
        if ($column->getId() == 'in_categories') {
            $categoryIds = $this->_getSelectedCategories();
            if (empty($categoryIds)) {
                $categoryIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $categoryIds));
            } else {
                if ($categoryIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $categoryIds));
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
        $this->addColumn('in_categories', array(
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_categories',
                'values' => $this->_getSelectedCategories(),
                'align' => 'center',
                'index' => 'entity_id'
        ));

        $this->addColumn('category_entity_id', array(
                'header' => Mage::helper('ctas')->__('ID'),
                'width' => 1,
                'align' => 'center',
                'index' => 'entity_id'
        ));

        $this->addColumn('category_name', array(
                'header' => Mage::helper('ctas')->__('Name'),
                'index' => 'name'
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
     * Get Selected Categories
     * 
     * @return type
     */
    protected function _getSelectedCategories()
    {
        $categories = array_keys($this->getSelectedCategories());
        return $categories;
    }

    /**
     * Get Selected Categories
     * 
     * @return type
     */
    public function getSelectedCategories()
    {
        $id = $this->getRequest()->getParam('id');
        if (!isset($id)) {
            $id = 0;
        }
        $collection = Mage::getResourceModel('ctas/ctas_categories_collection');
        $collection->addFieldToFilter('cta_id', $id);
        $categoryIds = array();
        foreach ($collection as $category) {
            $categoryIds[$category->getCategoryId()] = array('position' => $category->getPosition());
        }
        return $categoryIds;
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
        return $this->_getData('grid_url') ? $this->_getData('grid_url') : $this->getUrl('*/*/categoriesgrid', array('id' => $this->getRequest()->getParam('id'), '_current' => TRUE));
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
