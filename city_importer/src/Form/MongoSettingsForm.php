<?php

namespace Drupal\city_importer\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Admin Mongo field mapping.
 */
class MongoSettingsForm extends ConfigFormBase  {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'city_importer.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'city_importer_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $entity_field_names = $this->getEntityFieldNames();
    $json_field_names = $this->getJsonFieldNames();
    $options = [];
    foreach ($json_field_names as $json_field_name) {
      $options[$json_field_name] = $json_field_name;
    }
    foreach ($entity_field_names as $entity_field_name) {
      $form[$entity_field_name] = [
        '#type' => 'select',
        '#options' => $options,
        '#title' => $this->t(ucwords(str_replace("_", " ", $entity_field_name)) . " value source"),
        '#default_value' => $config->get($entity_field_name) == null ? $entity_field_name : $config->get($entity_field_name),
        '#attributes' => ['class' => ['container-inline']],
      ];
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $config = $this->config(static::SETTINGS);
    $entity_field_names = $this->getEntityFieldNames();

    foreach ($entity_field_names as $entity_field_name) {
      $config->set($entity_field_name, $form_state->getValue($entity_field_name));
    }
    $config->save();
    parent::submitForm($form, $form_state);
  }


  /**
   * Provides the list of json keys
   *
   * @return string[]
   */
  public function getJsonFieldNames() {
    return [
      'remote_id',
      'city',
      'pop',
      'state'
    ];
  }

  /**
   * Provides the list of entity field keys
   *
   * @return string[]
   */
  public static function getEntityFieldNames() {
    return [
      'title',
      'city',
      'state'
    ];
  }
}
