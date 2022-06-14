<?php

namespace Drupal\ex81\Plugin\Block;

use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'Custom Block' block.
 *
 * @Block(
 *   id = "my_custom_block",
 *   admin_label = @Translation("My Custom Block")
 * )
 */
class CustomBlock extends \Drupal\Core\Block\BlockBase {

  /**
   * {@inheritdoc}
   * Функція, яка дозволяє створити конфіг, до якого можна буде звертатися
   */
  public function defaultConfiguration() {
    return ['some_config' => ''];
  }


  /**
   * {@inheritDoc}
   *  В build ми вказуємо зовнішній вигляд блока, його відображення на сторінці
   * $this->getConfiguration(); - повертає *конфіги* блока ( айді, лейбл,
   *і поля які ми туди записали, в нас це 'my_custom_block_settings')
   */
  public function build() {
    $config = $this->getConfiguration();
    if (!empty($config['my_custom_block_settings'])) {
      $text = $this->t('Hello @name in block!!!', ['@name' => $config['my_custom_block_settings']]);
      $text .= $this->configuration['some_config'];
    }
    else {
      $text = $this->t('Hello world in block!!');
    }
    return [
      '#markup' => $text,
    ];
  }

  /**
   * {@inheritdoc}
   * Покищо не розібрався, але в цілому виглядає так ніби це те саме що і
   * blockForm(). Тільки Конфіг
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['some_config'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Some config'),
      '#default_value' => $this->configuration['some_config'],
      '#description' => $this->t("Some text to show in block."),
      '#weight' => 50,
    ];
    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritDoc}
   * Форма, яку ми будемо бачити при створенні та при редагуванні блока.
   * Необхідний, для того що б додати щось до форми яку геренить build()
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();
    $form ['my_custom_block_settings'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => !empty($config['my_custom_block_settings']) ? $config['my_custom_block_settings'] : '',
    ];
    return $form;
  }


  /**
   * {@inheritDoc}
   */
  //  protected function blockAccess(AccountInterface $account) {
  //    return AccessResult::allowedIfHasPermission($account, 'access content');
  //  }
  //
  /**
   * {@inheritdoc}
   * Звичайна валідація
   */
  public function blockValidate($form, FormStateInterface $form_state) {
    $string = $form_state->getValue('my_custom_block_settings');

    if (!is_string($string)) {
      $form_state->setErrorByName('my_custom_block_settings', t('Needs to be a string'));
    }
  }

  /**
   * {@inheritDoc}
   * Кнопка сабміт, яка спрацьовує при створенні\редагуванні блока
   * НЕ конфіг форми
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('my_custom_block_settings', $form_state->getValue('my_custom_block_settings'));
    //По факту одне і те саме
    //    $this->configuration['my_custom_block_settings'] = $form_state->getValue('my_custom_block_settings');
  }

  /**
   * {@inheritDoc}
   * Кнопка сабміт, яка спрацьовує при створенні\редагуванні блока
   * конфіг форми
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['some_config'] = $form_state->getValue('some_config');
    parent::submitConfigurationForm($form, $form_state);
  }


}
