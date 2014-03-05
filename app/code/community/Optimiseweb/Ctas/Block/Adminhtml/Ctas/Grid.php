<?php

/**
 * Optimiseweb Ctas Block Adminhtml Ctas Grid
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Block_Adminhtml_Ctas_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('ctasGrid');
        $this->setDefaultSort('cta_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare Collecton
     * 
     * @return type
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ctas/ctas')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare Columns
     * 
     * @return type
     */
    protected function _prepareColumns()
    {
        $this->addColumn('cta_id', array(
                'header' => Mage::helper('ctas')->__('ID'),
                'align' => 'right',
                'width' => '50px',
                'index' => 'cta_id',
        ));

        $this->addColumn('description', array(
                'header' => Mage::helper('ctas')->__('Friendly Description'),
                'align' => 'left',
                'index' => 'description',
        ));

        $this->addColumn('identifier', array(
                'header' => Mage::helper('ctas')->__('Identifier'),
                'align' => 'left',
                'index' => 'identifier',
        ));

        $this->addColumn('url', array(
                'header' => Mage::helper('ctas')->__('Destination URL'),
                'align' => 'left',
                'index' => 'url',
        ));

        $this->addColumn('image', array(
                'header' => Mage::helper('ctas')->__('Image File'),
                'align' => 'left',
                'type' => 'image',
                'index' => 'image',
                'width' => '85px',
                'renderer' => 'Optimiseweb_Ctas_Block_Adminhtml_Ctas_Grid_Renderer_Image',
                'filter' => false,
                'sortable' => false,
        ));

        $this->addColumn('status', array(
                'header' => Mage::helper('ctas')->__('Status'),
                'align' => 'left',
                'width' => '80px',
                'index' => 'status',
                'type' => 'options',
                'options' => array(
                        1 => 'Enabled',
                        2 => 'Disabled',
                ),
        ));

        $this->addColumn('start_date', array(
                'header' => Mage::helper('ctas')->__('Start Date'),
                'align' => 'center',
                'type' => 'datetime',
                'index' => 'start_date',
                'width' => '100px',
        ));

        $this->addColumn('end_date', array(
                'header' => Mage::helper('ctas')->__('End Date'),
                'align' => 'center',
                'type' => 'datetime',
                'index' => 'end_date',
                'width' => '100px',
        ));

        $this->addColumn('action', array(
                'header' => Mage::helper('ctas')->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                        array(
                                'caption' => Mage::helper('ctas')->__('Edit'),
                                'url' => array('base' => '*/*/edit'),
                                'field' => 'id'
                        )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('ctas')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('ctas')->__('XML'));

        return parent::_prepareColumns();
    }

    /**
     * Prepare Mass Action
     * 
     * @return \Optimiseweb_Ctas_Block_Adminhtml_Ctas_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('cta_id');
        $this->getMassactionBlock()->setFormFieldName('ctas');

        $this->getMassactionBlock()->addItem('delete', array(
                'label' => Mage::helper('ctas')->__('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => Mage::helper('ctas')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('ctas/status')->getOptionArray();

        array_unshift($statuses, array('label' => '', 'value' => ''));
        $this->getMassactionBlock()->addItem('status', array(
                'label' => Mage::helper('ctas')->__('Change status'),
                'url' => $this->getUrl('*/*/massStatus', array('_current' => true)),
                'additional' => array(
                        'visibility' => array(
                                'name' => 'status',
                                'type' => 'select',
                                'class' => 'required-entry',
                                'label' => Mage::helper('ctas')->__('Status'),
                                'values' => $statuses
                        )
                )
        ));
        return $this;
    }

    /**
     * Get Row URL
     * 
     * @param type $row
     * @return type
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
