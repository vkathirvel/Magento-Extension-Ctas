<?php

/**
 * Optimiseweb Ctas Model Ctas
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_Ctas extends Mage_Core_Model_Abstract
{

    /**
     *
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('ctas/ctas');
    }

    /**
     * Load By Identifier
     * 
     * @param type $identifier
     * @return \Optimiseweb_Ctas_Model_Ctas|boolean
     */
    public function loadByIdentifier($identifier)
    {
        if ($this->_getResource()->loadByIdentifier($this, $identifier)) {
            return $this;
        }
        return FALSE;
    }

}
