<?php

namespace Drupal\reviews_book\Controller;

use Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException;
use Drupal\Component\Plugin\Exception\PluginNotFoundException;
use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for reviews_book routes.
 */
class ReviewsBookController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

//    $form_add = \Drupal::formBuilder()->getForm('Drupal\reviews_book\Form\ReviewForm');

    $entity = \Drupal::entityTypeManager()->getStorage('review');
    $query = $entity->getQuery();
    $ids = $query->condition('status', 1)
      ->sort('created', 'DESC')
      ->pager(5)
      ->execute();

    $reviews = $entity->loadMultiple($ids);

    $pager = [
      '#type' => 'pager',
    ];

    return [
      '#theme' => 'reviews_book',
      '#form_add' => $form_add,
      '#reviews' => $reviews,
      '#pager' => $pager,
    ];
  }

}
