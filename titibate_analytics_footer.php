<?php
/**
 * @link              https://github.com/titibate/titibate_analytics_footer
 * @since             0.3.1
 * @package           titibate_analytics_footer
 *
 * @wordpress-plugin
 * Plugin Name: Analytics in the footer - Titibate
 * Description: Add analytics tracking code in the footer page
 * Version: 0.3.1
 * Author: Titibate
 * Author URI: https://titibate.com
 * Text Domain: titibate_analytics_footer
 * License: GPL3
 * License URI: https://www.gnu.org/licenses/gpl.html
 * GitHub Plugin URI: https://github.com/titibate/titibate_analytics_footer
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Class TTBFooter
 *
 * This class creates the option page and add the script
 */
class TTBFooter
{
  /**
   * TTBFooter constructor.
   *
   * The main plugin actions registered for WordPress
   */
  public function __construct()
  {
    add_action( 'admin_init', array( $this, 'addOptionCodeAnalytics' ) );
    add_action( 'wp_footer', array( $this, 'printCodeAnalytics' ) );
  }

  /**
   * Add option
   */
  public function addOptionCodeAnalytics()
  {
    /* Register Settings */
    register_setting(
        'general',                                      // Options group
        'code_ttb_analytics',                           // Option name/database
        array($this, 'code_ttb_analytics_sanitize')     // sanitize callback function
    );
 
    /* Create settings section */
    add_settings_section(
        'titibate_analytics_footer-setting',                      // Section ID
        'Analytics in the footer',                                // Section title
        array($this, 'titibate_analytics_footer_description'),    // Section callback function
        'general'                                                 // Settings page slug
    );
 
    /* Create settings field */
    add_settings_field(
        'titibate_analytics_footer-field-id',                       // Field ID
        'Analytics code',                                           // Field title 
        array($this, 'titibate_analytics_footer_field_callback'),   // Field callback function
        'general',                                                  // Settings page slug
        'titibate_analytics_footer-setting'                         // Section ID
    );
  }

  /**
   * Sanitize Callback Function
   */
  public function code_ttb_analytics_sanitize( $input )
  {
    return isset( $input ) ? $input : '';
  }
   
  /**
   * Setting Section Description
   */
  public function titibate_analytics_footer_description()
  {
    echo wpautop( "Add analytics tracking code in the footer page. This value can be overwritten with constant WP_TTB_ANALYTICS in the wp_config.php file." );
  }
   
  /**
   * Settings Field Callback
   */
  public function titibate_analytics_footer_field_callback()
  {
    ?>
    <label for="titibate_analytics_footer-field-id">
      <input id="titibate_analytics_footer-field-id" type="text" name="code_ttb_analytics" value="<?php echo get_option( 'code_ttb_analytics' ); ?>" placeholder="UA-XXXXXXX-X">
    </label>
    <?php
  }

  /**
   * Adds script to footer
   */
  public function printCodeAnalytics()
  {
    // Get option
    $code_ttb_analytics = get_option( 'code_ttb_analytics' );
    // If constant defined, overwrite
    if (defined('WP_TTB_ANALYTICS')) {
      $code_ttb_analytics = WP_TTB_ANALYTICS;
    }
    // If not empty
    if (!empty($code_ttb_analytics)) {
      echo '<!-- Global site tag (gtag.js) - Google Analytics -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=' . $code_ttb_analytics . '"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag("js", new Date());
        gtag("config", "' . $code_ttb_analytics . '");
      </script>';
    }
  }

}
 
/*
 * Starts our plugin class, easy!
 */
new TTBFooter();
