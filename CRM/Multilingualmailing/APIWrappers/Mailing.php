<?php

class CRM_Multilingualmailing_APIWrappers_Mailing implements API_Wrapper {

  /**
   * Conditionally changes contact_type parameter for the API request.
   */
  public function fromApiInput($apiRequest) {
    return $apiRequest;
  }

  public function toApiOutput($apiRequest, $result) {
    if ($apiRequest['entity'] == 'Mailing' && $apiRequest['action'] == 'create') {
      if (!empty($result['id']) && !empty($apiRequest['params']['frenchmail_id'])) {
        $frenchMail = new CRM_Multilingualmailing_DAO_MultilingualMailing();
        $frenchMail->mailing_id = $result['id'];
        $frenchMail->find(TRUE);
        $frenchMail->frenchmail_id = $apiRequest['params']['frenchmail_id'];
        $frenchMail->save();
      }
    }
    if ($apiRequest['entity'] == 'Mailing' && $apiRequest['action'] == 'getsingle') {
      if (!empty($result['id'])) {
        $frenchMail = new CRM_Multilingualmailing_DAO_MultilingualMailing();
        $frenchMail->mailing_id = $result['id'];
        $frenchMail->find(TRUE);
        $result['frenchmail_id'] = $frenchMail->frenchmail_id;
      }
    }
    return $result;
  }
}
