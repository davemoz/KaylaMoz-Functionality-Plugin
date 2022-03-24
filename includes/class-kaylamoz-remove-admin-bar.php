<?php

/**
 * Remove Admin bar for lodge members
 * 
 * @package     KaylaMoz
 * @subpackage  KaylaMoz/includes
 * @copyright   Copyright (c) 2014, Dave Mozdzanowski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Dave Mozdzanowski <me@davemoz.dev>
 */
class KaylaMoz_Remove_Admin_Bar
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    add_action('set_current_user', array($this, 'remove_admin_bar'));
  }
  /**
   * Remove admin bar
   *
   * @since  1.0.0
   * @access public
   * @return void
   */
  public function remove_admin_bar()
  {
    if (!current_user_can('edit_posts')) {
      show_admin_bar(false);
    }
  }
}
