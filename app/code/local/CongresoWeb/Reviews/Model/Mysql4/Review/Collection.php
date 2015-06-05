<?php

class CongresoWeb_Reviews_Model_Mysql4_Review_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('congresoweb_reviews/review');
    }
}