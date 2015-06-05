<?php
class CongresoWeb_Reviews_Block_Adminhtml_Reviews extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'congresoweb_reviews';
        $this->_controller = 'adminhtml_reviews';
        $this->_headerText = 'Order Reviews';

        parent::__construct();
        $this->_removeButton('add');
    }
}