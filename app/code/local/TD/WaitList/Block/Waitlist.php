<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 02.04.14
 * Time: 22:17
 */
class TD_WaitList_Block_Waitlist extends Mage_Core_Block_Template{

    public function _construct(){
        parent::_construct();
    }

    public function isWait($prodId,$customerId){
        $collection = Mage::getModel('td_waitlist/waitlist')->getCollection();
        $collection->addFieldToFilter('product_id',array('eq'=>$prodId))
            ->addFieldToFilter('customer_id',array('eq'=>$customerId));
        if ($collection->getSize() > 0){
            return true;
        } else {
            return false;
        }

    }

    public function hasWait(){
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();

        $waitcoll = Mage::getModel('td_waitlist/waitlist')->getCollection()
            ->addFieldToFilter('customer_id',array('eq'=>$customerId));
        $waitcoll->getSelect()->limit(1);

        if ($waitcoll->getSize() > 0){
            return true;
        } else {
            return false;
        }
    }
}