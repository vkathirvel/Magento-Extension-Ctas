<?php

/**
 * Optimiseweb Ctas Model Config Ctas
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Model_System_Config_Source_Ctas
{

    /**
     *
     * @var type 
     */
    protected $_options;

    /**
     * To Option Array
     * 
     * @return type
     */
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
