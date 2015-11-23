<?php

class ThemeHouse_ImportTools_Listener_TemplatePostRender extends ThemeHouse_Listener_TemplatePostRender
{

    protected function _getTemplates()
    {
        return array(
            'import_steps'
        );
    } /* END _getTemplates */

    public static function templatePostRender($templateName, &$content, array &$containerData,
        XenForo_Template_Abstract $template)
    {
        $templatePostRender = new ThemeHouse_ImportTools_Listener_TemplatePostRender($templateName, $content,
            $containerData, $template);
        list($content, $containerData) = $templatePostRender->run();
    } /* END templatePostRender */

    protected function _importSteps()
    {
        $viewParams = $this->_fetchViewParams();
        $steps = $viewParams['steps'];
        foreach ($steps as $step => $info) {
            $viewParams['step'] = $step;
            $pattern = '#<input type="submit" name="step_' . $step . '"[^>]*>#';
            if ($info['runnable'] && !$info['hasRun']) {
                if ($step != 'forums' || !$viewParams['isRetainKeys'] ||
                     XenForo_Application::getOptions()->th_importTools_canSkipRetainKeysForumsStep) {
                    $this->_appendTemplateAtPattern($pattern, 'th_skip_step_button_importtools', $viewParams);
                }
            } elseif ($info['hasRun']) {
                $this->_appendTemplateAtPattern($pattern, 'th_undo_step_button_importtools', $viewParams);
            }
        }
    } /* END _importSteps */
}