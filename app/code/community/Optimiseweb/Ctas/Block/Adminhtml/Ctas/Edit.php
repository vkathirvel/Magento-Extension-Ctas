<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Edit
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'ctas';
        $this->_controller = 'adminhtml_ctas';

        $this->_updateButton('save', 'label', Mage::helper('ctas')->__('Save Call to Action'));
        $this->_updateButton('delete', 'label', Mage::helper('ctas')->__('Delete Call to Action'));

        $this->_addButton('saveandcontinue', array(
                'label' => Mage::helper('adminhtml')->__('Save And Continue Edit'),
                'onclick' => 'saveAndContinueEdit()',
                'class' => 'save',
            ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Prepare Layout
     * 
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    /**
     * Get Header Text
     * 
     * @return type
     */
    public function getHeaderText()
    {
        if (Mage::registry('ctas_data') && Mage::registry('ctas_data')->getId()) {
            return Mage::helper('ctas')->__('Edit Call to Action');
        } else {
            return Mage::helper('ctas')->__('Add Call to Action');
        }
    }

}
