<?php

/**
 * Optimiseweb Ctas Model Config Ctas
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimiseweb Ltd
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_System_Config_Source_Ctas
{

    protected $_options;

    public function toOptionArray()
    {
        if (!$this->_options) {
            $ctas = Mage::getModel('ctas/ctas')->getCollection();
            $identifiers = array();
            $identifiers[0] = '-- Please Select --';
            foreach ($ctas as $cta) {
                $identifiers[$cta->identifier] = $cta->identifier;
            }
            $this->_options = $identifiers;
        }
        return $this->_options;
    }

}