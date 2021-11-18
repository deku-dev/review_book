<?php

namespace Drupal\reviews_book;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\file\Entity\File;

/**
 * Defines a class to build a listing of Review entities.
 *
 * @ingroup reviews_book
 */
class ReviewListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Review ID');
    $header['name'] = $this->t('Name');
    $header['email'] = $this->t('Email');
    $header['tel'] = $this->t('Tel');
    $header['avatar'] = $this->t('Avatar');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\reviews_book\Entity\Review $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.review.edit_form',
      ['review' => $entity->id()]
    );
    $row['email'] = $entity->getEmail();
    $row['tel_number'] = $entity->getTel();

    $file = File::load($entity->getAvatar());

    $row['avatar'] = $file;

    return $row + parent::buildRow($entity);
  }

}
