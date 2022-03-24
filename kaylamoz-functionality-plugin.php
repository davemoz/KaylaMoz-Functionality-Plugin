<?php

/**
 * 
 * The file responsible for starting the KaylaMoz Functionality plugin
 * 
 * This plugin adds a bunch of functionality to a WordPress install.
 * This particular file is responsible for including the necessary dependencies and starting the plugin.
 * 
 * @package     KaylaMoz
 *
 * @wordpress-plugin
 * Plugin Name:       KaylaMoz Functionality
 * Plugin URI:        https://github.com/davemoz/WP-functionality-plugin
 * Description:       Custom WordPress functionality plugin.
 * Version:           1.0.0
 * Author:            Dave Mozdzanowski
 * Author URI:        http://davemoz.dev
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:				kaylamoz-functionality-locale
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

// Defines the encompassing main class of the plugin
if (!class_exists('KaylaMoz_Functionality')) {
  class KaylaMoz_Functionality
  {

    /**
     * A reference to the admin loader class that coordinates the hooks and callbacks for the admin portion of the plugin
     * 
     * @access	protected
     * @var			KaylaMoz_Admin_Loader $adminloader Manages hooks between the WordPress admin hooks and the callback functions.
     */
    protected $adminloader;

    /**
     * Instance of the class
     *
     * @since 1.0.0
     * @var Instance of KaylaMoz_Functionality class
     */
    private static $instance;

    /**
     * Instance of the plugin
     *
     * @since 1.0.0
     * @static
     * @staticvar array $instance
     * @return Instance
     */
    public static function instance()
    {
      if (!isset(self::$instance) && !(self::$instance instanceof KaylaMoz_Functionality)) {
        self::$instance = new KaylaMoz_Functionality;
        self::$instance->define_constants();
        add_action('plugins_loaded', array(self::$instance, 'load_textdomain'));
        self::$instance->includes();
        self::$instance->define_admin_hooks();
        self::$instance->init = new KaylaMoz_Init();
      }
      return self::$instance;
    }

    /**
     * Define the plugin constants
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function define_constants()
    {
      // Plugin Version
      if (!defined('KAYLAMOZ_VERSION')) {
        define('KAYLAMOZ_VERSION', '1.0.0');
      }
      // Prefix
      if (!defined('KAYLAMOZ_PREFIX')) {
        define('KAYLAMOZ_PREFIX', 'kaylamoz_');
      }
      // Textdomain
      if (!defined('KAYLAMOZ_TEXTDOMAIN')) {
        define('KAYLAMOZ_TEXTDOMAIN', 'kaylamoz');
      }
      // Plugin Options
      if (!defined('KAYLAMOZ_OPTIONS')) {
        define('KAYLAMOZ_OPTIONS', 'kaylamoz-options');
      }
      // Plugin Directory
      if (!defined('KAYLAMOZ_PLUGIN_DIR')) {
        define('KAYLAMOZ_PLUGIN_DIR', plugin_dir_path(__FILE__));
      }
      // Plugin URL
      if (!defined('KAYLAMOZ_PLUGIN_URL')) {
        define('KAYLAMOZ_PLUGIN_URL', plugin_dir_url(__FILE__));
      }
      // Plugin Root File
      if (!defined('KAYLAMOZ_PLUGIN_FILE')) {
        define('KAYLAMOZ_PLUGIN_FILE', __FILE__);
      }
    }

    /**
     * Load the required files
     *
     * @since  1.0.0
     * @access private
     * @return void
     */
    private function includes()
    {
      $includes_path = plugin_dir_path(__FILE__) . 'includes/';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/admin/class-kaylamoz-admin.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/admin/class-kaylamoz-admin-loader.php';
      $this->adminloader = new KaylaMoz_Admin_Loader();

      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-add-media-sizes.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-custom-nav-walker.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-register-post-types.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-register-taxonomies.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-remove-admin-bar.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-clean-up-head.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-insert-figure.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-long-url-spam.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-remove-jetpack-bar.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-remove-unwanted-assets.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-remove-post-author-url.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-custom-pagi.php';
      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-remove-wp-version.php';


      require_once KAYLAMOZ_PLUGIN_DIR . 'includes/class-kaylamoz-init.php';
    }

    /**
     * Defines the hooks and callback functions that are used for setting up the plugin's stylesheets
     * 
     * This function relies on the KaylaMoz_Admin class and the KaylaMoz_Admin_Loader class property.
     * 
     * @access private
     */
    private function define_admin_hooks()
    {

      $admin = new KaylaMoz_Admin();
      $this->adminloader->add_action('admin_enqueue_scripts', $admin, 'enqueue_styles');
    }

    /**
     * Load the plugin text domain for translation.
     *
     * @since  1.0.0
     * @access public
     */
    public function load_textdomain()
    {
      $kaylamoz_lang_dir = dirname(plugin_basename(KAYLAMOZ_PLUGIN_FILE)) . '/languages/';
      $kaylamoz_lang_dir = apply_filters('KaylaMoz_lang_dir', $kaylamoz_lang_dir);

      $locale = apply_filters('plugin_locale',  get_locale(), KAYLAMOZ_TEXTDOMAIN);
      $mofile = sprintf('%1$s-%2$s.mo', KAYLAMOZ_TEXTDOMAIN, $locale);

      $mofile_local  = $kaylamoz_lang_dir . $mofile;
      $mofile_global = WP_LANG_DIR . '/edd/' . $mofile;

      if (file_exists($mofile_local)) {
        load_textdomain(KAYLAMOZ_TEXTDOMAIN, $mofile_local);
      } else {
        load_plugin_textdomain(KAYLAMOZ_TEXTDOMAIN, false, $kaylamoz_lang_dir);
      }
    }

    /**
     * Throw error on object clone
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __clone()
    {
      _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', KAYLAMOZ_TEXTDOMAIN), '1.6');
    }

    /**
     * Disable unserializing of the class
     *
     * @since  1.0.0
     * @access public
     * @return void
     */
    public function __wakeup()
    {
      _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', KAYLAMOZ_TEXTDOMAIN), '1.6');
    }
  }
}
/**
 * Return the instance
 *
 * @since 1.0.0
 * @return object The Safety Links instance
 */
function KaylaMoz_Functionality_Run()
{
  return KaylaMoz_Functionality::instance();
}
KaylaMoz_Functionality_Run();
