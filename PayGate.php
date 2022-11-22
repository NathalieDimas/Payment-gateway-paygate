<?php 
/*
Plugin Name: raiola
Plugin URI: https://github.com/NathalieDimas/paygate
Description: Plugin de ejemplo del post de como crear un plugin en WordPress
Version: 0.1
Author: Nathalie Dimas
Author URI: https://github.com/NathalieDimas/paygate
License: GPL
*/
add_action( 'plugins_loaded', 'PayGate_payment_init', 0 );
  function PayGate_payment_init() {

    //Si la clase para pasarelas de pago de woocommerce no existe retornamos
    if ( ! class_exists( 'WC_Payment_Gateway' ) ) return;

    //Incluimos nuestra propia clase en otro archivo.php
    include_once( 'wc-PayGate.php' );

    //Añadimos nuestro metodo de pago en los ajustes de WooCommerce
    add_filter( 'woocommerce_payment_gateways', 'add_PayGate_payment_gateway' );
    function add_PayGate_payment_gateway( $methods ) {
      $methods[] = 'PayGate_Payment_Gateway';
      return $methods;
    }
  }


  // Añadimos funciones para ajustes perzonalizados de nuestro metodo de pago
  add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'PayGate_action_links' );
  function PayGate_action_links( $links ) {
    $plugin_links = array(
      '<a href="' . admin_url( 'admin.php?page=wc-settings&tab=checkout' ) . '">' . __( 'Ajustes', 'PayGate-payment' ) . '</a>',
    );

    // Añadimos el nuevo link a nuestros links del plugin
    return array_merge( $plugin_links, $links );
  }
?>