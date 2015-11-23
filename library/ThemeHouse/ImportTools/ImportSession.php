<?php

class ThemeHouse_ImportTools_ImportSession
{

    protected $_data = array();

    public function __construct($fresh = false)
    {
        if (!$fresh) {
            $data = XenForo_Model::create('XenForo_Model_DataRegistry')->get('importSession');
            if ($data) {
                $this->_data = $data;
            }
        }
    } /* END __construct */

    public function save()
    {
        XenForo_Model::create('XenForo_Model_DataRegistry')->set('importSession', $this->_data);
    } /* END save */

    public function undoStep($step)
    {
        if (isset($this->_data['step']) && $this->_data['step'] == $step) {
            unset($this->_data['step']);
            unset($this->_data['stepStart']);
            unset($this->_data['stepOptions']);
        }
        unset($this->_data['runSteps'][$step]);
    } /* END undoStep */

    public function skipStep($step)
    {
        $this->_data['runSteps'][$step] = array(
            'importTotal' => 0,
            'startTime' => microtime(true),
            'run' => 1,
            'endTime' => microtime(true)
        );
    } /* END skipStep */
}