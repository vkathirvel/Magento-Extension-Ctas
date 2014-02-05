<?php

/**
 * Optimiseweb Ctas Helper Data
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Get config
     *
     * @param type $field
     * @return type
     */
    public function getConfig($field)
    {
        return Mage::getStoreConfig('optimisewebctas/' . $field);
    }

    /**
     * Load the CTA and check status and date range
     *
     * @param type $identifier
     * @return boolean
     */
    public function loadCta($identifier)
    {
        $cta = Mage::getModel('ctas/ctas')->loadByIdentifier($identifier);

        if ($cta) {
            if ($this->_filterStore($cta->getData('store_ids')) AND ($cta->getData('status') == 1) AND $this->_checkDateRange($cta->getData('start_date'), $cta->getData('end_date'))) {
                return $cta;
            }
        }
        return FALSE;
    }

    /**
     * Check if today is within the given date range
     *
     * @param type $startDate
     * @param type $endDate
     * @return boolean
     */
    public function _checkDateRange($startDate, $endDate)
    {
        if ($startDate) {
            
        } else {
            $startDate = '2000-01-01 00:00:00';
        }
        if ($endDate) {
            
        } else {
            $endDate = '2038-12-31 00:00:00';
            //$endDate = date('Y-m-d H:i:s', PHP_INT_MAX);
        }

        $today = strtotime(date('Y-m-d'));
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        if (($today >= $startDate) AND ($today <= $endDate)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Check if the CTA can be shown within the current store
     *
     * @param type $storeIds
     * @return boolean
     */
    protected function _filterStore($storeIds)
    {
        $storeIdData = explode(',', $storeIds);

        if (in_array('0', $storeIdData) OR in_array(Mage::app()->getStore()->getId(), $storeIdData)) {
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Check for the protocol and add the store url if no protocol provided
     *
     * @param string $url
     * @return string
     */
    protected function _destinationUrlCheck($url)
    {
        $count = 0;
        $protocols = array('http://', 'https://', 'ftp://', 'mailto:');
        foreach ($protocols as $protocol) {
            if (substr($url, 0, strlen($protocol)) !== $protocol)
                $count++;
        }
        if (count($protocols) == $count) {
            if ($url == "baseurl") {
                $url = Mage::getUrl();
            } else {
                $url = Mage::getUrl() . $url;
            }
        }
        return $url;
    }

    /**
     * Returns the CTA Heading in plain text format
     *
     * @param type $identifier
     * @return boolean
     */
    public function getHeading($identifier)
    {
        $cta = $this->loadCta($identifier);
        if ($cta) {
            if ($cta->getData('heading')) {
                return $cta->getData('heading');
            }
        }
        return FALSE;
    }

    /**
     * Returns the CTA Content in plain text format
     *
     * @param type $identifier
     * @return boolean
     */
    public function getContent($identifier)
    {
        $cta = $this->loadCta($identifier);
        if ($cta) {
            if ($cta->getData('cta_content')) {
                return $cta->getData('cta_content');
            }
        }
        return FALSE;
    }

    /**
     * Returns the CTA <img>
     *
     * @param type $identifier
     * @return string|boolean
     */
    public function getImage($identifier)
    {
        $cta = $this->loadCta($identifier);
        if ($cta) {
            if ($cta->getData('image')) {
                /* Start creating the HTML output */
                $html = '';
                $html .= '<img src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $cta->getData('image') . '" ';
                if ($cta->getData('image_retina') AND $this->getConfig('retina/enabled')) {
                    $dataAttribute = 'data-at2x';
                    if ($this->getConfig('retina/dataattribute')) {
                        $dataAttribute = $this->getConfig('retina/dataattribute');
                    }
                    $html .= $dataAttribute . '="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $cta->getData('image_retina') . '" ';
                }
                if ($cta->getData('alt')) {
                    $html .= 'alt="' . htmlentities($cta->getData('alt')) . '" ';
                }
                $html .= '/>';
                return $html;
            }
        }
        return FALSE;
    }

    /**
     * Returns the Link in plain text format.
     *
     * @param type $identifier
     * @return string|boolean
     */
    public function getLink($identifier)
    {
        $cta = $this->loadCta($identifier);
        if ($cta) {
            if ($cta->getData('url')) {
                return $this->_destinationUrlCheck($cta->getData('url'));
            }
        }
        return FALSE;
    }

    /**
     * Returns the Link in <a> format. The closing </a> needs to be added manually.
     *
     * @param type $identifier
     * @return string|boolean
     */
    public function getHtmlLink($identifier, $linkContent = NULL)
    {
        $cta = $this->loadCta($identifier);
        if ($cta) {
            if ($cta->getData('url')) {
                if ($cta->getData('title')) {
                    $linkTitle = ' title="' . htmlentities($cta->getData('title')) . '"';
                } else {
                    $linkTitle = '';
                }
                if ($cta->getData('external')) {
                    $external = ' rel="external"';
                } else {
                    $external = '';
                }
                /* Start creating the HTML output */
                $html = '';
                $html .= '<a href="' . $this->_destinationUrlCheck($cta->getData('url')) . '"' . $linkTitle . $external . '>';
                if ($linkContent != NULL) {
                    $html .= $linkContent;
                    $html .= '</a>';
                }
                return $html;
            }
        }
        return FALSE;
    }

    /**
     * Returns the HTML format <img> or <a><img>
     *
     * @param type $identifier
     * @return string|boolean
     */
    public function getCta($identifier)
    {
        $image = $this->getImage($identifier);
        $link = $this->getHtmlLink($identifier);
        if ($image) {
            /* Start creating the HTML output */
            $html = '';
            if ($link) {
                $html .= $link;
            }
            $html .= $image;
            if ($link) {
                $html .= '</a>';
            }
            return $html;
        }
        return FALSE;
    }

    /**
     * Returns the HTML format <img> or <a><img> wrapped with a DIV
     *
     * @param type $identifier
     * @param type $class
     * @return string|boolean
     */
    public function getCtaDiv($identifier, $class = NULL, $id = NULL)
    {
        $cta = $this->getCta($identifier);
        if ($cta) {
            $html = '<div';
            if ($id != NULL) {
                $html .= ' id="' . $id . '"';
            }
            if ($class != NULL) {
                $html .= ' class="' . $class . '"';
            }
            $html .= '>';
            $html .= $cta;
            $html .= '</div>';
            return $html;
        }
        return FALSE;
    }

    /**
     * Gets the CTA image wrapped with a custom url link
     *
     * @param type $identifier
     * @param type $customUrl
     * @param type $title
     * @param type $class
     * @param type $rel
     * @return string|boolean
     */
    public function getImageWithCustomUrl($identifier, $customUrl = NULL, $title = NULL, $class = NULL, $rel = NULL)
    {
        $image = $this->getImage($identifier);
        if ($image) {
            $html = '';
            if ($customUrl != NULL) {
                $html .= '<a href="' . $customUrl . '"';
                if ($title != NULL) {
                    $html .= ' title="' . $title . '"';
                }
                if ($class != NULL) {
                    $html .= ' class="' . $class . '"';
                }
                if ($rel != NULL) {
                    $html .= ' rel="' . $rel . '"';
                }
                $html .= '>';
            }
            $html .= $image;
            if ($customUrl != NULL) {
                $html .= '</a>';
            }
            return $html;
        }
        return FALSE;
    }

}
