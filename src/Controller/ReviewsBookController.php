<?php

namespace Drupal\reviews_book\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for reviews_book routes.
 */
class ReviewsBookController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
