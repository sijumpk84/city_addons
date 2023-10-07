<?php

namespace Drupal\city_content;

use Drupal\city_content\Entity\City;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;

/**
 * EntityListBuilderInterface implementation responsible for the City entities.
 */
class CityListBuilder extends EntityListBuilder {
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Title');
    return $header + parent::buildHeader();
  }
  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity City */
    $row['title'] = $entity->getTitle();
    return $row + parent::buildRow($entity);
  }
}
