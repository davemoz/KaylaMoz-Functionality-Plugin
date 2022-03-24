<?php

/**
 * Register Custom Taxonomies
 *
 * @package     KaylaMoz
 * @subpackage  KaylaMoz/includes
 * @copyright   Copyright (c) 2014, Dave Mozdzanowski
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */
class KaylaMoz_Register_Taxonomies
{
  /**
   * Initialize the class
   */
  public function __construct()
  {
    add_action('init', array($this, 'register_project_type_taxonomy'));
    add_action('init', array($this, 'register_project_tag_taxonomy'));
  }
  /**
   * Register Project Type Taxonomy
   *
   * @since  1.0.0
   * @access public
   * @return void
   */
  public function register_project_type_taxonomy()
  {
    $labels = array(
      'name'                       => _x('Project Types', 'Taxonomy General Name', 'kaylamoz'),
      'singular_name'              => _x('Project Type', 'Taxonomy Singular Name', 'kaylamoz'),
      'menu_name'                  => __('Project Types', 'kaylamoz'),
      'all_items'                  => __('Project Types', 'kaylamoz'),
      'parent_item'                => __('Parent Project Type', 'kaylamoz'),
      'parent_item_colon'          => __('Parent Project Type:', 'kaylamoz'),
      'new_item_name'              => __('New Project Type Name', 'kaylamoz'),
      'add_new_item'               => __('Add New Project Type', 'kaylamoz'),
      'edit_item'                  => __('Edit Project Type', 'kaylamoz'),
      'update_item'                => __('Update Project Type', 'kaylamoz'),
      'view_item'                  => __('View Project Type', 'kaylamoz'),
      'separate_items_with_commas' => __('Separate project types with commas', 'kaylamoz'),
      'add_or_remove_items'        => __('Add or remove project types', 'kaylamoz'),
      'choose_from_most_used'      => __('Choose from the most used', 'kaylamoz'),
      'popular_items'              => __('Popular Project Types', 'kaylamoz'),
      'search_items'               => __('Search Project Types', 'kaylamoz'),
      'not_found'                  => __('Not Found', 'kaylamoz'),
      'no_terms'                   => __('No project types', 'kaylamoz'),
      'items_list'                 => __('Project Types list', 'kaylamoz'),
      'items_list_navigation'      => __('Project Types list navigation', 'kaylamoz'),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => true,
      'show_tagcloud'              => true,
      'show_in_rest'               => true,
    );
    register_taxonomy('project-type', array('portfolio'), $args);
  }

  /**
   * Register Project Tag Taxonomy
   *
   * @since  1.0.0
   * @access public
   * @return void
   */
  public function register_project_tag_taxonomy()
  {
    $labels = array(
      'name'                       => _x('Project Tags', 'Taxonomy General Name', 'kaylamoz'),
      'singular_name'              => _x('Project Tag', 'Taxonomy Singular Name', 'kaylamoz'),
      'menu_name'                  => __('Project Tags', 'kaylamoz'),
      'all_items'                  => __('Project Tags', 'kaylamoz'),
      'parent_item'                => __('Parent Project Tag', 'kaylamoz'),
      'parent_item_colon'          => __('Parent Project Tag:', 'kaylamoz'),
      'new_item_name'              => __('New Project Tag Name', 'kaylamoz'),
      'add_new_item'               => __('Add New Project Tag', 'kaylamoz'),
      'edit_item'                  => __('Edit Project Tag', 'kaylamoz'),
      'update_item'                => __('Update Project Tag', 'kaylamoz'),
      'view_item'                  => __('View Project Tag', 'kaylamoz'),
      'separate_items_with_commas' => __('Separate project tags with commas', 'kaylamoz'),
      'add_or_remove_items'        => __('Add or remove project tags', 'kaylamoz'),
      'choose_from_most_used'      => __('Choose from the most used', 'kaylamoz'),
      'popular_items'              => __('Popular Project Tags', 'kaylamoz'),
      'search_items'               => __('Search Project Tags', 'kaylamoz'),
      'not_found'                  => __('Not Found', 'kaylamoz'),
      'no_terms'                   => __('No project tags', 'kaylamoz'),
      'items_list'                 => __('Project Tags list', 'kaylamoz'),
      'items_list_navigation'      => __('Project Tags list navigation', 'kaylamoz'),
    );
    $args = array(
      'labels'                     => $labels,
      'hierarchical'               => false,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => true,
      'show_tagcloud'              => true,
      'show_in_rest'               => true,
    );
    register_taxonomy('project-tag', array('portfolio'), $args);
  }
}
