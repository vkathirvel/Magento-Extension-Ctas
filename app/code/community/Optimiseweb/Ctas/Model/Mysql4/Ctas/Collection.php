<?php

/**
 * Optimiseweb Ctas Model Mysql4 Ctas Collection
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Mysql4_Ctas_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{

    /**
     *
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ctas/ctas');
    }

}
