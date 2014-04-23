<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 02.04.14
 * Time: 22:15
 */
class TD_WaitList_Model_Mysql4_Waitlist_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract{
    public function _construct()
    {
        parent::_construct();
        $this->_init('td_waitlist/waitlist');
    }
}