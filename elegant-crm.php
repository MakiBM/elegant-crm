<?php
/**
 * Plugin Name: Elegant CRM
 * Plugin URI: https://github.com/makibm/elegant-crm/
 * Description: Simple CRM system for Elegant Themes. 
 * Version: 1.0.0
 * Author: Maki
 * Author URI: https://makibm.github.io
 * License: MIT License
 */

// Exit if accessed directly
if (!defined('ABSPATH')) { exit; } 

if (!class_exists('et_elegant_crm')) :

  class et_elegant_crm {

    function __construct() {
      $this->assets_url = plugins_url('assets/dist', __FILE__);
      add_action('init', array($this, 'on_init'));
    } 

    function on_init() {
      $this->add_customers_post_type();

      add_shortcode('elegant_form', array($this, 'elegant_form_shortcode'));

      add_action('wp_ajax_nopriv_add_crm_customer', array($this, 'add_crm_customer'));
      add_action('wp_ajax_add_crm_customer', array($this, 'add_crm_customer'));

      wp_register_style('et_styles', $this->assets_url.'/styles/styles.css', null, null);
      wp_register_script('et_scripts', $this->assets_url.'/scripts/bundle.js', array(), null, true); // load at bottom

      wp_localize_script( 'et_scripts', 'etElegantCrm', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' )
      ));
    }

    function elegant_form_shortcode($user_atts) {
      $default_atts = array(
        'name_label' => 'Name',
        'phone_label' => 'Phone Number',
        'email_label' => 'Email Address',
        'budget_label' => 'Desired Budget',
        'message_label' => 'Message',
        'name_maxlength' => '',
        'phone_maxlength' => '',
        'email_maxlength' => '',
        'budget_maxlength' => '',
        'message_maxlength' => '',
        'message_rows' => '',
        'message_cols' => '',
      );
      $atts = shortcode_atts($default_atts, $user_atts);
      $template = $this->get_template('form-template.php', $atts);

      // Load all needed styles 
      wp_enqueue_script('et_scripts');
      wp_enqueue_style('et_styles');

      // Output markup
      return $template;
    }

    function add_crm_customer() {
      // First check the nonce, if it fails the function will break
      check_ajax_referer('et_elegant_crm__security', 'security');

      if (empty($_POST['name']) || empty($_POST['phone']) 
        || empty($_POST['email']) || empty($_POST['budget']) 
        || empty($_POST['message'])) {
          echo json_encode(array(
            'success' => false, 
            'message' => 'All fields are required'
          ));
      }
      else {
        $data = array(
          'post_title' => $_POST['name'],
          'post_type' => 'customers',
          'post_status' => 'private'
        );
        $id = wp_insert_post($data);
        $this->update_post_meta($id, 'phone', $_POST['phone']);
        $this->update_post_meta($id, 'email', $_POST['email']);
        $this->update_post_meta($id, 'budget', $_POST['budget']);
        $this->update_post_meta($id, 'message', $_POST['message']);

        echo json_encode(array(
          'success' => true,
          'message' => 'Thank you for submission'
        ));
      }

      wp_die();
    }

    function add_customers_post_type() {
      register_post_type('customers', array(
        'labels' => array(
          'name' => __('Customers'),
          'singular_name' => __('Customer'),
          'add_new' => _x('Add new', 'Customers item'),
          'add_new_item' => __('Add New Customer'),
        ),
        'public' => false,
        'has_archive' => false,
        '_builtin' => false,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'custom-fields'),
        'rewrite' => array("slug" => 'customers'),
        'menu_icon' => 'dashicons-star-filled'
      ));
    }

    function update_post_meta($post_id, $field_name, $value = '') {
      if (empty($value) OR !$value) {
        delete_post_meta($post_id, $field_name);
      } 
      elseif (!get_post_meta($post_id, $field_name)) {
        add_post_meta($post_id, $field_name, $value);
      } 
      else {
        update_post_meta($post_id, $field_name, $value);
      }
    }

    // Helper that includes file with scoped vars
    function get_template($file, $atts) {
      extract($atts);
      ob_start();
      include($file);
      return ob_get_clean();
    }

  }

  // Return one and only instance of the plugin
  function et_elegant_crm() {
    global $et_elegant_crm;
    
    if(!isset($et_elegant_crm)) {
      $et_elegant_crm = new et_elegant_crm();
    }
    
    return $et_elegant_crm;
  }

  // initialize
  et_elegant_crm();

endif;