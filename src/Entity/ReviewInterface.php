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
   */
  public function getName();

  /**
   * Sets the Review name.
   *
   * @param string $name
   *   The Review name.
   */
  public function setName(string $name);

  /**
   * Gets the Review creation timestamp.
   */
  public function getCreatedTime();

  /**
   * Sets the Review creation timestamp.
   *
   * @param int $timestamp
   *   The Review creation timestamp.
   */
  public function setCreatedTime(int $timestamp);

  /**
   * Gets the email for user review.
   */
  public function getEmail();

  /**
   * Sets the email user review.
   *
   * @param string $email
   *   The email user review.
   */
  public function setEmail(string $email);

  /**
   * Gets the tel number of the user.
   */
  public function getTel();

  /**
   * Sets user tel number.
   *
   * @param string $tel_number
   *   The tel number of user.
   */
  public function setTel(string $tel_number);

  /**
   * Gets the avatar of the user who created review.
   */
  public function getAvatar();

  /**
   * Sets avatar of the user who created review.
   *
   * @param string $avatar
   *   The avatar user.
   */
  public function setAvatar(string $avatar);

  /**
   * Gets picture review.
   */
  public function getPicture();

  /**
   * Sets picture review.
   *
   * @param string $picture
   *   Review picture.
   */
  public function setPicture(string $picture);

  /**
   * Gets text review.
   */
  public function getText();

  /**
   * Sets text review.
   *
   * @param string $text
   *   Review text.
   */
  public function setText(string $text);

}
