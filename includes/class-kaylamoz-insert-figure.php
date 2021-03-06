<?php

/**
 * Insert the figure tag to attched images in posts
 *
 * @package     KaylaMoz
 * @subpackage  KaylaMoz/includes
 * @copyright   Copyright (c) 2014, Dave Mozdzanowski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 * @author      Dave Mozdzanowski <me@davemoz.dev>
 */
class KaylaMoz_Insert_Figure
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    add_filter('image_send_to_editor', array($this, 'insert_figure'), 10, 9);
  }

  /**
   * Insert the figure tag to attched images in posts
   *
   * @since  1.0.0
   * @access public
   * @return string return custom output for inserted images in posts
   */
  public function insert_figure($html, $id, $caption, $title, $align, $url, $size, $alt)
  {
    $img_src = wp_get_attachment_image_src($id, $size);
    // remove protocol
    $url = str_replace(array('http://', 'https://'), '//', $url);

    if (!empty($url)) {
      $html =  "<a href='$url' class='img-link'>";
      $html .= "<figure id='post-$id' class='align-$align media-$id size-$size'>";
      $html .= "<img src='$img_src[0]' title='$title' alt='$alt' />";
      if ($caption) {
        $html .= "<figcaption>$caption</figcaption>";
      }
      $html .= "</figure></a>";
    }

    return $html;
  }
}
