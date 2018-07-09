<?php
/**
 * @package express
 */
/*
Plugin Name: PayPal Express Checkout
Plugin URI: https://example.com
Description: PayPal Express Checkout
Version: 0.0.0
Author: echizenya
Author URI: https://e-yota.com
License: GPLv2 or later
Text Domain: paypal_expresscheckout
*/

class PayPal_ExpressCheckout {

  // プロパティ（フィールドコールバックで使用される値を保持）
  private $options;

  // コンストラクタによる初期化
  public function __construct() {
    // checkout.jsの読み込み
    add_action( 'wp_enqueue_scripts', array($this, 'paypal_scripts' );
    add_action( 'admin_menu', array($this, 'paypalexpresscheckout_add_admin_menu') );
    add_action( 'admin_init', array($this, 'register_paypalsettings') );
  }



}

require(__DIR__ . '/express_admin.php');
