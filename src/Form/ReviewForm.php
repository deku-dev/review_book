<?php

namespace Drupal\reviews_book\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Review edit forms.
 *
 * @ingroup reviews_book
 */
class ReviewForm extends ContentEntityForm {

  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;

  /**
   * @var $cssCommandDanger
   */
  public $cssCommandDanger;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    $instance = parent::create($container);
    $instance->account = $container->get('current_user');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\reviews_book\Entity\Review $entity */
    $form = parent::buildForm($form, $form_state);
    return $form;
  }

  /**
   * Validate name user ajax.
   */
  public function validateName(array &$form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();
    $len_name = strlen($form_state->getValue('name'));
    if ($len_name < 2) {
      return $response->addCommand(new HtmlCommand('#name-label', 'The user name is to short.'));
    }
    elseif ($len_name > 100) {
      return $response->addCommand(new HtmlCommand('#name-label', 'The user name is to long.'));
    }
    else {
      return $response->addCommand(new HtmlCommand('#name-label', ''));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Review.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Review.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.review.canonical', ['review' => $entity->id()]);
  }

}
