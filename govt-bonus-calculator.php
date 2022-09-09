<?php
/**
 * Plugin Name: Govt Bonus Calculator
 * Plugin URI: https://mustaneerabdullah.com
 * Description: This plugin will perform bonus calculation.
 * Author: Mustaneer Abdullah
 * Author URI: https://mustaneerabdullah.com
 * Version: 1.0.0
 * Text Domain: govt-bonus-calculator
 * Domain Path: /languages/
 * Tested up to: 5.5.1
 */
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'Govt_Bonus_Calculation' ) ) {
	/**
	 * Main Plugin Class
	 *
	 * @since 1.0
	 */
	class Govt_Bonus_Calculation {

		/**
		 * Plugin name for text domains.
		 *
		 * @var
		 */
		public static $plugin_name='govt-bonus-calculator';

		/**
		 * Plugin base name
		 *
		 * @var string
		 */
		public static $plugin_basename;

		/**
		 * Plugin file path
		 *
		 * @var string
		 */
		public static $plugin_path;

		/**
		 * Plugin url
		 *
		 * @var string
		 */
		public static $plugin_url;

		public function __construct() {
			self::$plugin_basename=plugin_basename( __FILE__ );
			self::$plugin_path=plugin_dir_path( __FILE__ );
			self::$plugin_url=plugin_dir_url( __FILE__ );

			// Adding settings link to plugin page
			add_filter( 'plugin_action_links_' . plugin_basename( self::$plugin_basename ), [
				$this,
				'plugin_settings_link',
			] );
			add_action( 'wp_enqueue_scripts', [
				$this,
				'enqueue_bonus_scripts',
			] );
			// Adding shortcode
			add_shortcode( 'bonus_calculator', [
				$this,
				'bonus_calculator_function',
			] );
			add_action( 'acf/init', 'my_acf_op_init' );
			// Adding ACF option page
			add_action( 'acf/init', [
				$this,
				'bonus_option_page',
			] );
			// Ajax function
			add_action( 'wp_ajax_nopriv_bonus_calculation_request', [
				$this,
				'bonus_calculation_request_function',
			] );
			add_action( 'wp_ajax_bonus_calculation_request', [
				$this,
				'bonus_calculation_request_function',
			] );
		}

		public function enqueue_bonus_scripts() {
			wp_enqueue_style(
				'range-slider-style',
				self::$plugin_url . 'includes/css/rangeslider.css',
				[],
				strtotime( 'now' )
			);
			wp_enqueue_style(
				'bonus-calculator-style',
				self::$plugin_url . 'includes/css/bonus-calculator-style.css',
				[],
				strtotime( 'now' )
			);
			wp_enqueue_script(
				'rangeslider-js',
				self::$plugin_url . 'includes/js/rangeslider.min.js',
				['jquery'],
				strtotime( 'now' ),
				true
			);
			wp_enqueue_script(
				'sweetalert-js',
				self::$plugin_url . 'includes/js/sweetalert.min.js',
				['jquery'],
				strtotime( 'now' ),
				true
			);
			wp_enqueue_script(
				'jquery-money-mask',
				self::$plugin_url . 'includes/js/jquery.maskMoney.js',
				['jquery'],
				strtotime( 'now' ),
				true
			);
			wp_enqueue_script(
				'bonus-slider-js',
				self::$plugin_url . 'includes/js/bonus-slider.js',
				['rangeslider-js'],
				strtotime( 'now' ),
				true
			);
			wp_localize_script(
				'bonus-slider-js',
				'admin_url',
				[
					'ajaxurl'					 => admin_url( 'admin-ajax.php' ),
					'deposit_help_title' 			   => get_field( 'deposit_help_title', 'option' ),
					'deposit_help_text' 				=> get_field( 'deposit_help_text', 'option' ),
					'not_sure_title' 					  => get_field( 'not_sure_title', 'option' ),
					'not_sure' 								  => get_field( 'not_sure', 'option' ),
					'additional_tooltip' 			   => get_field( 'additional_tooltip', 'option' ),
					'additional_tooltip_content' 	=> get_field( 'additional_tooltip_content', 'option' ),
				]
			);
		}

		/**
		 * @param $atts
		 * @param string $content
		 *
		 * @return false|string
		 */
		public function bonus_calculator_function( $atts, $content='' ) {
			//load shortcode file
			ob_start();
			require_once 'shortcode/bonus_calculator_shortcode.php';

			return ob_get_clean();
		}

		/**
		 * Add setting shortcut link in plugin section
		 *
		 * @param mixed $links
		 *
		 * @return void
		 */
		public function plugin_settings_link( $links ) {
			$settings_link='<a href="' . admin_url( 'options-general.php?page=ss-setting-admin' ) . '">' . __( 'Settings', self::$plugin_name ) . '</a>';
			array_unshift( $links, $settings_link );

			return $links;
		}

		/**
		 * Remove options for bonus plugin
		 */
		public static function bonus_option_page() {
			acf_add_options_page( [
				'page_title' 	=> 'Bonus Calculator',
				'menu_title'	 => 'Bonus Calculator',
				'menu_slug' 	 => 'bonus-calculator-settings',
				'capability'	 => 'edit_posts',
				'redirect'		  => false,
			] );
		}

		/**
		 * bonus_calculation_request_function function.
		 *
		 * @return void
		 */
		public function bonus_calculation_request_function() {
			$url='https://api.moneyboxapp.com/housebuyingcalculatorweb/';

			if ( isset( $_POST['action'] ) && $_POST['action'] == 'bonus_calculation_request' ) {
				$deposit_amount=( isset( $_POST['deposit_amount'] ) ) ? $_POST['deposit_amount'] : '';
				$deposit_amount_years=( isset( $_POST['deposit_amount_years'] ) ) ? $_POST['deposit_amount_years'] : '';
				$deposit_amount=str_replace( '£', '', $deposit_amount );
				$deposit_amount=str_replace( ',', '', $deposit_amount );
				$deposit_amount_years=str_replace( ' years', '', $deposit_amount_years );
				$response=wp_remote_post(
					$url,
					[
						'method'	  => 'POST',
						'body'		=> [
							'Amount'		=> $deposit_amount,
							'NumberOfYears' => $deposit_amount_years,
						],
					]
				);
				$final_result=json_decode( wp_remote_retrieve_body( $response ), true );

				if ( !empty( $final_result ) ) {
					$recomended_savings=$final_result['Projection']['RecommendedSavings'];
					$weekly_deposit=$recomended_savings['MainAccountWeeklyDeposit'];
					$other_account_weekly_deposit=$recomended_savings['OtherAccountWeeklyDeposit'];
					$other_account_interest_rate_used=( $recomended_savings['OtherAccountInterestRateUsed'] * 100 );
					$break_down=$final_result['Projection']['Breakdown'];
					//print_r($break_down);
					$govt_bonus=$break_down['GovernmentBonus']['Value'];
					$yearly_govt_bonus=$break_down['YearlyGovernmentBonus'];
					$monthly_govt_bonus=$break_down['MonthlyGovernmentBonus'];
					$government_bonus_subtitle=$break_down['GovernmentBonus']['Subtitle'];
					$final_balance=$break_down['FinalBalance'];
					$years=$break_down['Years'];
					$interest_main_account=$break_down['InterestMainAccount']['Subtitle'];
					$otheraccountamount=$break_down['OtherAccountAmount']['Subtitle'];
					$final_balance=$break_down['FinalBalance'];
					$success_response=[
						'weekly_deposit'	 							 => number_format( $weekly_deposit, 2, '.', ',' ),
						'yearly_govt_bonus'  						  => number_format( $yearly_govt_bonus, 2, '.', ',' ),
						'govt_bonus'  									   => number_format( $govt_bonus, 0, '.', ',' ),
						'monthly_govt_bonus' 						  => number_format( $monthly_govt_bonus, 2, '.', ',' ),
						'final_balance'		 							 => number_format( $final_balance, 2, '.', ',' ),
						'years'				 								   => $years,
						'interest_main_account'						=> $interest_main_account,
						'otheraccountamount'						   => $otheraccountamount,
						'government_bonus_subtitle'				 => $government_bonus_subtitle,
						'other_account_weekly_deposit'		   => number_format( $other_account_weekly_deposit, 2, '.', ',' ),
						'other_account_interest_rate_used'	=> number_format( $other_account_interest_rate_used, 2, '.', ',' ),
					];

					wp_send_json_success( $success_response );
					die;
				} else {
					wp_send_json_error( __( 'No record found!', $this->plugin_name ) );
					die;
				}
			}
		}
	}
}

add_action( 'plugins_loaded', 'govt_bonus_calculation_init' );

/**
 * Initializes the extension.
 *
 * @return object instance of the extension
 */
function govt_bonus_calculation_init() {

	//Plugin global variable
	return $GLOBALS['govt_bonus_calculation']=new Govt_Bonus_Calculation();
}
