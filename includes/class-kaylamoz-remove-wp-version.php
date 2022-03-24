<?php

/**
 * Remove WP version number throughout site
 * 
 * @package     KaylaMoz
 * @subpackage  KaylaMoz/includes
 * @copyright   Copyright (c) 2014, Dave Mozdzanowski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Dave Mozdzanowski <me@davemoz.dev>
 */
class KaylaMoz_Remove_WP_Version
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    add_filter('the_generator', array($this, 'kaylamoz_remove_wp_version'));
  }
  /**
   * Remove WP generated content from the head
   *
   * @since  1.0.0
   * @access private
   * @return void
   */
  public function kaylamoz_remove_wp_version()
  {
    return '';
  }
}
