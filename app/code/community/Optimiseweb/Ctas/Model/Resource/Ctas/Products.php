<?php

/**
 * Optimiseweb Ctas Model Resource Ctas Products
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Resource_Ctas_Products extends Mage_Core_Model_Resource_Db_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        $this->_init('ctas/ctas_products', 'rel_id');
    }

}
