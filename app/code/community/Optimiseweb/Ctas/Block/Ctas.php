<?php

/**
 * Optimiseweb Ctas Block Ctas
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimiseweb Ltd
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Ctas extends Mage_Core_Block_Template
{

    /**
     *
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('optimiseweb/ctas/template.phtml');
        $this->setObjectType('cta');
    }

    /**
     *
     * @return type
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     *
     * @return type
     */
    public function getCtas()
    {
        if (!$this->hasData('ctas')) {
            $this->setData('ctas', Mage::registry('ctas'));
        }
        return $this->getData('ctas');
    }

    /**
     *
     * @param type $identifier
     * @return type
     */
    public function getCtaData($identifier)
    {
        return Mage::helper('ctas')->loadCta($identifier);
    }

    /**
     *
     * @param type $identifier
     * @return type
     */
    public function getHeading($identifier)
    {
        return Mage::helper('ctas')->getHeading($identifier);
    }

    /**
     *
     * @param type $identifier
     * @return type
     */
    public function getContent($identifier)
    {
        return Mage::helper('ctas')->getContent($identifier);
    }

    /**
     *
     * @param type $identifier
     * @return type
     */
    public function getImage($identifier)
    {
        return Mage::helper('ctas')->getImage($identifier);
    }

    /**
     *
     * @param type $identifier
     * @return type
     */
    public function getLink($identifier)
    {
        return Mage::helper('ctas')->getLink($identifier);
    }

    /**
     *
     * @param type $identifier
     * @param type $linkContent
     * @return type
     */
    public function getHtmlLink($identifier, $linkContent = NULL)
    {
        return Mage::helper('ctas')->getHtmlLink($identifier, $linkContent);
    }

    /**
     *
     * @param type $identifier
     * @return type
     */
    public function getCta($identifier)
    {
        return Mage::helper('ctas')->getCta($identifier);
    }

    /**
     *
     * @param type $identifier
     * @param type $class
     * @return type
     */
    public function getCtaDiv($identifier, $class = NULL)
    {
        return Mage::helper('ctas')->getCtaDiv($identifier, $class);
    }

    /**
     *
     * @param type $identifier
     * @param type $customUrl
     * @param type $title
     * @param type $class
     * @param type $rel
     * @return type
     */
    public function getImageWithCustomUrl($identifier, $customUrl = NULL, $title = NULL, $class = NULL, $rel = NULL)
    {
        return Mage::helper('ctas')->getImageWithCustomUrl($identifier, $customUrl, $title, $class, $rel);
    }

}