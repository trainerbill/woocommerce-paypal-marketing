<?php
/**
 * Plugin Name: WooCommerce PayPal Marketing Solutions
 * Plugin URI: https://github.com/trainerbill/woocommerce-paypal-marketing
 * Description: PayPal Marketing Solutions
 * Version: 1.0.0
 * Author: Andrew Throener
 * Author URI: https://github.com/trainerbill
 * Copyright: © 2017 WooCommerce / PayPal.
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: woocommerce-paypal-marketing
 * Domain Path: /languages
 */
/**
 * Copyright (c) 2017 PayPal, Inc.
 *
 * The name of the PayPal may not be used to endorse or promote products derived from this
 * software without specific prior written permission. THIS SOFTWARE IS PROVIDED ``AS IS'' AND
 * WITHOUT ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, WITHOUT LIMITATION, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_VERSION', '1.0.0' );
define( 'WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME', 'paypal_marketing_solutions' );

register_activation_hook( __FILE__, function() {
    // If you want to do anything when the plugin is first activated, do it here.
  });
  
  add_action( 'plugins_loaded', function() {
    class PayPalMarketingSolutionsPlugin extends WC_Payment_Gateway {
      public function __construct() {
        // Obviously, do whatever setup you need to here
        $this->id = WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME;
        $this->has_fields = false;
  
        // __() is used for doing multi-language (internationalized) strings.
        // The first parameter is the string to be internationalized; the second
        // parameter is the scope.  The scope only needs to be unique to this
        // plugin.
  
        // These two control what shows up in the WooCommerce payment methods page.
        $this->method_title = __( 'PayPal Marketing Solutions', WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME );
        $this->method_description = __( 'With more time to pay with PayPal Credit, your shoppers are more likely to complete their purchases and spend more. In addition, you will get free business insights into your customers&#39; shopping habits; like how often they shop, how much they spend, and how they interact with your website to help you make smarter sales and marketing decisions.', WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME );
  
        $this->enabled = 'no'; // Unless you want this to show up as an option on
                               // the checkout page

        $this->init_form_fields();
        // Load the settings.
        $this->init_settings();
  
        // This tells WooCommerce to call process_admin_options() whenever the
        // user clicks the "save settings" button on the admin page.
        add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( &$this, 'process_admin_options' ) );
      }
  
      public function admin_options() {
        // Got anything you want to render on the admin page?
        // Do it here.
        ?>
        <h2>PayPal Marketing Solutions</h2>
        <div id="muse-container">
            <div class="muse-left-container">
                <div class="muse-description">
                    <p>With more time to pay with PayPal Credit, your shoppers are more likely to complete their purchases and spend more. In addition, you will get free business insights into your customers&#39; shopping habits; like how often they shop, how much they spend, and how they interact with your website to help you make smarter sales and marketing decisions.</p>
                </div>
                <div class="paypalTOC">
                    <p>By clicking Enable below, you acknowledge you have the right to use the PayPal Insights tool and to collect information from shoppers on your site. <a href="https://www.paypal.com/tagmanager/terms">See terms and conditions</a></p>
                    <p>By enabling promotions, you acknowledge that you have agreed to, and accepted the terms of, the PayPal User Agreement, including the <a href="https://www.paypal.com/webapps/mpp/ua/useragreement-full#advertising-program">terms and conditions</a> thereof applicable to the PayPal Advertising Program.</p>
                </div>
                <div id="paypalInsightsLink">You can view insights about your visitors. <a target="_blank" href="https://business.paypal.com/merchantdata/reportHome">View Shopper Insights</a></div>
            </div>
            <div class="muse-right-container">
                <div>
                    <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/img/muse1.png"/>
                    <div>Merchants like you have increased their average order value (AOV) by upto 68%*</div>
                </div>
                <div>
                    <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/img/muse2.png"/>
                    <div>Join 20,000 merchants who are promoting financing options on their site to boost sales</div>
                </div>
                <div>
                    <img src="<?php echo plugin_dir_url( __FILE__ ) ?>assets/img/muse3.png"/>
                    <div>Get insights about your visitors and how they shop on your site</div>
                </div>
            </div>
        </div>
        <table class="form-table">
        <?php $this->generate_settings_html();?>
        </table>
        <div id="paypal-muse-button-container"></div>
        <script type="text/javascript">
          jQuery( function( $ ) {
            $("#woocommerce_paypal_marketing_solutions_ppms_cid_production, #woocommerce_paypal_marketing_solutions_ppms_cid_sandbox").prop('readonly', true).closest('tr').hide();
            $("#woocommerce_paypal_marketing_solutions_ppms_environment").change(function () {
                if ($("#woocommerce_paypal_marketing_solutions_ppms_enabled").is(":checked")) {
                    $("#woocommerce_paypal_marketing_solutions_ppms_enabled").trigger("click");
                }
            });

            $("#woocommerce_paypal_marketing_solutions_ppms_enabled").change(function () {
                if ($( this ).is( ':checked' )) {
                    MUSEButton('paypal-muse-button-container', {
                        cid: getContainerId(),
                        onContainerCreate: setContainerId,
                        partner_name: 'woocommerce',
                        env: $('#woocommerce_paypal_marketing_solutions_ppms_environment').val()
                      });
                } else {
                    $("#paypal-muse-button-container").empty();
                    $(".woocommerce-save-button").prop("disabled", false);
                }
            });

            function getContainerId() {
                return $('#woocommerce_paypal_marketing_solutions_ppms_environment').val() === 'sandbox' ? 
                $('#woocommerce_paypal_marketing_solutions_ppms_cid_sandbox').val() : 
                $('#woocommerce_paypal_marketing_solutions_ppms_cid_production').val()
            }

            function setContainerId(id) {
                return $('#woocommerce_paypal_marketing_solutions_ppms_environment').val() === 'sandbox' ? 
                $('#woocommerce_paypal_marketing_solutions_ppms_cid_sandbox').val(id) : 
                $('#woocommerce_paypal_marketing_solutions_ppms_cid_production').val(id)
            }
            
          });
        </script>
        <?php
      }
  
      public function process_admin_options() {
        // This function is called when the user clicks the "save settings"
        // button on the admin page.  Any validation, saving settings, etc.,
        // should be done here.  Note that admin_options() will be called at some
        // point after this function is called.
        if ($_POST['woocommerce_paypal_marketing_solutions_ppms_enabled']) {
            if ($_POST['woocommerce_paypal_marketing_solutions_ppms_environment'] === "sandbox" && ! $_POST['woocommerce_paypal_marketing_solutions_ppms_cid_sandbox']) {
                WC_Admin_Settings::add_error( __( 'Error: You must click the activate button!' ) );
                return;
            }

            if ($_POST['woocommerce_paypal_marketing_solutions_ppms_environment'] === "production" && ! $_POST['woocommerce_paypal_marketing_solutions_ppms_cid_production']) {
                WC_Admin_Settings::add_error( __( 'Error: You must click the activate button!' ) );
                return;
            }
            
        }
        
        update_option('ppms_environment', $_POST['woocommerce_paypal_marketing_solutions_ppms_environment']);
        update_option('ppms_cid_sandbox', $_POST['woocommerce_paypal_marketing_solutions_ppms_cid_sandbox']);
        update_option('ppms_cid_production', $_POST['woocommerce_paypal_marketing_solutions_ppms_cid_production']);
        update_option('ppms_enabled', $_POST['woocommerce_paypal_marketing_solutions_ppms_enabled']);
      }

      public function init_form_fields() {
        $this->form_fields = array(
            'ppms_environment' => array(
                'title'       => __( 'Environment' ),
                'type'        => 'select',
                'label'       => true,
                'default'     => get_option("ppms_environment"),
                'options'     => array(
                    'production'    => __( 'Production' ),
                    'sandbox' => __( 'Sandbox' ),
                ),
            ),
            'ppms_enabled' => array(
                'title'       => __( 'Enable', WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME ),
                'type'        => 'checkbox',
                'label'       => 'Enable',
                'default'     => get_option("ppms_enabled") == "1" ? 'yes' : 'no',
            ),
            'ppms_cid_sandbox' => array(
                'title'       => __( 'Sandbox Offers Container ID', WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME ),
                'type'        => 'text',
                'label'       => false,
                'default'     => get_option("ppms_cid_sandbox"),
                'desc_tip'    => true,
                'description' => __( 'You should not see this!' ),
            ),
            'ppms_cid_production' => array(
                'title'       => __( 'Production Offers Container ID', WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME ),
                'type'        => 'text',
                'label'       => false,
                'default'     => get_option("ppms_cid_production"),
                'desc_tip'    => true,
                'description' => __( 'You should not see this!' ),
            ),
        );
      }
    }
  });
  
  add_action( 'wp_enqueue_scripts', function() {
    // If you need the client to load up any CSS/JS files, do it here.
    // Note that this only controls what's rendered on the front-end -- it doesn't
    // affect what's loaded up in the admin panel.
  
    // Example of how to tell WP to load up a CSS file:
    // wp_register_style( 'woo_pp_css', plugins_url( 'content/css/paypal.css', __FILE__ ) );
    // wp_enqueue_style( 'woo_pp_css' );
  
    // Reference pages:
    // wp_register_style: https://developer.wordpress.org/reference/functions/wp_register_style/
    // wp_enqueue_style: https://developer.wordpress.org/reference/functions/wp_enqueue_style/
  
    // Example of how to tell WP to load up a JS file:
    // wp_enqueue_script( 'woo-pp-checkout-js', plugins_url( 'content/js/checkout.js', __FILE__ ), array( 'jquery' ), false, true );
  
    // Reference pages:
    // wp_enqueue_script: https://developer.wordpress.org/reference/functions/wp_enqueue_script/
    if (get_option("ppms_enabled") == "1") {
        wp_enqueue_script('paypal-merchant-offers-js', plugin_dir_url( __FILE__ ) . 'assets/js/wc-gateway-ppec-frontend-offers.js');
        wp_add_inline_script('paypal-merchant-offers-js', ";(function(a,t,o,m,s){a[m]=a[m]||[];a[m].push({t:new Date().getTime(),event:'snippetRun'});var f=t.getElementsByTagName(o)[0],e=t.createElement(o),d=m!=='paypalDDL'?'&m='+m:'';e.async=!0;e.src='https://www.paypal.com/tagmanager/pptm.js?id='+s+d;f.parentNode.insertBefore(e,f);})(window,document,'script','paypalDDL','".( get_option("ppms_environment") === "production" ? get_option("ppms_cid_production")  : get_option("ppms_cid_sandbox"))."');");
    }
  
  });
  
  add_action( 'admin_enqueue_scripts', function() {
    // If you need the client to load up any CSS/JS files for the pages in the
    // admin panel, do it here.  Note that this function only controls what's
    // rendered in the admin panel.
    wp_enqueue_script( 'paypal-muse-js', 'https://www.paypalobjects.com/muse/partners/muse-button-bundle.js', array(), null, true );
    wp_enqueue_script( 'paypal-muse-js-local', plugin_dir_url( __FILE__ ) . 'assets/js/wc-gateway-ppms-button.js', array(), null, true );
    wp_enqueue_style( 'wc-gateway-ppec-admin-settings', plugin_dir_url( __FILE__ ) . 'assets/css/wc-gateway-ppec-admin-settings.css' );
  });
  
  add_filter( 'woocommerce_payment_gateways', function($methods) {
    $methods[] = 'PayPalMarketingSolutionsPlugin';
    return $methods;
  });

  function paypal_marketing_solutions_plugin_action_links( $links ) {
    $settings_link = '<a href="admin.php?page=wc-settings&tab=checkout&section='.WC_PAYPAL_MARKETING_SOLUTIONS_PLUGIN_NAME.'">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
    return $links;
  }

  add_filter( "plugin_action_links_" . plugin_basename( __FILE__) , 'paypal_marketing_solutions_plugin_action_links' );