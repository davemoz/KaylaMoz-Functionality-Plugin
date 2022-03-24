<?php

/**
 * Main Init Class
 *
 * @package     KaylaMoz
 * @subpackage  KaylaMoz-functionality/includes
 * @copyright   Copyright (c) 2014, Dave Mozdzanowski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Dave Mozdzanowski <me@davemoz.dev>
 */
class KaylaMoz_Init
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    $add_admin_stuff          = new KaylaMoz_Admin();
    $add_media_sizes          = new KaylaMoz_Add_Media_Sizes();
    $register_post_types     = new KaylaMoz_Register_Post_Types();
    $register_taxonomies     = new KaylaMoz_Register_Taxonomies();
    $remove_admin_bar        = new KaylaMoz_Remove_Admin_Bar();
    $clean_up_head         = new KaylaMoz_Clean_Up_Head();
    $insert_figure         = new KaylaMoz_Insert_Figure();
    $long_url_spam         = new KaylaMoz_Long_URL_Spam();
    $remove_jetpack_bar      = new KaylaMoz_Remove_Jetpack_Bar();
    $remove_assets       = new KaylaMoz_Remove_Unwanted_Assets();
    $remove_post_author_url  = new KaylaMoz_Remove_Post_Author_Url();
    $remove_wp_version      = new KaylaMoz_Remove_WP_Version();
  }
}
