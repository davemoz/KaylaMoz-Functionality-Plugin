<?php

/**
 * Remove post author URL
 *
 * @package     KaylaMoz
 * @subpackage  KaylaMoz/includes
 * @copyright   Copyright (c) 2014, Dave Mozdzanowski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Dave Mozdzanowski <me@davemoz.dev>
 */
class KaylaMoz_Remove_Post_Author_Url
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    add_filter('get_comment_author_link', array($this, 'remove_post_author_weburl'));
  }
  /**
   * Remove post author URL
   *
   * @since  1.0.0
   * @access public
   * @return string remove the author's url from comment post
   */
  function remove_post_author_weburl($return)
  {
    global $comment, $post;
    if (!is_admin()) {
      $author = get_comment_author(get_comment_ID());
      return $author;
    } else {
      return $return;
    }
  }
}
