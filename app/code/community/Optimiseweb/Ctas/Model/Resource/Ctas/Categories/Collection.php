<?php

/**
 * Optimiseweb Ctas Model Resource Ctas Categories Collection
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Resource_Ctas_Categories_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
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
