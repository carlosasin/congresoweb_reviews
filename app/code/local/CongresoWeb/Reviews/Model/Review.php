<?php

class CongresoWeb_Reviews_Model_Review extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('congresoweb_reviews/review');
    }

    public function sendmail() {

        $orders = Mage::getModel('sales/order')->getCollection()
                    ->addFieldToFilter('created_at', array('lt' =>date("Y-m-d 23:59:59", time() - 60 * 60 * 24 * 14)))
                    ->addFieldToFilter('created_at', array('gt' =>date("Y-m-d 00:00:00", time() - 60 * 60 * 24 * 14)));

        foreach ($orders as $order) {

            //Set email template
            $emailTemplate  = Mage::getModel('core/email_template')->loadDefault('orderreview');
            $emailTemplateSubject = $emailTemplate->getProcessedTemplateSubject();

            //Create an array of variables to assign to template
            $emailVars = array('link' => Mage::getUrl('orderreview/index/index').'order/'.$order->getId().'/');

            $processedTemplate = $emailTemplate->getProcessedTemplate($emailVars);

            //Set Email Params
            $mail = Mage::getModel('core/email')
                        ->setToName($order->getCustomerFirstname().' '.$order->getCustomerLastname())
                        ->setToEmail('casin@hiberus.com')
                        ->setBody($processedTemplate)
                        ->setSubject($emailTemplateSubject)
                        ->setFromEmail('test@domain.com')
                        ->setFromName('Test')
                        ->setType('html');

            //Send Email
            $mail->send();
        }
    }
}