<?php
/**
 * Created by PhpStorm.
 * User: svatoslavzilicev
 * Date: 02.04.14
 * Time: 22:13
 */
class TD_WaitList_Model_Waitlist extends Mage_Core_Model_Abstract{
    public function _construct()
    {
        parent::_construct();
        $this->_init('td_waitlist/waitlist');
    }
}