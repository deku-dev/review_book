<?php

namespace Drupal\reviews_book\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Defines the Review entity.
 *
 * @ingroup reviews_book
 *
 * @ContentEntityType(
 *   id = "review",
 *   label = @Translation("Review"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\reviews_book\ReviewListBuilder",
 *     "views_data" = "Drupal\reviews_book\Entity\ReviewViewsData",
 *     "translation" = "Drupal\reviews_book\ReviewTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\reviews_book\Form\ReviewForm",
 *       "add" = "Drupal\reviews_book\Form\ReviewForm",
 *       "edit" = "Drupal\reviews_book\Form\ReviewForm",
 *       "delete" = "Drupal\reviews_book\Form\ReviewDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\reviews_book\ReviewHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\reviews_book\ReviewAccessControlHandler",
 *   },
 *   base_table = "review",
 *   data_table = "review_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer review entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *     "email" = "email",
 *     "tel_number" = "tel_number",
 *     "avatar" = "avatar",
 *     "picture" = "picture",
 *     "text_review" = "text_review",
 *   },
 *   links = {
 *     "canonical" = "/review/{review}",
 *     "add-form" = "/reviews/add",
 *     "edit-form" = "/reviews/{review}/edit",
 *     "delete-form" = "/reviews/{review}/delete",
 *     "collection" = "/reviews",
 *   },
 *   field_ui_base_route = "review.settings"
 * )
 */
class Review extends ContentEntityBase implements ReviewInterface {

  use EntityChangedTrait;
  use EntityPublishedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage, array &$values) {
    parent::preCreate($storage, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName(string $name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getEmail() {
    return $this->get('email')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setEmail(string $email) {
    $this->set('name', $email);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getTel() {
    return $this->get('tel_number')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setTel(string $tel_number) {
    $this->set('tel_number', $tel_number);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getAvatar() {
    return $this->get('avatar')->getValue()[0];
  }

  /**
   * {@inheritdoc}
   */
  public function setAvatar(string $avatar) {
    $this->set('avatar', $avatar);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPicture() {
    return $this->get('picture')->getValue()[0];
  }

  /**
   * {@inheritdoc}
   */
  public function setPicture(string $picture) {
    $this->set('picture', $picture);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getText() {
    return $this->get('text_review')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setText(string $text) {
    $this->set('text_review', $text);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime(int $timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner(): UserInterface {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId(): ?int {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid): EntityOwnerInterface {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account): EntityOwnerInterface {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   *
   * @throws \Drupal\Core\Entity\Exception\UnsupportedEntityTypeDefinitionException
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Review entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Review entity.'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setPropertyConstraints('value', [
        'Length' => [
          'min' => 2,
          'minMessage' => t('Your name is to short. Please enter valid name.'),
          'maxMessage' => t('Your name is to long. Please enter valid name.'),
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('The email of the user.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'email',
        'weight' => -5,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_email',
        'weight' => -6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['tel_number'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Tel number'))
      ->setDescription(t('The tel number of the user.'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'tel',
        'weight' => -7,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_tel',
        'weight' => -8,
      ])
      ->setPropertyConstraints(
        'value', [
          'Regex' => [
            'pattern' => '/^\+?\d{10,15}$/',
            'message' => t('Your number mobile is not valid. Please enter the valid tel number'),
          ],
        ]
      )
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['avatar'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Avatar user'))
      ->setDescription(t('User avatar who create the review.'))
      ->setDefaultValue(NULL)
      ->setSettings([
        'file_directory' => 'public://reviews_book/avatar',
        'alt_field_required' => FALSE,
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 2 * 1024 * 1024,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'label' => 'hidden',
        'type' => 'image_image',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['picture'] = BaseFieldDefinition::create('image')
      ->setLabel(t('Review picture'))
      ->setDescription(t('Review picture for review.'))
      ->setDefaultValue(NULL)
      ->setSettings([
        'file_directory' => 'public://reviews_book/picture',
        'alt_field_required' => FALSE,
        'file_extensions' => 'png jpg jpeg',
        'max_filesize' => 5 * 1024 * 1024,
      ])
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'label' => 'hidden',
        'type' => 'image_image',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['text_review'] = BaseFieldDefinition::create('string_long')
      ->setLabel(t('Review text'))
      ->setDescription(t('The review text.'))
      ->setSettings([
        'max_length' => 100,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setPropertyConstraints('value', [
        'Length' => [
          'min' => 2,
          'minMessage' => t('Your name is to short. Please enter valid name.'),
        ],
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE)
      ->setRequired(TRUE);

    $fields['status']->setDescription(t('A boolean indicating whether the Review is published.'))
      ->setDisplayOptions('form', [
        'type' => 'boolean_checkbox',
        'weight' => -3,
      ]);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
