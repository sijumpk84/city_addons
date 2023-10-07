<?php

namespace Drupal\city_importer\Plugin\migrate\source;

use Drupal\city_importer\Form\MongoSettingsForm;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\migrate\Plugin\migrate\source\SourcePluginBase;
use Drupal\migrate\Plugin\MigrationInterface;

/**
 * Mongo database source plugin.
 *
 * @MigrateSource(
 *   id = "mongodb",
 * )
 */
class MongoSource extends SourcePluginBase {

  /** @var ConfigFactoryInterface  */
  protected $configFactory;
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $migration);
    $this->configFactory = \Drupal::configFactory();
  }

  /**
   * {@inheritdoc}
   */
  public function __toString() {
    return 'Mongo Data';
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return [
      'remote_id' => $this->t('The row numeric identifier.'),
      'title' => $this->t('Title'),
      'city' => $this->t('City name'),
      'state' => $this->t('State name'),
      'loc_lat' =>  $this->t('Location latitude'),
      'loc_lon' =>  $this->t('Location longitude'),
      'pop' =>  $this->t('Pop'),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getIds() {
    $ids['remote_id']['type'] = 'string';
    return $ids;
  }

  /**
   * {@inheritdoc}
   */
  public function initializeIterator() {
    $db_string = 'mongodb://localhost:27017';
    $mongo = new \MongoDB\Driver\Manager($db_string);

    $map_config = $this->configFactory->get(MongoSettingsForm::SETTINGS);
    $entity_field_names = MongoSettingsForm::getEntityFieldNames();
    $entity_to_json_map = [];

    foreach ($entity_field_names as $entity_field_name) {
      $json_key = $map_config->get($entity_field_name);
      if ($json_key) {
        $entity_to_json_map[$entity_field_name] = $json_key;
      }
    }

    $query = new \MongoDB\Driver\Query([]);
    $rows = $mongo->executeQuery("Blog.content", $query);
    $cursor = $rows;
    $array = [];

    foreach ($cursor as $values) {
      $values = (array) ($values);
      $values['remote_id'] = $values['_id'];
      $item = [
        'remote_id' => $values['remote_id'],
        'title' => $values['remote_id'],
        'city' => $values['city'],
        'loc_lat' => $values['loc'][0],
        'loc_lon' => $values['loc'][1],
        'pop' => $values['pop'],
        'state' => $values['state'],
      ];

      foreach ($entity_to_json_map as $entity_field_name => $json_key) {
        $item[$entity_field_name] = $values[$json_key];
      }
      $array[] = $item;
    }
    return new \ArrayIterator($array);
  }
}
