<?php

namespace Drupal\customtimezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\customtimezone\GetTimeDetailService;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block with date time details of selected timezone.
 *
 * @Block(
 *   id = "timezone_details_block",
 *   admin_label = @Translation("Timezone details block")
 * )
 */
class TimezoneBlock extends Blockbase implements ContainerFactoryPluginInterface {
  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;
  /**
   * Drupal\customtimezone\GetTimeDetailService definition.
   *
   * @var \Drupal\customtimezone\GetTimeDetailService
   */
  protected $getTimeDetailService;

  /**
   * Constructs a new ControllerBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\customtimezone\GetTimeDetailService $get_time_detail_service
   *   Time detail servive information.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    ConfigFactoryInterface $config_factory,
    GetTimeDetailService $get_time_detail_service) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->getTimeDetailService = $get_time_detail_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
        $configuration,
        $plugin_id,
        $plugin_definition,
        $container->get('config.factory'),
        $container->get('customtimezone.cstimezone')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('customtimezone.settings');

    return [
      '#theme' => 'cstimezone',
      '#cstime' => $this->getTimeDetailService->getTimeDetails(),
      '#cache' => [
        'tags' => $config->getCacheTags(),
      ],

    ];
  }

}
