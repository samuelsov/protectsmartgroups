<?php

require_once 'protectdynamicgroups.civix.php';

use CRM_Protectdynamicgroups_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function protectdynamicgroups_civicrm_config(&$config): void {
  _protectdynamicgroups_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function protectdynamicgroups_civicrm_install(): void {
  _protectdynamicgroups_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function protectdynamicgroups_civicrm_enable(): void {
  _protectdynamicgroups_civix_civicrm_enable();
}
