<?php
use CRM_Multilingualmailing_ExtensionUtil as E;

class CRM_Multilingualmailing_BAO_MultilingualMailing extends CRM_Multilingualmailing_DAO_MultilingualMailing {

  /**
   * Create a new MultilingualMailing based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Multilingualmailing_DAO_MultilingualMailing|NULL
   *
  public static function create($params) {
    $className = 'CRM_Multilingualmailing_DAO_MultilingualMailing';
    $entityName = 'MultilingualMailing';
    $hook = empty($params['id']) ? 'create' : 'edit';

    CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
    $instance = new $className();
    $instance->copyValues($params);
    $instance->save();
    CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

    return $instance;
  } */

  public static function fetchLanguage($mid) {
    return CRM_Core_DAO::singleValueQuery("SELECT language FROM civicrm_mailing WHERE id = %1", [1 => [$mid, "Integer"]]);
  }

  public static function fetchLanguageText($language) {
    if ($language == 'en_US') {
      return "View this email in your browser";
    }
    elseif ($language == 'fr_CA') {
      return "Cliquez ici pour ce couriel en français";
    }
  }
}
