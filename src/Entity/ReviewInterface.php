<?php

namespace Drupal\reviews_book\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Review entities.
 *
 * @ingroup reviews_book
 */
interface ReviewInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Review name.
   *
   * @return string
   *   Name of the Review.
   */
  public function getName();

  /**
   * Sets the Review name.
   *
   * @param string $name
   *   The Review name.
   *
   * @return \Drupal\reviews_book\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setName($name);

  /**
   * Gets the Review creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Review.
   */
  public function getCreatedTime();

  /**
   * Sets the Review creation timestamp.
   *
   * @param int $timestamp
   *   The Review creation timestamp.
   *
   * @return \Drupal\reviews_book\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the email for user review.
   *
   * @return string
   *   Email of the review.
   */
  public function getEmail();

  /**
   * Sets the email user review.
   *
   * @param string $email
   *   The email user review.
   *
   * @return \Drupal\reviews_book\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setEmail($email);

  /**
   * Gets the tel number of the user.
   *
   * @return string
   *   Telnumber of the user.
   */
  public function getTel();

  /**
   * Sets user tel number.
   *
   * @param string $tel_number
   *   The tel number of user.
   *
   * @return \Drupal\reviews_book\Entity\ReviewInterface
   *   The called Review entity.
   */
  public function setTel($tel_number);

}
