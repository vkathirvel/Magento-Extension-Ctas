<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Edit Tab Categories
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Edit_Tab_Categories extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Categories
{

    /**
     * 
     * @return type
     */
    protected function getCategoryIds()
    {
        return $this->getSelectedCategories();
    }

    /**
     * 
     * @return type
     */
    public function isReadonly()
    {
        return false;
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
            $categoryIds[] = $category->getCategoryId();
        }
        return $categoryIds;
    }

}
