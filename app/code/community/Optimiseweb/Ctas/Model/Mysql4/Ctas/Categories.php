<?php

/**
 * Optimiseweb Ctas Model Mysql4 Ctas Categories
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Mysql4_Ctas_Categories extends Mage_Core_Model_Mysql4_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        $this->_init('ctas/ctas_categories', 'rel_id');
    }

}
