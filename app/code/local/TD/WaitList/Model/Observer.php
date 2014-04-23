<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 03.04.14
 * Time: 23:26
 */
class TD_WaitList_Model_Observer extends Mage_Core_Model_Abstract{

    public function checkStock($observer){
        $product = $observer->getEvent()->getProduct();
//        var_dump($product->getData());
        $id = $product->getId();
        $stockModel = Mage::getModel('cataloginventory/stock_item')->loadByProduct($product);
//        $inStock = $stockModel->getIsInStock();
        $qtyStock = $stockModel->getQty();
        if ($qtyStock > 0){
            $waitCollection = Mage::getModel('td_waitlist/waitlist')->getCollection()
                ->addFieldToFilter('product_id',array('eq'=>$id));

            foreach ($waitCollection as $item){
                $customer = Mage::getModel('customer/customer')->load($item->getCustomerId());
                $email = $customer->getEmail();
                Mage::helper('td_waitlist')->sendMail($email,$product);
//                Mage::log($product->getId());
//                $item->delete();
            }
        }

        return $this;
    }
}