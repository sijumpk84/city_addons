<?php

namespace Drupal\city_importer\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Url;
use Drupal\migrate\MigrateMessage;
use Drupal\migrate_tools\MigrateExecutable;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Defines a controller to run the migration script.
 */
class DoRunMigration extends ControllerBase
{

  /**
   * The messenger service.
   *
   * @var MessengerInterface
   */
  protected $messenger;

  /**
   * Constructs an DoRunMigration object.
   *
   * @param MessengerInterface $messenger
   */
  public function __construct(MessengerInterface $messenger) {
    $this->messenger = $messenger;
  }

  /**
   * Doing the migration action
   *
   * @return RedirectResponse
   */
  public function runMigration() {
    $migration = \Drupal::service('plugin.manager.migration')->createInstance('migration_cities');
    $migration->getIdMap()->prepareUpdate();
    $executable = new MigrateExecutable($migration, new MigrateMessage());
    $executable->import();
    $this->messenger->addMessage($this->t("Processed @created items and updated @updated items", ['@created' => $executable->getCreatedCount(), '@updated' => $executable->getUpdatedCount()]));
    return new RedirectResponse(Url::fromRoute('city_importer.admin_page')->toString());
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get("messenger")
    );
  }
}
