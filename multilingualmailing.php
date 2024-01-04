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
  Civi::dispatcher()->addListener('civi.token.eval', 'multilingualmailing_token_eval', 100);
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
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function multilingualmailing_civicrm_enable() {
  _multilingualmailing_civix_civicrm_enable();
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
}

function multilingualmailing_civicrm_alterAngular($angular) {
  $changeSet = \Civi\Angular\ChangeSet::create('inject_translation')
    ->alterHtml('~/crmMosaico/BlockMailing.html',
      function (phpQueryObject $doc) {
        $doc->find('.form-group-lg')->append('
          <div class="form-group" crm-ui-field="{name: \'subform.frenchmail\', title: ts(\'Alternative Language Mailing\')}" crm-remove-class>
            <input
              crm-entityref="{entity: \'Mailing\', select: {allowClear: true, placeholder: ts(\'Select Alternative Language Mailing\'), width: \'36em\'}}"
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

/**
 * Implements hook_civicrm_alterMailParams().
 *
 * This is done so that the text portion of the email is correctly re-calibrated after we add in the links to the french mailing.
 */
function multilingualmailing_civicrm_alterMailParams(&$params, $context) {
  if ($context === 'flexmailer') {
    $params['text'] = CRM_Utils_String::htmlToText($params['html']);
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

function multilingualmailing_token_eval($event) {
  foreach ($event->getRows() as $row) {
    $mailingId = $event->getTokenProcessor()->getContextValues('mailingId')[0] ?? FALSE;
    if ($mailingId) {
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
        $row->format('text/html');
        $row->tokens('mailing', 'viewTranslationLinks', '<a style="color:#ffffff;text-decoration:none;" href="' . $currentURL . '">' . $currentLanguageText . '</a>&nbsp;&nbsp;&nbsp;&nbsp;<a style="color:#ffffff;text-decoration:none;" href="'. $altURL .'">' . $altLanguageText . '</a>');
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
