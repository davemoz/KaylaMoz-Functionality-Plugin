<?php

/**
 * Register custom post types
 *
 * @package     KaylaMoz
 */
class KaylaMoz_Register_Post_Types
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    add_action('init', array($this, 'register_portfolio_post_type'));
    // Set thumbnail size
    add_image_size('kaylamoz_admin-featured-image', 60, 60, false);
    add_action('admin_head', array($this, 'kaylamoz_add_admin_column_styles'));
    add_filter('manage_portfolio_posts_columns', array($this, 'kaylamoz_add_thumbnail_column'), 2);
    add_action('manage_portfolio_posts_custom_column', array($this, 'kaylamoz_add_featured_image_to_column'), 5, 2);
    add_filter('manage_portfolio_posts_columns', array($this, 'kaylamoz_move_column_to_first_position'));
  }
  /**
   * Register Portfolio Post Type
   *
   * @since  1.0.0
   * @access public
   * @return void
   */
  public function register_portfolio_post_type()
  {
    $labels = array(
      'name'                  => _x('Projects', 'Post Type General Name', 'kaylamoz'),
      'singular_name'         => _x('Project', 'Post Type Singular Name', 'kaylamoz'),
      'menu_name'             => __('Portfolio', 'kaylamoz'),
      'name_admin_bar'        => __('Project', 'kaylamoz'),
      'archives'              => __('Project Archives', 'kaylamoz'),
      'attributes'            => __('Project Attributes', 'kaylamoz'),
      'parent_item_colon'     => __('Parent Project:', 'kaylamoz'),
      'all_items'             => __('All Projects', 'kaylamoz'),
      'add_new_item'          => __('Add New Project', 'kaylamoz'),
      'add_new'               => __('Add New', 'kaylamoz'),
      'new_item'              => __('New Project', 'kaylamoz'),
      'edit_item'             => __('Edit Project', 'kaylamoz'),
      'update_item'           => __('Update Project', 'kaylamoz'),
      'view_item'             => __('View Project', 'kaylamoz'),
      'view_items'            => __('View Projects', 'kaylamoz'),
      'search_items'          => __('Search Project', 'kaylamoz'),
      'not_found'             => __('Not found', 'kaylamoz'),
      'not_found_in_trash'    => __('Not found in Trash', 'kaylamoz'),
      'featured_image'        => __('Featured Image', 'kaylamoz'),
      'set_featured_image'    => __('Set featured image', 'kaylamoz'),
      'remove_featured_image' => __('Remove featured image', 'kaylamoz'),
      'use_featured_image'    => __('Use as featured image', 'kaylamoz'),
      'insert_into_item'      => __('Insert into project', 'kaylamoz'),
      'uploaded_to_this_item' => __('Uploaded to this project', 'kaylamoz'),
      'items_list'            => __('Projects list', 'kaylamoz'),
      'items_list_navigation' => __('Projects list navigation', 'kaylamoz'),
      'filter_items_list'     => __('Filter projects list', 'kaylamoz'),
    );
    $args = array(
      'label'                 => __('Project', 'kaylamoz'),
      'description'           => __('Post Type Description', 'kaylamoz'),
      'labels'                => $labels,
      'supports'              => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields'),
      'taxonomies'            => array('portfolio-type', 'portfolio-tag'),
      'hierarchical'          => false,
      'public'                => true,
      'show_ui'               => true,
      'show_in_menu'          => true,
      'menu_position'         => 20,
      'menu_icon'             => 'dashicons-portfolio',
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true,
      'can_export'            => true,
      'has_archive'           => true,
      'exclude_from_search'   => false,
      'publicly_queryable'    => true,
      'capability_type'       => 'page',
      'show_in_rest'          => true,
    );
    register_post_type('portfolio', $args);
  }

  /**
   * Add featured image column to WP admin panel
   */
  function kaylamoz_add_thumbnail_column($defaults)
  {
    $defaults['kaylamoz_portfolio_thumb'] = __('Image');
    return $defaults;
  }

  /**
   * Add the featured image to the column
   */
  function kaylamoz_add_featured_image_to_column($column_name, $id)
  {
    if ($column_name === 'kaylamoz_portfolio_thumb') {
      if (function_exists('the_post_thumbnail')) {
        echo the_post_thumbnail('kaylamoz_admin-featured-image');
      }
    }
  }

  /**
   * Move the column to the first position
   */
  function kaylamoz_move_column_to_first_position($columns)
  {
    $n_columns = array();
    $move = 'kaylamoz_portfolio_thumb'; // which column to move
    $before = 'title'; // move before this column

    foreach ($columns as $key => $value) {
      if ($key == $before) {
        $n_columns[$move] = $move;
      }
      $n_columns[$key] = $value;
    }
    return $n_columns;
  }

  /**
   * Adjust width of column
   */
  function kaylamoz_add_admin_column_styles()
  {
    echo '<style>.column-kaylamoz_portfolio_thumb {width: 60px;}</style>';
  }
}
