<?php

/**
 * Add custom media sizes to WP media options.
 *
 * @package     KaylaMoz
 * @subpackage  KaylaMoz/includes
 * @copyright   Copyright (c) 2014, Dave Mozdzanowski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Dave Mozdzanowski <me@davemoz.dev>
 */
class KaylaMoz_Add_Media_Sizes
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    add_action('after_setup_theme', array($this, 'kaylamoz_update_medium_large_image_options'));
  }

  function kaylamoz_update_medium_large_image_options() {
    update_option('medium_large_size_h', 768);
    update_option('medium_large_size_w', 768);
  }
}