<?php
use CRM_Multilingualmailing_ExtensionUtil as E;

return [
  'name' => 'MultilingualMailing',
  'table' => 'civicrm_multilingual_mailing',
  'class' => 'CRM_Multilingualmailing_DAO_MultilingualMailing',
  'getInfo' => fn() => [
    'title' => E::ts('Multilingual Mailing'),
    'title_plural' => E::ts('Multilingual Mailings'),
    'description' => E::ts('FIXME'),
    'log' => TRUE,
  ],
  'getFields' => fn() => [
    'id' => [
      'title' => E::ts('ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'required' => TRUE,
      'description' => E::ts('Unique MultilingualMailing ID'),
      'primary_key' => TRUE,
      'auto_increment' => TRUE,
    ],
    'mailing_id' => [
      'title' => E::ts('Mailing ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'description' => E::ts('FK to Mailing'),
    ],
    'frenchmail_id' => [
      'title' => E::ts('Frenchmail ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'EntityRef',
      'description' => E::ts('FK to Mailing'),
      'entity_reference' => [
        'entity' => 'Mailing',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
    ],
    'contact_id' => [
      'entity_reference' => [
        'entity' => 'Mailing',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
      'input_type' => 'EntityRef',
    ],
  ],
];
