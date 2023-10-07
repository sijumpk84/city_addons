<?php

namespace Drupal\city_content\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
/**
 * Represents a City entity.
 */
interface CityInterface extends ContentEntityInterface, EntityChangedInterface {

  /**
   * Gets the RemoteId.
   *
   * @return string
   */
  public function getRemoteId();
  /**
   * Sets the RemoteId.
   *
   * @param string $remote_id
   *
   * @return \Drupal\city_content\Entity\City
   *   The called City entity.
   */
  public function setRemoteId($remote_id);

  /**
   * Gets the Title.
   *
   * @return string
   */
  public function getTitle();
  /**
   * Sets the Title.
   *
   * @param string $title
   *
   * @return \Drupal\city_content\Entity\City
   *   The called City entity.
   */
  public function setTitle($title);

  /**
   * Gets the City name.
   *
   * @return string
   */
  public function getCity();
  /**
   * Sets the City name.
   *
   * @param string $city
   *
   * @return \Drupal\city_content\Entity\City
   *   The called City entity.
   */
  public function setCity($city);

  /**
   * Gets the Location.
   *
   * @return array
   */
  public function getLoc();
  /**
   * Sets the Location.
   *
   * @param array $loc
   *
   * @return \Drupal\city_content\Entity\City
   *   The called City entity.
   */
  public function setLoc($loc);

  /**
   * Gets the Pop.
   *
   * @return int
   */
  public function getPop();
  /**
   * Sets the Pop.
   *
   * @param int $pop
   *
   * @return \Drupal\city_content\Entity\City
   *   The called City entity.
   */
  public function setPop($pop);

  /**
   * Gets the State.
   *
   * @return string
   */
  public function getState();
  /**
   * Sets the State.
   *
   * @param string $state
   *
   * @return \Drupal\city_content\Entity\City
   *   The called City entity.
   */
  public function setState($state);
}
