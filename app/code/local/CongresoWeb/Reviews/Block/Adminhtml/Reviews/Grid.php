<?php

class CongresoWeb_Reviews_Block_Adminhtml_Reviews_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    protected $_defaultLimit = 10;

    public function __construct()
    {
        parent::__construct();
        $this->setId('congresoweb_reviews_grid');
        $this->setDefaultSort('created_time');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('congresoweb_reviews/review_collection')
            ->join(array('a' => 'sales/order'), 'main_table.order_id = a.entity_id', array(
                'increment_id'      => 'increment_id',
                'email'             => 'customer_email'
            )) ->addExpressionFieldToSelect(
                'fullname',
                'CONCAT({{customer_firstname}}, \' \', {{customer_lastname}})',
                array('customer_firstname' => 'a.customer_firstname', 'customer_lastname' => 'a.customer_lastname'));

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('congresoweb_reviews');

        $this->addColumn('increment_id', array(
            'header' => $helper->__('Order'),
            'index'  => 'increment_id'
        ));

        $this->addColumn('fullname', array(
            'header' => $helper->__('Name'),
            'index'  => 'fullname'
        ));

        $this->addColumn('email', array(
            'header' => $helper->__('Email'),
            'index'  => 'email'
        ));

        $this->addColumn('title', array(
            'header' => $helper->__('Title'),
            'index'  => 'title'
        ));

        $this->addColumn('rating', array(
            'header' => $helper->__('Rating'),
            'index'  => 'rating'
        ));

        $this->addColumn('description', array(
            'header' => $helper->__('Description'),
            'index'  => 'description'
        ));

        $this->addColumn('created_time', array(
            'header' => $helper->__('Date'),
            'index'  => 'created_time'
        ));

        $this->addExportType('*/*/exportCsv', $helper->__('CSV'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {

        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}