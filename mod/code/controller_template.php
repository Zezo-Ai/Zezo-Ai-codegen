<?php
/**
 * App Controller class.
 * Code Generated by the Code Generator module of ZnetDK 4 Mobile.
 */
namespace __CONTROLLER_NAMESPACE__;
class __CONTROLLER_CLASS_NAME__ extends \AppController {
    static public function isActionAllowed($action) {
        $status = parent::isActionAllowed($action);
        if ($status === FALSE) {
            return FALSE;
        }
        $menuItem = '{{VIEW_NAME}}';
        return CFG_AUTHENT_REQUIRED === TRUE
            ? \controller\Users::hasMenuItem($menuItem) // User has right on menu item
            : \MenuManager::getMenuItem($menuItem) !== NULL; // Menu item declared in 'menu.php'
    }
    static protected function action_all() {
        $response = new \Response();
        $rows = [];
        $dao = new __DAO_CLASS__;
        $dao->setKeywordSearchColumn('{{SEARCH_COLUMN}}');
        $response->total = $dao->getRows($rows, 'id DESC');
        $response->rows = $rows;
        return $response;
    }
    static protected function action_detail() {
        $request = new \Request();
        $dao = new __DAO_CLASS__;
        $detail = $dao->getById($request->id);
        $response = new \Response();
        if (is_array($detail)) {
            $response->setResponse($detail);
        } else {
            $response->setWarningMessage(NULL, LC_MSG_INF_NO_RESULT_FOUND);
        }
        return $response;
    }
    static protected function action_store() {
        $response = new \Response();
        $validator = new __VALIDATOR_CLASS__;
        $validator->setCheckingMissingValues();
        if (!$validator->validate()) {
            $response->setFailedMessage(NULL, $validator->getErrorMessage(),
                $validator->getErrorVariable());
            return $response;
        }
        $request = new \Request();
        $formData = $request->getValuesAsMap(__PROPERTY_NAMES__);
        $dao = new __DAO_CLASS__;
        $rowId = $dao->store($formData);
        $response->setSuccessMessage(NULL, LC_MSG_INF_SAVE_RECORD . " ID={$rowId}.");
        return $response;
    }
    static protected function action_suggestions() {
        $dao = new __DAO_CLASS__;
        $dao->setKeywordSearchColumn('{{SEARCH_COLUMN}}');
        $suggestions = $dao->getSuggestions();
        $response = new \Response();
        $response->setResponse($suggestions);
        return $response;
    }
    static protected function action_remove() {
        $request = new \Request();
        $dao = new __DAO_CLASS__;
        $rowFound = $dao->getById($request->id);
        $response = new \Response();
        if (is_array($rowFound)) {
            $dao->remove($rowFound['id']);
            $response->setSuccessMessage(NULL, LC_MSG_INF_REMOVE_RECORD . " ID={$rowFound['id']}.");
        } else {
            $response->setFailedMessage(NULL, LC_MSG_INF_NO_RESULT_FOUND .  " ID={$request->id}.");
        }
        return $response;
    }
}