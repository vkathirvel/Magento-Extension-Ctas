<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Grid Renderer Image
 *
 * @package     Optimiseweb_Ctas
 * @author      Sid Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2013 Optimiseweb Ltd
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{

    /**
     *
     * @param Varien_Object $row
     * @return type
     */
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    /**
     *
     * @param Varien_Object $row
     * @return string
     */
    protected function _getValue(Varien_Object $row)
    {
        $out = 'No Image';
        $val = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        if (!empty($val)) {
            $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $val;
            $out = "<a href=" . $url . " target='_blank'><img src=" . $url . " width='75px'/></a>";
        }
        return $out;
    }

}