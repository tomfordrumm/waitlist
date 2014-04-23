<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 02.04.14
 * Time: 17:29
 */ 
class TD_WaitList_Helper_Data extends Mage_Core_Helper_Abstract {

    const XML_PATH_EMAIL = 'customer/waitlist/template';

    public function sendMail($email,$product){
        $templateConfigPath = self::XML_PATH_EMAIL;
        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */

        $template = Mage::getStoreConfig(self::XML_PATH_EMAIL, Mage::app()->getStore()->getId());

        $sendTo = array();
        $sendTo[] = array(
            'email' => $email,
            'name' => null,
        );
        $data = array(
            'product'  => $product
//            'url'   => $product->getProductUrl()
        );

        foreach ($sendTo as $recipient) {
            $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>Mage::app()->getStore()->getId()))
                ->sendTransactional(
                    $template,
                    Mage::getStoreConfig(Mage_Sales_Model_Order::XML_PATH_EMAIL_IDENTITY,Mage::app()->getStore()->getId()),
                    $recipient['email'],
                    $recipient['name'],
                    $data
                );
        }

        $translate->setTranslateInline(true);

        return $this;
    }

    public function getAddUrl($product_id){
        $customerId = Mage::getSingleton('customer/session')->getCustomerId();
        if (Mage::getSingleton('customer/session')->isLoggedIn()){
            $wlUrl = Mage::getUrl('waitlist/index/add').'wl_customer_id/'.$customerId.'/wl_product_id/'.$product_id;
        } else {
            $wlUrl = Mage::getUrl('customer/account/login');
        }

        return $wlUrl;
    }
}