<?php

require_once 'multilingualmailing.civix.php';
use CRM_Multilingualmailing_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function multilingualmailing_civicrm_config(&$config) {
  _multilingualmailing_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_xmlMenu
 */
function multilingualmailing_civicrm_xmlMenu(&$files) {
  _multilingualmailing_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function multilingualmailing_civicrm_install() {
  _multilingualmailing_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_postInstall
 */
function multilingualmailing_civicrm_postInstall() {
  _multilingualmailing_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_uninstall
 */
function multilingualmailing_civicrm_uninstall() {
  _multilingualmailing_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function multilingualmailing_civicrm_enable() {
  _multilingualmailing_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_disable
 */
function multilingualmailing_civicrm_disable() {
  _multilingualmailing_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_upgrade
 */
function multilingualmailing_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _multilingualmailing_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_managed
 */
function multilingualmailing_civicrm_managed(&$entities) {
  _multilingualmailing_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_caseTypes
 */
function multilingualmailing_civicrm_caseTypes(&$caseTypes) {
  _multilingualmailing_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_angularModules
 */
function multilingualmailing_civicrm_angularModules(&$angularModules) {
  $angularModules['myAngularModule'] = array(
    'ext' => 'biz.jmaconsulting.multilingualmailing',
    'js' => array('js/removeclass.js'),
  );
  _multilingualmailing_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_alterSettingsFolders
 */
function multilingualmailing_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _multilingualmailing_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function multilingualmailing_civicrm_entityTypes(&$entityTypes) {
  _multilingualmailing_civix_civicrm_entityTypes($entityTypes);
}

/**
 * Implements hook_civicrm_thems().
 */
function multilingualmailing_civicrm_themes(&$themes) {
  _multilingualmailing_civix_civicrm_themes($themes);
}

function multilingualmailing_civicrm_alterAngular($angular) {
  $changeSet = \Civi\Angular\ChangeSet::create('inject_translation')
    ->alterHtml('~/crmMosaico/BlockMailing.html',
      function (phpQueryObject $doc) {
        $doc->find('.form-group-lg')->append('
          <div class="form-group" crm-ui-field="{name: \'subform.frenchmail\', title: ts(\'Alternative Language Mailing\')}" crm-remove-class>
            <input
              crm-entityref="{entity: \'Mailing\', select: {allowClear: true, placeholder: ts(\'Select Alternative Language Mailing\')}}"
              crm-ui-id="subform.frenchmail"
              name="frenchmail"
              ng-model="mailing.frenchmail_id"
             />
          </div>
        ');
      });
  $angular->add($changeSet);
}

/**
  * Implements hook_civicrm_apiWrappers().
  */
function multilingualmailing_civicrm_apiWrappers(&$wrappers, $apiRequest) {
  // The APIWrapper is conditionally registered so that it runs only when appropriate
  if ($apiRequest['entity'] == 'Mailing' && $apiRequest['action'] == 'create') {
      $wrappers[] = new CRM_Multilingualmailing_APIWrappers_Mailing();
  }
  if ($apiRequest['entity'] == 'Mailing' && $apiRequest['action'] == 'getsingle') {
    $wrappers[] = new CRM_Multilingualmailing_APIWrappers_Mailing();
  }
}

function multilingualmailing_civicrm_tokens(&$tokens) {
  $tokens['mailing'] = array(
    'mailing.viewTranslationLinks' => 'Translated Mailing Link',
  );
}

function multilingualmailing_civicrm_tokenValues(&$values, $cids, $job = null, $tokens = array(), $context = null) {
  // Date tokens
  if (!empty($tokens['mailing']) && $job) {
    $mailingId = CRM_Core_DAO::singleValueQuery("SELECT mailing_id FROM civicrm_mailing_job WHERE id = %1", [1 => [$job, "Integer"]]);
    if (!empty($mailingId)) {
      $currentLanguage = CRM_Multilingualmailing_BAO_MultilingualMailing::fetchLanguage($mailingId);
      $currentLanguageText = CRM_Multilingualmailing_BAO_MultilingualMailing::fetchLanguageText($currentLanguage);
      $currentURL = CRM_Utils_System::url('civicrm/mailing/view', "reset=1&id={$mailingId}", TRUE);

      $frenchMail = new CRM_Multilingualmailing_DAO_MultilingualMailing();
      $frenchMail->mailing_id = $mailingId;
      $frenchMail->find(TRUE);
      if (!empty($frenchMail->frenchmail_id)) {
        $altLanguage = CRM_Multilingualmailing_BAO_MultilingualMailing::fetchLanguage($frenchMail->frenchmail_id);
        $altLanguageText = CRM_Multilingualmailing_BAO_MultilingualMailing::fetchLanguageText($altLanguage);
        $altURL = CRM_Utils_System::url('civicrm/mailing/view', "reset=1&id={$frenchMail->frenchmail_id}", TRUE);
        $mail = [
          'mailing.viewTranslationLinks' => "<a style='color:#ffffff;text-decoration:none;' href='{$currentURL}'>{$currentLanguageText}</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style='color:#ffffff;text-decoration:none;' href='{$altURL}'>{$altLanguageText}</a>",
        ];
        foreach ($cids as $cid) {
          $values[$cid] = empty($values[$cid]) ? $mail : $values[$cid] + $mail;
        }
      }
    }
  }
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 *
 * /
function multilingualmailing_civicrm_preProcess($formName, &$form) {

}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 *
function multilingualmailing_civicrm_navigationMenu(&$menu) {
  _multilingualmailing_civix_insert_navigation_menu($menu, 'Mailings', array(
    'label' => E::ts('New subliminal message'),
    'name' => 'mailing_subliminal_message',
    'url' => 'civicrm/mailing/subliminal',
    'permission' => 'access CiviMail',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _multilingualmailing_civix_navigationMenu($menu);
} // */
