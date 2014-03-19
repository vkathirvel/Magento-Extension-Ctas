<?php

/**
 * Optimiseweb Ctas Adminhtml Ctas Controller
 *
 * @package     Optimiseweb_Ctas
 * @author      Kathir Vel (sid@optimiseweb.co.uk)
 * @copyright   Copyright (c) 2014 Optimise Web
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Optimiseweb_Ctas_Adminhtml_CtasController extends Mage_Adminhtml_Controller_Action
{

    /**
     * INIT Action
     */
    protected function _initAction()
    {
        $this->loadLayout();
        $this->loadLayout()->_setActiveMenu('optimiseweball/ctas');
        $this->loadLayout()->_addBreadcrumb(Mage::helper('adminhtml')->__('Ctas Manager'), Mage::helper('adminhtml')->__('Ctas Manager'));
        return $this;
    }

    /**
     * Index Action
     */
    public function indexAction()
    {
        $this->_initAction();
        $block = $this->getLayout()->createBlock('ctas/adminhtml_ctas', 'ctas');
        $this->getLayout()->getBlock('content')->append($block);
        $this->renderLayout();
    }

    /**
     * Edit Action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('id');
        $model = Mage::getModel('ctas/ctas')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('ctas_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('optimiseweball/ctas');
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Calls to Action Manager'), Mage::helper('adminhtml')->__('Calls to Action Manager'));
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock('ctas/adminhtml_ctas_edit'));
            $this->_addLeft($this->getLayout()->createBlock('ctas/adminhtml_ctas_edit_tabs'));
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ctas')->__('Call to Action does not exist'));
            $this->_redirect('*/*/');
        }
    }

    /**
     * New Action
     */
    public function newAction()
    {
        $this->_forward('edit');
    }

    /**
     * Save Action
     */
    public function saveAction()
    {
        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('ctas/ctas');

            /* Store Ids */
            if (!isset($data['store_ids']) OR in_array('0', $data['store_ids'])) {
                $data['store_ids'] = array('0');
            }
            $data['store_ids'] = implode(',', $data['store_ids']);

            /* Image and File Uploads */
            $media_path = Mage::getBaseDir('media') . DS;
            $media_sub_folder = 'optimiseweb/ctas' . DS;
            $final_media_path = $media_path . $media_sub_folder;

            $images = array('image', 'image_retina');
            $uploader = '';
            $upload = '';

            foreach ($images as $image) {
                if (isset($_FILES[$image]['name']) && $_FILES[$image]['name'] != '') {
                    if (isset($data[$image]['delete']) && $data[$image]['delete'] == 1) {
                        unlink($media_path . $data[$image]['value']);
                    }
                    $uploader = new Varien_File_Uploader($image);
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(false);
                    $upload = $uploader->save($final_media_path, $_FILES[$image]['name']);
                    $data[$image] = $media_sub_folder . $upload['file'];
                } else {
                    if (isset($data[$image]['delete']) && $data[$image]['delete'] == 1) {
                        unlink($media_path . $data[$image]['value']);
                        $data[$image] = '';
                    } else {
                        if (isset($data[$image]['value'])) {
                            $data[$image] = $data[$image]['value'];
                        } else {
                            $data[$image] = '';
                        }
                    }
                }
                $model->setData($image, $data[$image]);
            }

            /* Dates */
            if ($data['start_date'] == '') {
                $data['start_date'] = NULL;
            } else {
                $date = Mage::app()->getLocale()->date($data['start_date'], Zend_Date::DATE_SHORT);
                $data['start_date'] = $date->toString('YYYY-MM-dd');
            }
            if ($data['end_date'] == '') {
                $data['end_date'] = NULL;
            } else {
                $date1 = Mage::app()->getLocale()->date($data['end_date'], Zend_Date::DATE_SHORT);
                $data['end_date'] = $date1->toString('YYYY-MM-dd');
            }

            /* Save into the model */
            $model->setData($data)->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();

                /**
                 * Save Product Linkage
                 */
                $ctaId = $model->getId();
                if (isset($data['products'])) {
                    $products = Mage::helper('adminhtml/js')->decodeGridSerializedInput($data['products']);
                    $collection = Mage::getResourceModel('ctas/ctas_products_collection');
                    $collection->addFieldToFilter('cta_id', $ctaId);
                    foreach ($collection as $obj) {
                        $obj->delete();
                    }
                    foreach ($products as $key => $value) {
                        $productRel = Mage::getModel('ctas/ctas_products');
                        $productRel->setCtaId($ctaId);
                        $productRel->setProductId($key);
                        $productRel->setPosition($value['position']);
                        $productRel->save();
                    }
                }
                /**
                 * Save Category Linkage
                 */
                if (isset($data['category_ids'])) {
                    $categories = explode(',', $data['category_ids']);
                    $categories = array_unique($categories);

                    $collection = Mage::getResourceModel('ctas/ctas_categories_collection');
                    $collection->addFieldToFilter('cta_id', $ctaId);
                    foreach ($collection as $obj) {
                        $obj->delete();
                    }

                    foreach ($categories as $catergoryId) {
                        if (!empty($catergoryId)) {
                            $categoryRel = Mage::getModel('ctas/ctas_categories');
                            $categoryRel->setCtaId($ctaId);
                            $categoryRel->setCategoryId($catergoryId);
                            $categoryRel->setPosition(1);
                            $categoryRel->save();
                        }
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('ctas')->__('Call to Action was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('ctas')->__('Unable to find Call to Action to save'));
        $this->_redirect('*/*/');
    }

    /**
     * Delete Action
     */
    public function deleteAction()
    {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('ctas/ctas');

                /* Delete Images & Files */
                $id = $this->getRequest()->getParam('id');
                $model = Mage::getModel('ctas/ctas')->load($id);
                if ($model->getId() || $id == 0) {
                    $media_path = Mage::getBaseDir('media') . DS;
                    $images = array('image', 'image_retina');
                    foreach ($images as $image) {
                        unlink($media_path . $model->getData($image));
                    }
                }

                $model->setId($this->getRequest()->getParam('id'))->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Call to Action was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    /**
     * Mass Delete Action
     */
    public function massDeleteAction()
    {
        $ctasIds = $this->getRequest()->getParam('ctas');
        if (!is_array($ctasIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Call to Action(s)'));
        } else {
            try {
                foreach ($ctasIds as $ctasId) {
                    $ctas = Mage::getModel('ctas/ctas')->load($ctasId);

                    /* Delete Images & Files */
                    if ($ctas->getId()) {
                        $media_path = Mage::getBaseDir('media') . DS;
                        $images = array('image', 'image_retina');
                        foreach ($images as $image) {
                            unlink($media_path . $ctas->getData($image));
                        }
                    }

                    $ctas->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Total of %d record(s) were successfully deleted', count($ctasIds)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Mass Status Action
     */
    public function massStatusAction()
    {
        $ctasIds = $this->getRequest()->getParam('ctas');
        if (!is_array($ctasIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Call to Action(s)'));
        } else {
            try {
                foreach ($ctasIds as $ctasId) {
                    $ctas = Mage::getSingleton('ctas/ctas')
                        ->load($ctasId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($ctasIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Export CSV Action
     */
    public function exportCsvAction()
    {
        $fileName = 'ctas.csv';
        $content = $this->getLayout()->createBlock('ctas/adminhtml_ctas_grid')->getCsv();
        $this->_sendUploadResponse($fileName, $content);
    }

    /**
     * Export XML Action
     */
    public function exportXmlAction()
    {
        $fileName = 'ctas.xml';
        $content = $this->getLayout()->createBlock('ctas/adminhtml_ctas_grid')->getXml();
        $this->_sendUploadResponse($fileName, $content);
    }

    /**
     * Send Upload Response
     */
    protected function _sendUploadResponse($fileName, $content, $contentType = 'application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK', '');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename=' . $fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }

    /**
     * Ajax Products Action
     */
    public function productsAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('adminhtml.ctas.edit.tab.products')->setCtasProducts($this->getRequest()->getPost('ctas_products', null));
        $this->renderLayout();
    }

    /**
     * Ajax Products Grid Action
     */
    public function productsgridAction()
    {
        $this->loadLayout();
        $this->getLayout()->getBlock('adminhtml.ctas.edit.tab.products')->setCtasProducts($this->getRequest()->getPost('ctas_products', null));
        $this->renderLayout();
    }

    /**
     * 
     */
    public function categoriesAction()
    {
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * 
     */
    public function categoriesJsonAction()
    {
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('ctas/adminhtml_ctas_edit_tab_categories')->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }

}
