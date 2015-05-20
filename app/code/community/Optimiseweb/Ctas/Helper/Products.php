<?php

/**
 * Optimiseweb Ctas Helper Products
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Helper_Products extends Optimiseweb_Ctas_Helper_Data
{

    public function getCtasIdentifiersArray()
    {
        if (Mage::registry('current_product')) {
            $collection = Mage::getModel('ctas/ctas_products')->getCollection()->joinCtas()->addStoreFilter()->setOrder('position', 'ASC')->addProductFilter(Mage::registry('current_product')->getId());
            $ctasIdentifiersArray = $collection->getCtasIdentifiersArray();
            if (count($ctasIdentifiersArray) > 0) {
                return $ctasIdentifiersArray;
            }
        }
        return FALSE;
    }

}
