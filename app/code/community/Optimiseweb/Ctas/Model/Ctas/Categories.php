<?php

/**
 * Optimiseweb Ctas Model Ctas Categories
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Ctas_Categories extends Mage_Core_Model_Abstract
{

    /**
     * Construct
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ctas/ctas_categories');
    }

}
