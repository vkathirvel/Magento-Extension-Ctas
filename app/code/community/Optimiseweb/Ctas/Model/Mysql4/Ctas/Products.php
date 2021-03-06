<?php

/**
 * Optimiseweb Ctas Model Mysql4 Ctas Products
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Mysql4_Ctas_Products extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        $this->_init('ctas/ctas_products', 'rel_id');
    }

}
