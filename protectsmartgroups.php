<?php

require_once 'protectsmartgroups.civix.php';

use CRM_Protectsmartgroups_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function protectsmartgroups_civicrm_config(&$config): void {
  _protectsmartgroups_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function protectsmartgroups_civicrm_install(): void {
  _protectsmartgroups_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function protectsmartgroups_civicrm_enable(): void {
  _protectsmartgroups_civix_civicrm_enable();
}
