<?php

namespace Drupal\customtimezone;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Service class created for time details.
 */
class GetTimeDetailService {
  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs an object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory->get('customtimezone.settings');
  }

  /**
   * Gives times details on the basis to timezone.
   */
  public function getTimeDetails() {
    $timezone = $this->configFactory->get('timezone');
    $date_time = new DrupalDateTime('now', $timezone);
    $formated_date = $date_time->format('jS M Y - h:i A');
    $only_time = $date_time->format('h:i a');
    $only_date = $date_time->format('D, d F Y');
    $country_city = explode("/", $timezone);
    $country = $country_city['0'];
    $city = $country_city['1'];

    $details = [
      'formated_date' => $formated_date,
      'only_time' => $only_time,
      'only_date' => $only_date,
      'country' => $country,
      'city' => $city,
      'timezone' => $timezone,
    ];

    return ($details);
  }

}
