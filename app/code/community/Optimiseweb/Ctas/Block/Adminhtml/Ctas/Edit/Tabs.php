<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Edit Tabs
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('ctas_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('ctas')->__('Call to Action Information'));
    }

    /**
     * Before HTML
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

        $this->addTab('products', array(
                'label' => Mage::helper('ctas')->__('Associated Products'),
                'title' => Mage::helper('ctas')->__('Associated Products'),
                'url' => $this->getUrl('*/*/products', array('_current' => true)),
                'class' => 'ajax'
        ));

        $this->addTab('categories', array(
                'label' => Mage::helper('ctas')->__('Associated Categories'),
                'title' => Mage::helper('ctas')->__('Associated Categories'),
                'url' => $this->getUrl('*/*/categories', array('_current' => true)),
                'class' => 'ajax',
        ));

        return parent::_beforeToHtml();
    }

}
