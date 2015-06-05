<?php

/**
 * Class CongresoWeb_Reviews_indexController
 */
class CongresoWeb_Reviews_indexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        //Check user is allowed to send the order review
        if ($this->checkIsAllowed()) {

            $order = $this->getRequest()->getParam('order');

            // Render View
            $this->loadLayout();
            $this->getLayout()->getBlock('order_review_form')->setData('order', $order);
            $this->renderLayout();
        }
    }

    public function saveAction()
    {
        if ($this->checkIsAllowed()) {

            //Check not empty params
            $params = $this->getRequest()->getParams();

            if (empty($params['title']) ||
                empty($params['rating']) || $params['rating'] < 0 || $params['rating'] > 10 ||
                empty($params['description']) ||
                empty($params['order'])
            ) {

                Mage::getSingleton('core/session')->addError('Invalid data provided, please fill all the fields');
                $this->_redirect('orderreview/index');
                return;
            }

            //Save review
            $customer = Mage::getSingleton('customer/session')->getCustomer();

            Mage::getModel('congresoweb_reviews/review')
                ->setOrderId($params['order'])
                ->setCustomerId($customer->getId())
                ->setTitle($params['title'])
                ->setDescription($params['description'])
                ->setRating($params['rating'])
                ->setCreatedTime(date('Y-m-d H:i:s'))
                ->save();

            //Show success message and redirect to home page
            Mage::getSingleton('core/session')->addSuccess('Thanks, your review has been send.');
            $this->_redirect('');
        }
    }

    private function checkIsAllowed()
    {
        //Check user is logged in
        if (!Mage::helper('customer')->isLoggedIn()) {

            $session = Mage::getSingleton('customer/session');
            $session->setBeforeAuthUrl(Mage::helper('core/url')->getCurrentUrl());

            Mage::getSingleton('core/session')->addError('You must be logged in to review an order');
            $this->_redirect('customer/account/login/');
            return false;
        }

        //Check user own the selected order
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        $order = $this->getRequest()->getParam('order');

        $existOrder = Mage::getModel('sales/order')->getCollection()
            ->addFieldToFilter('entity_id', array('eq' => $order))
            ->addFieldToFilter('customer_id', array('eq' => $customer->getId()))
            ->getSize();

        if (!$existOrder) {

            Mage::getSingleton('core/session')->addError('You can\'t review again this order');
            $this->_redirect('');
            return false;
        }

        //Check not exist review of the order
        $existReview =
            Mage::getModel('congresoweb_reviews/review')
                ->getCollection()
                ->addFieldToFilter('customer_id', array('eq' => $customer->getId()))
                ->addFieldToFilter('order_id', array('eq' => $order))
                ->getSize();

        if ($existReview) {

            Mage::getSingleton('core/session')->addError('You can\'t review again this order');
            $this->_redirect('');
            return false;
        }

        return true;
    }
}