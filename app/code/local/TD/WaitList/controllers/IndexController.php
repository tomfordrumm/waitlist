<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 02.04.14
 * Time: 22:16
 */
class TD_WaitList_IndexController extends Mage_Core_Controller_Front_Action{


    public function addAction(){
        $customer_id    = $this->getRequest()->getParam('wl_customer_id');
        $product_id     = $this->getRequest()->getParam('wl_product_id');
//        $redirectUrl    = $this->getRequest()->getParam('back');

        $model = Mage::getModel('td_waitlist/waitlist');
        $model->setCustomerId($customer_id);
        $model->setProductId($product_id);
        try{
            $model->save();
            Mage::getSingleton('core/session')->addSuccess('Success');
        }catch (Exception $e){
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }


        $this->_redirectUrl($this->_getRefererUrl());

    }

    public function indexAction(){
        $this->loadLayout()
            ->renderLayout();
    }

    public function delAction(){
        $prodId = $this->getRequest()->getParam('wl_product_id');
        $model = Mage::getModel('td_waitlist/waitlist')->getCollection()
            ->addFieldToFilter('customer_id',array('eq'=>Mage::getSingleton('customer/session')->getCustomerId()))
            ->addFieldToFilter('product_id',array('eq'=>$prodId));
        if (count($model) > 0){
            foreach ($model as $item){
                try{
                    $item->delete();
                    Mage::getSingleton('core/session')->addSuccess('Success');
                }catch (Exception $e){
                    Mage::getSingleton('core/session')->addError($e->getMessage());
                }
            }
        }

        $this->_redirectUrl($this->_getRefererUrl());
    }

    public function addtocartAction(){
        Mage::app()->setCurrentStore(Mage_Core_Model_App::ADMIN_STORE_ID);
        $id = $this->getRequest()->getParam('id');
        try{
            $product_model = Mage::getSingleton('catalog/product');
            $my_product     = $product_model->load($id);
            $qty_value = $this->getRequest()->getParam('qty');

            // Add to cart
            $cart = Mage::getModel('checkout/cart');
            $cart->init();
            $cart->addProduct($my_product, array('qty' => $qty_value,'product' => $id));
//            $cart->getItems()->clear();
//            $cart->getItems()->setQuote($cart->getQuote());
            $cart->save();
            Mage::getSingleton('checkout/session')->setCartWasUpdated(true);
            Mage::getSingleton('core/session')->addSuccess('Success');
        }
        catch(Exception $e){
            Mage::getSingleton('core/session')->addError($e->getMessage());
        }

        $this->_redirectUrl($this->_getRefererUrl());

    }
}