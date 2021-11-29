<?php

namespace Drupal\reviews_book;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\file\Entity\File;
use Drupal\Core\Url;
use Drupal\reviews_book\Entity\Review;

/**
 * Defines a class to build a listing of Review entities.
 *
 * @ingroup reviews_book
 */
class ReviewListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['id'] = $this->t('Review ID');
    $header['name'] = $this->t('Name');
    $header['email'] = $this->t('Email');
    $header['tel'] = $this->t('Tel');
    $header['avatar'] = $this->t('Avatar');
    $header['picture'] = $this->t('Picture');
    $header['text'] = $this->t('Text');
    return $header + parent::buildHeader();
  }

  private function renderImageField(array $images): array {
    foreach ($images as $field => $image) {
      $file = File::load($image['target_id']);
      $fileUri = $file->getFileUri();
      $fileUrl = file_url_transform_relative(Url::fromUri(file_create_url($fileUri))->toString());
      $fileUrl = file_create_url($fileUrl);
      $element = [
        '#theme' => 'image',
        '#uri' => $fileUrl,
        '#alt' => $image['alt'],
        '#title' => $image['title'],
      ];
      $images[$field] = \Drupal::service('renderer')->render($element);
    }
    return $images;

  }



  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var Review $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.review.edit_form',
      ['review' => $entity->id()]
    );
    $row['email'] = $entity->getEmail();
    $row['tel_number'] = $entity->getTel();

    $row['avatar'] = $entity->getAvatar();

    $imageField = $this->renderImageField([
      'avatar' => $entity->getAvatar(),
      'picture' => $entity->getPicture()
    ]);
    $row['picture'] = $imageField['picture'];
    $row['avatar'] = $imageField['avatar'];


    $row['text'] = $entity->getText();

    return $row + parent::buildRow($entity);
  }

}
