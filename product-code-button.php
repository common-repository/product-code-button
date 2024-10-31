<?php
/**
* Plugin Name: Product Code Button
* Plugin URI: https://wordpress.org/plugins/product-code-button/
* Description: This plugin adds a button with the product code to the single product page in WooCommerce. Change the priority of the product code button on the single product page, please go to setting >general >scroll Down.
* Version: 1.0
* Author: Didar
* Author URI: https://abdidar.info
* License:     GPLv2 or later
* License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
* Text Domain: product-code-button
* Domain Path: /languages
* Plugin Icon: img/plugin-icon.png
* Requires at least: 5.5
* Tested up to: 6.1.1
* Requires PHP: 5.2.4
*
* This program is free software; you can redistribute it and/or modify it under the terms of the GNU
* General Public License version 2, as published by the Free Software Foundation. You may NOT assume
* that you can use any other version of the GPL.
*
* This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
* even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
*/
function product_code_button_settings_link( $links ) {
  $settings_link = '<a href="options-general.php">Settings</a>';
  array_push( $links, $settings_link );
  return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'product_code_button_settings_link' );

add_action( 'woocommerce_single_product_summary', 'add_product_code_button', get_option( 'product_code_button_priority' ) );
function add_product_code_button() {
  global $product;
  echo '</br><button class="product_id">Product Code: ' . $product->get_id() . '</button>';
}

function product_code_button_settings_init() {
  add_settings_section(
    'product_code_button_section',
    'Product Code Button Settings',
    'product_code_button_section_callback',
    'general'
  );

  add_settings_field(
    'product_code_button_priority',
    'Button Priority',
    'product_code_button_priority_render',
    'general',
    'product_code_button_section'
  );

  register_setting( 'general', 'product_code_button_priority' );
}
add_action( 'admin_init', 'product_code_button_settings_init' );

function product_code_button_section_callback() {
  echo 'Change the priority of the product code button on the single product page';
}

function product_code_button_priority_render() {
  $options = get_option( 'product_code_button_priority' );
  ?>
  <select name="product_code_button_priority">
    <option value="10" <?php selected( $options, '10' ); ?>>Under Title</option>
   <option value="20" <?php selected( $options, '20' ); ?>>Under Price</option>
    <option value="25" <?php selected( $options, '25' ); ?>>Under Short Desc</option>
    <option value="50" <?php selected( $options, '50' ); ?>>Under Meta</option>
  </select>
  <?php
}

function product_code_button_scripts() {
  wp_enqueue_style( 'product-code-button-style', plugin_dir_url( __FILE__ ) . '/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'product_code_button_scripts' );
