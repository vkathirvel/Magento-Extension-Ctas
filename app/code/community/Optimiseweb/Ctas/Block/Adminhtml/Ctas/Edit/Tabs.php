<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Edit Tabs
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimiseweb Ltd
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('ctas_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('ctas')->__('Call to Action Information'));
    }

    /**
     *
     * @return type
     */
    protected function _beforeToHtml()
    {
        $this->addTab('main_section', array(
                'label' => Mage::helper('ctas')->__('Call to Action Information'),
                'title' => Mage::helper('ctas')->__('Call to Action Information'),
                'content' => $this->getLayout()->createBlock('ctas/adminhtml_ctas_edit_tab_main')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }

}