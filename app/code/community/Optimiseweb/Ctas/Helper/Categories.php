<?php

/**
 * Optimiseweb Ctas Helper Categories
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Helper_Categories extends Optimiseweb_Ctas_Helper_Data
{

    public function getCtasIdentifiersArray()
    {
        if (Mage::registry('current_category')) {
            $collection = Mage::getModel('ctas/ctas_categories')->getCollection()->joinCtas()->addStoreFilter()->setOrder('position', 'ASC')->addCategoryFilter(Mage::registry('current_category')->getId());
            $ctasIdentifiersArray = $collection->getCtasIdentifiersArray();
            if (count($ctasIdentifiersArray) > 0) {
                return $ctasIdentifiersArray;
            }
        }
        return FALSE;
    }

}
