<?php

/**
 * Custom Nav Walker with FontAwesome icon support for social media and cart items.
 * by Dave Mozdzanowski
 * This requires Font Awesome(!!enqueued with theme!!->TBD) and adds in the correct icon by detecting the title of the menu item.
 * 
 * You can use this by doing a custom wp_nav_menu query:
 * wp_nav_menu(array('theme_location' => 'social', 'menu_id' => 'social-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>', 'walker' => new GrandCentralMarket_Nav_Walker()));
 *
 * @package     KaylaMoz
 */

class KaylaMoz_Nav_Walker extends Walker_Nav_Menu
{

  private $prev_depth = 0;
  private $lvl_prev_index = [0, 0, 0, 0];
  private $lvl_index = 0;
  private $el_prev_index = [0, 0, 0, 0];
  private $el_index = 0;

  /**
   * Starts the list before the elements are added.
   *
   * Adds classes to the unordered list sub-menus.
   *
   * @param string $output Passed by reference. Used to append additional content.
   * @param int    $depth  Depth of menu item. Used for padding.
   * @param array  $args   An array of arguments. @see wp_nav_menu()
   */
  function start_lvl(&$output, $depth = 0, $args = array())
  {
    if ($this->prev_depth == $depth) {
      $this->lvl_index++;
      $this->lvl_prev_index[$depth] = $this->lvl_index;
    } elseif ($this->prev_depth - $depth == 1) {
      $this->lvl_index = $this->lvl_prev_index[$depth] + 1;
      $this->lvl_prev_index[$depth] = $this->lvl_index;
      $this->prev_depth = $depth;
    } elseif ($this->prev_depth - $depth == 2) {
      $this->lvl_index = $this->lvl_prev_index[$depth] + 1;
      $this->lvl_prev_index[$depth] = $this->lvl_index;
      $this->prev_depth = $depth;
    } elseif ($this->prev_depth < $depth) {
      $this->lvl_index = 1;
      $this->lvl_prev_index[$depth] = $this->lvl_index;
      $this->prev_depth = $depth;
    }

    // Depth-dependent classes.
    $indent = ($depth > 0 ? str_repeat("\t", $depth) : ''); // code indent
    $display_depth = ($depth + 2); // because it counts the first submenu as 0
    $classes = array(
      ($this->lvl_index % 2  ? 'menu-odd' : 'menu-even'),
      'menu-depth-' . $display_depth
    );
    $class_names = implode(' ', $classes);

    // Build HTML for output.
    $output .= "\n" . $indent . '<ul class="menu-index-' . $this->lvl_index . ' ' . $class_names . '">' . "\n";
  }

  /**
   * Start the element output.
   *
   * Adds main/sub-classes to the list items and links.
   *
   * @param string 	$output Passed by reference. Used to append additional content.
   * @param object 	$item   Menu item data object.
   * @param int    	$depth  Depth of menu item. Used for padding.
   * @param stdClass	$args   An object of arguments. @see wp_nav_menu()
   * @param int    	$id     Current item ID.
   */
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
  {
    if ($this->el_prev_index[$depth] == 1 && $this->prev_depth <= $depth) {
      $this->prev_depth = $depth;
    }
    if ($this->prev_depth == $depth) {
      $this->el_index++;
      $this->el_prev_index[$depth] = $this->el_index;
    } elseif ($this->prev_depth - $depth == 1) {
      $this->el_index = $this->el_prev_index[$depth] + 1;
      $this->el_prev_index[$depth] = $this->el_index;
      $this->prev_depth = $depth;
    } elseif ($this->prev_depth - $depth == 2) {
      $this->el_index = $this->el_prev_index[$depth] + 1;
      $this->el_prev_index[$depth] = $this->el_index;
      $this->prev_depth = $depth;
    } elseif ($this->prev_depth < $depth) {
      $this->el_index = 1;
      $this->el_prev_index[$depth] = $this->el_index;
    }

    $indent = ($depth) ? str_repeat("\t", $depth) : ''; // code indent

    // Depth-dependent classes.
    $display_depth = ($depth + 1); // depth count starts at 0
    $depth_classes = array(
      ($depth == 0 ? 'top-item' : ''),
      ($this->el_index % 2 ? 'item-odd' : 'item-even'),
      'item-depth-' . $display_depth
    );
    $depth_class_names = esc_attr(implode(' ', $depth_classes));

    $link_before = $args->link_before;
    // Check for item custom image set in Menu options
    $has_image = get_post_meta($item->ID, '_nav_item_image_id', true) && get_post_meta($item->ID, '_nav_item_image_id', true) != '';
    $has_image_class = '';
    if ($has_image) {
      $item_img_id = get_post_meta($item->ID, '_nav_item_image_id', true);
      $link_before = wp_get_attachment_image($item_img_id, 'large', false, array('class' => 'item-image'));
      $has_image_class = 'has-image';
    }

    // Passed <li> classes.
    $class_names = '';
    $classes = empty($item->classes) ? array() : (array)$item->classes;
    $class_names = esc_attr(implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item)));

    // Build HTML
    if (!$has_image && $display_depth == 2 && $this->el_index == 4) {
      $output .= '<div class="non-image-items-wrap">';
      $output .= $indent . '<li id="nav-item-' . $item->ID . '" class="item-index-' . $this->el_index . ' ' . $depth_class_names . ' ' . $class_names . '">';
    } else {
      $output .= $indent . '<li id="nav-item-' . $item->ID . '" class="item-index-' . $this->el_index . ' ' . $depth_class_names . ' ' . $class_names . '">';
    }

    // Link attributes
    $aClasses = $depth == 0 ? 'top-item-link' : 'item-link';
    $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) . '"' : '';
    $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target) . '"' : '';
    $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn) . '"' : '';
    $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($item->url) . '"' : '';
    $attributes .= ' class="' . $aClasses . '"';

    $item_before = '';

    //  Build HTML output and pass through the proper filter
    if (class_exists('WooCommerce')) {
      global $woocommerce;
      $cart_contents_count = $woocommerce->cart->cart_contents_count;
    }
    if (strpos($item->url, 'facebook') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-facebook-square"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'twitter') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-twitter"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'instagram') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-instagram"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'pinterest') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-pinterest-p"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'linkedin') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-linkedin-in"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'snapchat') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-snapchat-ghost"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'plus.google') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-google-plus-g"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'youtube') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-youtube"></i>',
        $args->link_after,
        $args->after
      );
    } elseif (strpos($item->url, 'vimeo') !== false) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fab fa-vimeo-v"></i>',
        $args->link_after,
        $args->after
      );
    } elseif ((stripos($item->title, 'cart') !== false) && (in_array('no-icon', (array)$item->classes) === false) && class_exists('WooCommerce')) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        $cart_contents_count == 0 ? '<i class="fas fa-shopping-cart"></i>' : '<i class="fas fa-shopping-cart"></i><span id="cart-count">' . $cart_contents_count . '</span>',
        $args->link_after,
        $args->after
      );
    } elseif ((stripos($item->title, 'account') !== false) && (in_array('no-icon', (array)$item->classes) === false) && class_exists('WooCommerce')) {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before,
        $attributes,
        $args->link_before,
        '<i class="fas fa-user"></i>',
        $args->link_after,
        $args->after
      );
    } else {
      $item_output = sprintf(
        '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
        $args->before = $item_before,
        $attributes,
        $link_before != '' ? $link_before : $args->link_before,
        apply_filters('the_title', $item->title, $item->ID),
        $args->link_after,
        $args->after
      );
    }
    $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}
