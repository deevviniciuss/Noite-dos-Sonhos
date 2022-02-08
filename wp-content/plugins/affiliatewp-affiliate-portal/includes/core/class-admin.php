<?php
/**
 * Core: Admin
 *
 * @package     AffiliateWP Affiliate Portal
 * @subpackage  Core
 * @copyright   Copyright (c) 2021, Sandhills Development, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0.0
 */
namespace AffiliateWP_Affiliate_Portal\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin class.
 *
 * @since 1.0.0
 */
class Admin {

	/**
	 * Admin constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Settings tab.
		add_filter( 'affwp_settings_tabs', array( $this, 'setting_tab' ) );

		// Settings.
		add_filter( 'affwp_settings', array( $this, 'register_settings' ) );
	}

	/**
	 * Registers the new settings tab.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of settings tabs.
	 */
	public function setting_tab( $tabs ) {
		$tabs['affiliate_portal'] = __( 'Affiliate Portal', 'affiliatewp-affiliate-portal' );
		return $tabs;
	}

	/**
	 * Registers the settings.
	 *
	 * @since 1.0.0
	 *
	 * @return array Array of settings.
	 */
	public function register_settings( $settings = array() ) {

		$settings['affiliate_portal'] = array(

			'portal_enabled' => array(
				'name' => __( 'Enable the Affiliate Portal', 'affiliatewp-affiliate-portal' ),
				'desc' => __( 'Check this box to enable the Affiliate Portal.', 'affiliatewp-affiliate-portal' ),
				'type' => 'checkbox',
			),
			'portal_allow_affiliate_feedback' => array(
				'name' => __( 'Affiliate Feedback', 'affiliatewp-affiliate-portal' ),
				'desc' => __( 'Allow affiliate feedback.<p class="description">Enabling this option will allow your affiliates to submit anonymous feedback directly to us from within the affiliate portal. Any feedback collected will be used to help improve the add-on and overall portal experience which all your affiliates will benefit from. No personal data will be collected.</p>', 'affiliatewp-affiliate-portal' ),
				'type' => 'checkbox',
			),
			'portal_sharing_header' => array(
				'name' => __( 'Referral Link Sharing', 'affiliatewp-affiliate-portal' ),
				'type' => 'header'
			),
			'portal_sharing_options' => array(
				'name'    => __( 'Sharing Options', 'affiliatewp-affiliate-portal' ),
				'type'    => 'multicheck',
				'options' => array(
					'twitter'    => __( 'Twitter', 'affiliatewp-affiliate-portal' ),
					'facebook'   => __( 'Facebook', 'affiliatewp-affiliate-portal' ),
					'email'      => __( 'Email', 'affiliatewp-affiliate-portal' ),
				)
			),
			'portal_sharing_twitter_text' => array(
				'name' => __( 'Twitter Text', 'affiliatewp-affiliate-portal' ),
				'desc' => '<p class="description">' . __( 'The default text that will show when an affiliate shares to Twitter. Leave blank to use Site Title.', 'affiliatewp-affiliate-portal' ) . '</p>',
				'type' => 'text',
			),
			'portal_sharing_email_subject' => array(
				'name' => __( 'Email Sharing Subject', 'affiliatewp-affiliate-portal' ),
				'desc' => '<p class="description">' . __( 'The default text that will show in the email subject line. Leave blank to use Site Title.', 'affiliatewp-affiliate-portal' ) . '</p>',
				'type' => 'text',
			),
			'portal_sharing_email_body' => array(
				'name' => __( 'Email Sharing Message', 'affiliatewp-affiliate-portal' ),
				'desc' => '<p class="description">' . __( 'The default text that will show in the email message. The affiliate\'s referral URL will be automatically appended to the email.', 'affiliatewp-affiliate-portal' ) . '</p>',
				'type' => 'text',
				'std'  => __( 'I thought you might be interested in this:', 'affiliatewp-affiliate-portal' ),
			)

		);

		return $settings;
	}

}
