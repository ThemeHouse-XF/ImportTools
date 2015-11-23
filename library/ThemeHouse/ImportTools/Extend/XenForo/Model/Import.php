<?php

/**
 *
 * @see XenForo_Model_Import
 */
class ThemeHouse_ImportTools_Extend_XenForo_Model_Import extends XFCP_ThemeHouse_ImportTools_Extend_XenForo_Model_Import
{

    /**
     * Renames the import log table before creating a new empty version.
     *
     * @param string Archive table name
     * @param mixed Error phrase reference
     *
     * @return boolean
     */
    public function retrieveImportLog($archiveTableName, &$error)
    {
        $db = $this->_getDb();

        if (preg_match('/[^a-z0-9_]/i', $archiveTableName)) {
            $error = new XenForo_Phrase('error_table_name_illegal');
            return false;
        }

        try {
            $db->query("DROP TABLE IF EXISTS xf_import_log_old");

            $db->query("ALTER TABLE xf_import_log RENAME xf_import_log_old");

            $db->query("ALTER TABLE {$archiveTableName} RENAME xf_import_log");
        } catch (Zend_Db_Exception $e) {
            $error = new XenForo_Phrase('th_error_unable_to_retrieve_table_due_to_error_importtools',
                array(
                    'table' => $archiveTableName,
                    'error' => $e->getMessage()
                ));

            $db->query("ALTER TABLE xf_import_log_old RENAME xf_import_log");

            return false;
        }

        return true;
    } /* END retrieveImportLog */

    /**
     *
     * @see XenForo_Model_Import::_importData
     */
    protected function _importData($oldId, $dwName, $contentKey, $idKey, array $info, $errorHandler = false, $update = false)
    {
        $ids = $this->getImportContentMap($contentKey, $oldId);
        if ($ids)
            return reset($ids);

        return parent::_importData($oldId, $dwName, $contentKey, $idKey, $info, $errorHandler, $update);
    } /* END _importData */
}