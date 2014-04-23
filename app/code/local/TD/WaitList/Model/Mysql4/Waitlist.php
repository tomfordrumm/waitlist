<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 02.04.14
 * Time: 22:14
 */
class TD_WaitList_Model_Mysql4_Waitlist extends Mage_Core_Model_Mysql4_Abstract{
    public function _construct()
    {
        // Note that the bannernext_id refers to the key field in your database table.
        $this->_init('td_waitlist/waitlist', 'id');
    }
}