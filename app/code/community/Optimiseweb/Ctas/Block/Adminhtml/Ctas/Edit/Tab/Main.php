<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Edit Tab Form
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (vkathirvel@gmail.com)
 * @copyright   Copyright (c) 2015 Kathir Vel
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Prepare Form
     * 
     * @return type
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();

        $model = Mage::registry('ctas_data');

        $fieldset = $form->addFieldset('ctas_form1', array('legend' => Mage::helper('ctas')->__('General'), 'class' => 'fieldset-wide'));

        $fieldset->addField('status', 'select', array(
                'label' => Mage::helper('ctas')->__('Status'),
                'title' => Mage::helper('ctas')->__('Status'),
                'name' => 'status',
                'values' => array(
                        array(
                                'value' => 1,
                                'label' => Mage::helper('ctas')->__('Enabled'),
                        ),
                        array(
                                'value' => 2,
                                'label' => Mage::helper('ctas')->__('Disabled'),
                        ),
                ),
        ));

        $fieldset->addField('description', 'text', array(
                'label' => Mage::helper('ctas')->__('Friendly Description'),
                'title' => Mage::helper('ctas')->__('Friendly Description'),
                'required' => false,
                'name' => 'description',
                'after_element_html' => '<p class="note">A friendly name to describe the Call to Action.</p>',
        ));

        $fieldset->addField('identifier', 'text', array(
                'label' => Mage::helper('ctas')->__('Unique Identifier'),
                'title' => Mage::helper('ctas')->__('Unique Identifier'),
                'required' => true,
                'class' => 'validate-identifier',
                'name' => 'identifier',
                'after_element_html' => '<p class="note" style="width:90%;">For use by the designer / developer. Must be a unique value.</p>',
        ));

        /**
         * Check is single store mode
         */
        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset = $form->addFieldset('ctas_form2', array('legend' => Mage::helper('ctas')->__('Stores'), 'class' => 'fieldset-wide'));

            $fieldset->addField('store_ids', 'multiselect', array(
                    'name' => 'store_ids[]',
                    'label' => Mage::helper('ctas')->__('Store View'),
                    'title' => Mage::helper('ctas')->__('Store View'),
                    'required' => true,
                    'values' => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, true),
            ));
        } else {
            $fieldset->addField('store_ids', 'hidden', array(
                    'name' => 'store_ids[]',
                    'value' => Mage::app()->getStore(true)->getId()
            ));
            $model->setStoreIds(Mage::app()->getStore(true)->getId());
        }

        $fieldset = $form->addFieldset('ctas_form3', array('legend' => Mage::helper('ctas')->__('Image'), 'class' => 'fieldset-wide'));

        $fieldset->addField('image', 'image', array(
                'label' => Mage::helper('ctas')->__('Image'),
                'title' => Mage::helper('ctas')->__('Image'),
                'required' => false,
                'name' => 'image',
        ));

        $fieldset->addField('image_retina', 'image', array(
                'label' => Mage::helper('ctas')->__('Image for Retina Display'),
                'title' => Mage::helper('ctas')->__('Image for Retina Display'),
                'required' => false,
                'name' => 'image_retina',
        ));

        $fieldset->addField('alt', 'text', array(
                'label' => Mage::helper('ctas')->__('Image Alt Tag'),
                'title' => Mage::helper('ctas')->__('Image Alt Tag'),
                'required' => false,
                'name' => 'alt',
                'after_element_html' => '<p class="note">Alt tags are meant to describe the image.</p>',
        ));

        $fieldset = $form->addFieldset('ctas_form4', array('legend' => Mage::helper('ctas')->__('Link'), 'class' => 'fieldset-wide'));

        $fieldset->addField('url', 'text', array(
                'label' => Mage::helper('ctas')->__('Link Destination URL'),
                'title' => Mage::helper('ctas')->__('Link Destination URL'),
                'required' => false,
                'name' => 'url',
                'after_element_html' => '<p class="note" style="width:90%;">Provide the full URL including the protocol (http:// or https://) like http://www.yourwebsite.com/examplepage.html or leave it as examplepage.html (the store URL will be prepended to the URL provided). To link to the homepage, you can use "baseurl".</p>',
        ));

        $fieldset->addField('title', 'text', array(
                'label' => Mage::helper('ctas')->__('Link Title Tag'),
                'title' => Mage::helper('ctas')->__('Link Title Tag'),
                'required' => false,
                'name' => 'title',
                'after_element_html' => '<p class="note" style="width:90%;">Title tags on links are meant to describe the link\'s action or destination.</p>',
        ));

        $fieldset->addField('external', 'select', array(
                'label' => Mage::helper('ctas')->__('Link Target - External?'),
                'title' => Mage::helper('ctas')->__('Link Target - External?'),
                'name' => 'external',
                'after_element_html' => '<p class="note">Do you want the link to open in a new window?</p>',
                'values' => array(
                        array(
                                'value' => 0,
                                'label' => Mage::helper('ctas')->__('No'),
                        ),
                        array(
                                'value' => 1,
                                'label' => Mage::helper('ctas')->__('Yes'),
                        ),
                ),
        ));

        $fieldset = $form->addFieldset('ctas_form5', array('legend' => Mage::helper('ctas')->__('Text'), 'class' => 'fieldset-wide'));

        $fieldset->addField('heading', 'text', array(
                'label' => Mage::helper('ctas')->__('Call to Action Heading'),
                'title' => Mage::helper('ctas')->__('Call to Action Heading'),
                'required' => false,
                'name' => 'heading',
                'after_element_html' => '<p class="note">Depends on the Call to Action design and setup.</p>',
        ));

        $fieldset->addField('cta_content', 'editor', array(
                'name' => 'cta_content',
                'label' => Mage::helper('ctas')->__('Call to Action Content'),
                'title' => Mage::helper('ctas')->__('Call to Action Content'),
                'style' => 'width:500px; height:100px;',
                'wysiwyg' => false,
                'required' => false,
                'after_element_html' => '<p class="note">Depends on the Call to Action design and setup.</p>',
        ));

        $fieldset = $form->addFieldset('ctas_form6', array('legend' => Mage::helper('ctas')->__('Date Range'), 'class' => 'fieldset-wide'));

        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);

        $fieldset->addField('start_date', 'date', array(
                'label' => Mage::helper('ctas')->__('Start Date'),
                'title' => Mage::helper('ctas')->__('Start Date'),
                'required' => false,
                'name' => 'start_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'input_format' => $dateFormatIso,
                'format' => $dateFormatIso,
                'after_element_html' => '<p class="note">Depends on the Call to Action design and setup.</p>',
        ));

        $fieldset->addField('end_date', 'date', array(
                'label' => Mage::helper('ctas')->__('End Date'),
                'title' => Mage::helper('ctas')->__('End Date'),
                'required' => false,
                'name' => 'end_date',
                'image' => $this->getSkinUrl('images/grid-cal.gif'),
                'input_format' => $dateFormatIso,
                'format' => $dateFormatIso,
                'after_element_html' => '<p class="note">Depends on the Call to Action design and setup.</p>',
        ));

        if (Mage::getSingleton('adminhtml/session')->getCtasData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCtasData());
            Mage::getSingleton('adminhtml/session')->setCtasData(null);
        } elseif ($model) {
            $form->setValues(Mage::registry('ctas_data')->getData());
        }

        $this->setForm($form);

        return parent::_prepareForm();
    }

}
