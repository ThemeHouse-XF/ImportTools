<?php

class ThemeHouse_ImportTools_Listener_LoadClass extends ThemeHouse_Listener_LoadClass
{

    protected function _getExtendedClasses()
    {
        return array(
            'ThemeHouse_ImportTools' => array(
                'controller' => array(
                    'XenForo_ControllerAdmin_Import'
                ), /* END 'controller' */
                'model' => array(
                    'XenForo_Model_Import'
                ), /* END 'model' */
            ), /* END 'ThemeHouse_ImportTools' */
        );
    } /* END _getExtendedClasses */

    public static function loadClassController($class, array &$extend)
    {
        $loadClassController = new ThemeHouse_ImportTools_Listener_LoadClass($class, $extend, 'controller');
        $extend = $loadClassController->run();
    } /* END loadClassController */

    public static function loadClassModel($class, array &$extend)
    {
        $loadClassModel = new ThemeHouse_ImportTools_Listener_LoadClass($class, $extend, 'model');
        $extend = $loadClassModel->run();
    } /* END loadClassModel */
}