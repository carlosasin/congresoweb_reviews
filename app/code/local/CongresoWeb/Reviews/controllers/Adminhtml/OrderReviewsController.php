<?php

class CongresoWeb_Reviews_Adminhtml_OrderReviewsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction()
    {
        $this->_title($this->__('Order Reviews'));
        $this->loadLayout();
        $this->_setActiveMenu('orderreviews/reviews');
        $this->_addContent($this->getLayout()->createBlock('congresoweb_reviews/adminhtml_reviews'));
        $this->renderLayout();
    }

    public function exportCsvAction()
    {
        $fileName = 'order_reviews.csv';
        $content = $this->getLayout()->createBlock('congresoweb_reviews/adminhtml_reviews_grid')->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
}