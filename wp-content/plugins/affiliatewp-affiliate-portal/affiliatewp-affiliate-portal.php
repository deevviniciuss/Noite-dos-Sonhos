<?php
/**
 * Plugin Name: AffiliateWP - Affiliate Portal
 * Plugin URI: https://affiliatewp.com/add-ons/pro/affiliate-portal/
 * Description: Provides an optimized experience for affiliates via a custom portal user interface
 * Author: Sandhills Development, LLC
 * Author URI: https://sandhillsdev.com
 * Version: 1.0.1
 * Text Domain: affiliatewp-affiliate-portal
 * Domain Path: languages
 *
 * AffiliateWP is distributed under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * AffiliateWP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AffiliateWP. If not, see <http://www.gnu.org/licenses/>.
 */
if ( ! class_exists( 'AffiliateWP_Requirements_Check' ) ) {
	require_once dirname( __FILE__ ) . '/includes/lib/affwp/class-affiliatewp-requirements-check.php';
}

/**
 * Class used to check requirements for and bootstrap the plugin.
 *
 * @since 1.0.0
 *
 * @see Affiliate_WP_Requirements_Check
 */
class AffiliateWP_Affiliate_Portal_Requirements_Check extends AffiliateWP_Requirements_Check {

	/**
	 * Plugin slug.
	 *
	 * @since 1.0.0
	 * @var   string
	 */
	protected $slug = 'affiliatewp-affiliate-portal';

	/**
	 * Add-on requirements.
	 *
	 * @since 1.0.0
	 * @var   array[]
	 */
	protected $addon_requirements = array(
		// AffiliateWP.
		'affwp' => array(
			'minimum' => '2.6.7',
			'name'    => 'AffiliateWP',
			'exists'  => true,
			'current' => false,
			'checked' => false,
			'met'     => false
		),

		// WordPress.
		'wp' => array(
			'minimum' => '5.0.0',
			'name'    => 'WordPress',
			'exists'  => true,
			'current' => false,
			'checked' => false,
			'met'     => false
		),

	);

	/**
	 * Bootstrap everything.
	 *
	 * @since 1.0.0
	 */
	public function bootstrap() {
		if ( ! class_exists( 'Affiliate_WP' ) ) {

			if ( ! class_exists( 'AffiliateWP_Activation' ) ) {
				require_once 'includes/lib/affwp/class-affiliatewp-activation.php';
			}

			// AffiliateWP activation
			if ( ! class_exists( 'Affiliate_WP' ) ) {
				$activation = new AffiliateWP_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
				$activation = $activation->run();
			}
		} else {
			\AffiliateWP_Affiliate_Portal::instance( __FILE__ );
		}
	}

	/**
	 * Loads the add-on.
	 *
	 * @since 1.0.0
	 */
	protected function load() {
		// Maybe include the bundled bootstrapper.
		if ( ! class_exists( 'AffiliateWP_Affiliate_Portal' ) ) {
			require_once dirname( __FILE__ ) . '/includes/class-affiliatewp-affiliate-portal.php';
		}

		// Maybe hook-in the bootstrapper.
		if ( class_exists( 'AffiliateWP_Affiliate_Portal' ) ) {

			// Bootstrap to plugins_loaded before priority 10 to make sure
			// add-ons are loaded after us.
			add_action( 'plugins_loaded', array( $this, 'bootstrap' ), 101 );

			// Register the activation hook.
			register_activation_hook( __FILE__, array( $this, 'install' ) );
		}
	}

	/**
	 * Install, usually on an activation hook.
	 *
	 * @since 1.0.0
	 */
	public function install() {
		// Bootstrap to include all of the necessary files
		$this->bootstrap();

		if ( defined( 'AFFWP_PORTAL_VERSION' ) ) {
			update_option( 'affwp_ap_version', AFFWP_PORTAL_VERSION );
		}
	}

	/**
	 * Plugin-specific aria label text to describe the requirements link.
	 *
	 * @since 1.0.0
	 *
	 * @return string Aria label text.
	 */
	protected function unmet_requirements_label() {
		return esc_html__( 'AffiliateWP - Affiliate Portal Requirements', 'affiliatewp-affiliate-portal' );
	}

	/**
	 * Plugin-specific text used in CSS to identify attribute IDs and classes.
	 *
	 * @since 1.0.0
	 *
	 * @return string CSS selector.
	 */
	protected function unmet_requirements_name() {
		return 'affiliatewp-affiliate-portal-requirements';
	}

	/**
	 * Plugin specific URL for an external requirements page.
	 *
	 * @since 1.0.0
	 *
	 * @return string Unmet requirements URL.
	 */
	protected function unmet_requirements_url() {
		return 'https://docs.affiliatewp.com/article/2361-minimum-requirements-roadmaps';
	}

}

$requirements = new AffiliateWP_Affiliate_Portal_Requirements_Check( __FILE__ );

$requirements->maybe_load();
