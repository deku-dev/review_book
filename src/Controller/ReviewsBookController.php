<?php

namespace Drupal\reviews_book\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for reviews_book routes.
 */
class ReviewsBookController extends ControllerBase {


  protected $entityManager;


  protected $formBuilder;

  public static function create(ContainerInterface $container)
  {
    $instance = parent::create($container);
    $instance->entityManager = $container->get('entity_type.manager');
    $instance->formBuilder = $container->get('entity.form_builder');
    return $instance;
  }

  /**
   * Builds the response.
   */
  public function build() {

    $form_add = \Drupal::formBuilder()->getForm('Drupal\reviews_book\Form\ReviewsAdd');

    $entity = $this->entityManager
      ->getStorage('review')
      ->create([
        'entity_type' => 'node',
        'entity' => 'review',
      ]);

    $form_add = $this->formBuilder->getForm($entity, 'add');

    $builder = $this->entityTypeManager()->getViewBuilder('review');
    $storage = $this->entityManager->getStorage('review');
    $query = $storage->getQuery();
    $ids = $query->condition('status', 1)
      ->sort('created', 'DESC')
      ->pager(5)
      ->execute();

    $reviews = $storage->loadMultiple($ids);

    foreach ($reviews as $key => $review) {
      $reviews[$key] = $builder->view($review);
    }

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
