<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimiseweb Ltd
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     *
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_ctas';
        $this->_blockGroup = 'ctas';
        $this->_headerText = Mage::helper('ctas')->__('Calls to Action Manager');
        $this->_addButtonLabel = Mage::helper('ctas')->__('Add Call to Action');
        parent::__construct();
    }

}