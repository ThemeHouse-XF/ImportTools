<?php

/**
 *
 * @see XenForo_ControllerAdmin_Import
 */
class ThemeHouse_ImportTools_Extend_XenForo_ControllerAdmin_Import extends XFCP_ThemeHouse_ImportTools_Extend_XenForo_ControllerAdmin_Import
{

    /**
     *
     * @see XenForo_ControllerAdmin_Import::actionImport()
     */
    public function actionImport()
    {
        $response = parent::actionImport();

        if ($response instanceof XenForo_ControllerResponse_View) {
            $session = new XenForo_ImportSession();
            $config = $session->getConfig();

            $response->params['isRetainKeys'] = !empty($config['retain_keys']);
        }

        return $response;
    } /* END actionImport */

    /**
     *
     * @return XenForo_ControllerResponse_Abstract
     */
    public function actionRetrieveLog()
    {
        $table = $this->_input->filterSingle('table', XenForo_Input::STRING);

        if ($table) {
            $error = '';
            if (!$this->_getImportModel()->retrieveImportLog($table, $error)) {
                return $this->responseError($error);
            }

            return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS,
                XenForo_Link::buildAdminLink('import/import'));
        }

        $viewParams = array();

        return $this->responseView('ThemeHouse_ImportTools_ViewAdmin_Import_RetrieveLog',
            'th_retrieve_archived_import_log_importtools', $viewParams);
    } /* END actionRetrieveLog */

    /**
     *
     * @return XenForo_ControllerResponse_Abstract
     */
    public function actionSkipStep()
    {
        $step = $this->_input->filterSingle('step', XenForo_Input::STRING);

        $importSession = new ThemeHouse_ImportTools_ImportSession();

        $importSession->skipStep($step);
        $importSession->save();

        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS,
            XenForo_Link::buildAdminLink('import/import'));
    } /* END actionSkipStep */

    /**
     *
     * @return XenForo_ControllerResponse_Abstract
     */
    public function actionUndoStep()
    {
        $step = $this->_input->filterSingle('step', XenForo_Input::STRING);

        $importSession = new ThemeHouse_ImportTools_ImportSession();

        $importSession->undoStep($step);
        $importSession->save();

        return $this->responseRedirect(XenForo_ControllerResponse_Redirect::SUCCESS,
            XenForo_Link::buildAdminLink('import/import'));
    } /* END actionUndoStep */
}