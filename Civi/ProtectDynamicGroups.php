<?php

namespace Civi;

use CRM_Protectdynamicgroups_ExtensionUtil as E;
use Civi\Core\Service\AutoService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Protect dynamic groups by forbiding static contact add
 * @internal
 * @service
 */
class ProtectDynamicGroups extends AutoService implements EventSubscriberInterface {

  /**
   * @return array
   */
  public static function getSubscribedEvents() {
    return [
      'hook_civicrm_permission' => ['permission'],
      'hook_civicrm_buildForm' => ['buildForm'],
    ];
  }

  public static function permission($event) {
    $event->permissions['bypass smart group protection'] = [
      'label' => E::ts('Bypass Smart Group Protection'),
      'description' => E::ts('Allow user to manually add contacts to a Smart Group'),
    ];
  }

  public static function buildForm($event) {
    $formName = $event->formName;

    $forms = [
      'CRM_Contact_Form_Contact',
      'CRM_Contact_Form_GroupContact',
      'CRM_Contact_Form_Task_AddToGroup',
    ];
    if (in_array($formName, $forms)) {
      if (!\CRM_Core_Permission::check('bypass smart group protection')) {
        $form = $event->form;
        if ($formName == 'CRM_Contact_Form_Contact') {
          $elementName = 'group';
          if ($form->elementExists($elementName)) {
            $element = $form->getElement($elementName);
            $data = json_decode($element->_attributes['data-select-params'],1);
            $options = $data['data'];

            foreach ($options as $idx => $option) {
              // Vérifier via APIv4 si le groupe est dynamique
              $group = \Civi\Api4\Group::get(FALSE)
                ->addSelect('saved_search_id')
                ->addWhere('id', '=', $option['id'])
                ->execute()
                ->first()
              ;

              if (!empty($group['saved_search_id'])) {
                // disable the attribute
                $options[$idx]['disabled'] = 'disabled';
                // add a mention to clarify why it's not available
                $options[$idx]['text'] .= ' (' . E::ts('Protected Smart Group') . ')';

                // doesn't seems possible to disable here
                unset($options[$idx]);
              }
            }

            // update options
            $data['data'] = array_values($options);
            $element->_attributes['data-select-params'] = json_encode($data);
          }
        }
        else {
          $elementName = 'group_id';
          if ($form->elementExists($elementName)) {
            $element = $form->getElement($elementName);
            $options = $element->_options;
            foreach ($options as $key => $label) {
              // Vérifier via APIv4 si le groupe est dynamique
              $group = \Civi\Api4\Group::get(FALSE)
                ->addSelect('saved_search_id')
                ->addWhere('id', '=', $label['attr']['value'])
                ->execute()
                ->first()
              ;

              if (!empty($group['saved_search_id'])) {
                // disable the attribute
                $options[$key]['attr']['disabled'] = 'disabled';
                // add a mention to clarify why it's not available
                $options[$key]['text'] .= ' (' . E::ts('Protected Smart Group') . ')';
              }
            }

            // update options
            $element->_options = $options;
          }
        }
      }
    }
  }

}