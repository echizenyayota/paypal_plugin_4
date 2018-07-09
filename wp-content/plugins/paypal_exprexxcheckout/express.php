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
    add_action( 'wp_enqueue_scripts', array($this, 'paypal_scripts' ));
    add_action( 'admin_menu', array($this, 'paypalexpresscheckout_add_admin_menu') );
    add_action( 'admin_init', array($this, 'page_init') );
  }

  // checkout.jsの読み込み
  public function paypal_scripts() {
    wp_enqueue_script( 'paypal-checkout', 'https://www.paypalobjects.com/api/checkout.js' );
  }

  // 設定メニューページにサブメニューページを追加する
  public function paypalexpresscheckout_add_admin_menu() {
    add_options_page(
        'Settings Admin',
        'PayPal ExpressCheckout Settings Page',
        'manage_options',
        'my-setting-admin',
        array( $this, 'create_admin_page' )
    );
  }

  // 設定ページの表示
  public function create_admin_page() {
   // my_option_nameをoptionsのプロパティとする
   $this->options = get_option( 'my_option_name' );
   ?>
   <div class="wrap">
      <h2>PayPal ExpressCheckout Settings Page</h2>
      <form method="post" action="options.php">
        <?php settings_fields( 'paypal-settings-group' ); ?>
        <?php do_settings_sections( 'paypal-settings-group' ); ?>
        <table class="form-table">
          <tr>
            <th scope="row">Develop Enviroment</th>
            <td>
              <p>
                <select name="env" size="1">
                  <option value="sandbox" <?php selected( get_option( 'env' ), 'sandbox' ); ?>>sandbox</option>
                  <option value="production" <?php selected( get_option( 'env' ), 'production' ); ?>>production</option>
                </select>
              </p>
            </td>
          </tr>
          <tr valign="top">
          <th scope="row">Client ID</th>
          <td><input type="text" name="client" size="90" value="<?php echo esc_attr( get_option('client') ); ?>" /></td>
          </tr>
        </table>
        <?php submit_button(); ?>
      </form>

   <?php
  }

  public function page_init() {

    // 設定項目と無害化用コールバックの登録
    register_setting(
      'paypal-settings-group',
      'paypal_option_name',
      array( $this, 'sanitize' ),
      'my-setting-admin'
    );
    // 設定をまとめる
    add_settings_section(
      'setting_section_id',
      'PayPal ExpressCheckout Custom Settings',
      array( $this, 'print_section_info' ),
      'my-setting-admin'
    );
    // 設定項目の追加(実行環境)
    add_settings_field(
      'env',
      'Enviroment',
      array( $this, 'id_number_callback' ),
      'my-setting-admin',
      'setting_section_id'
    );
    // 設定項目の追加(clientID)
    add_settings_field(
      'client',
      'client ID',
      array( $this, 'title_callback' ),
      'my-setting-admin',
      'setting_section_id'
    );
  }

  // 入力値のサニタイズ
  public function sanitize( $input ) {
    $new_input = array();
    // 入力値を絶対値の数値にする
    if( isset( $input['env'] ) ){
      $new_input['env'] = sanitize_text_field( $input['env'] );
    }
    // 特殊文字のサニタイズ
    if( isset( $input['client'] ) ){
      $new_input['client'] = sanitize_text_field( $input['client'] );
    }
    // 配列値で結果を返す
    return $new_input;
  }



}

require(__DIR__ . '/express_admin.php');
