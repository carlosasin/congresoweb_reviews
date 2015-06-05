<?php

class CongresoWeb_Reviews_Model_Mysql4_Review extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('congresoweb_reviews/review', 'review_id');
    }
}