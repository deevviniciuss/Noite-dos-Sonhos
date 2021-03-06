<?php
/**
 * Utilities: User Migration Batch Processor
 *
 * @package     AffiliateWP
 * @subpackage  Admin/Utilites
 * @copyright   Copyright (c) 2016, Sandhills Development, LLC
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       2.0
 */

namespace AffWP\Utils\Batch_Process;

use AffWP\Utils;
use AffWP\Utils\Batch_Process as Batch;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Implements a batch processor for migrating existing users to affiliate accounts.
 *
 * @since 2.0
 *
 * @see \AffWP\Utils\Batch_Process
 * @see \AffWP\Utils\Batch_Process\With_PreFetch
 */
class Migrate_Users extends Utils\Batch_Process implements Batch\With_PreFetch {

	/**
	 * Batch process ID.
	 *
	 * @access public
	 * @since  2.0
	 * @var    string
	 */
	public $batch_id = 'migrate-users';

	/**
	 * Roles to migrate found users from.
	 *
	 * Should be set following instantiation via __set().
	 *
	 * @access public
	 * @since  2.0
	 * @var    array
	 */
	public $roles = array();

	/**
	 * Number of users to migrate per step.
	 *
	 * @access public
	 * @since  2.0
	 * @var    int
	 */
	public $per_step = 100;

	/**
	 * Initializes values needed following instantiation.
	 *
	 * @access public
	 * @since  2.0
	 *
	 * @param null|array $data Optional. Form data. Default null.
	 */
	public function init( $data = null ) {
		if ( null !== $data && ! empty( $data['roles'] ) ) {
			$this->roles = $data['roles'];
		}
	}

	/**
	 * Handles pre-fetching user IDs for accounts in migration.
	 *
	 * @access public
	 * @since  2.0
	 */
	public function pre_fetch() {
		$non_affiliate_users = affiliate_wp()->utils->data->get( "{$this->batch_id}_user_ids" );

		if ( false === $non_affiliate_users ) {
			$non_affiliate_users = get_users( array(
				'fields'             => 'ids',
				'role__in'           => $this->roles,
				'affwp_is_affiliate' => false,
			) );

			affiliate_wp()->utils->data->write( "{$this->batch_id}_user_ids", $non_affiliate_users );
		}

		$total_to_migrate = $this->get_total_count();

		if ( false === $total_to_migrate ) {
			$total_to_migrate = count( $non_affiliate_users );

			$this->set_total_count( $total_to_migrate );
		}
	}

	/**
	 * Executes a single step in the batch process.
	 *
	 * @access public
	 * @since  2.0
	 *
	 * @return int|string|\WP_Error Next step number, 'done', or a WP_Error object.
	 */
	public function process_step() {
		if ( ! $this->roles ) {
			return new \WP_Error( 'no_roles_found', __( 'No user roles were selected for migration.', 'affiliate-wp' ) );
		}

		$current_count = $this->get_current_count();

		$non_affiliate_users = affiliate_wp()->utils->data->get( "{$this->batch_id}_user_ids", array() );

		$to_process = array_slice( $non_affiliate_users, $this->get_offset(), $this->per_step );

		if ( empty( $to_process ) ) {
			return 'done';
		}

		$args = array(
			'include' => $to_process,
			'orderby' => 'ID',
			'order'   => 'ASC',
			'fields'  => array( 'ID', 'user_email', 'user_registered' )
		);

		$users = get_users( $args );

		$inserted = array();

		foreach ( $users as $user ) {

			$args = array(
				'status'          => 'active',
				'user_id'         => $user->ID,
				'payment_email'	  => $user->user_email,
				'date_registered' => $user->user_registered
			);

			$inserted[] = affiliate_wp()->affiliates->insert( $args, 'affiliate' );

		}

		$this->set_current_count( absint( $current_count ) + count( $inserted ) );

		return ++$this->step;
	}

	/**
	 * Retrieves a message for the given code.
	 *
	 * @access public
	 * @since  2.0
	 *
	 * @param string $code Message code.
	 * @return string Message.
	 */
	public function get_message( $code ) {

		switch( $code ) {

			case 'done':
				$final_count = $this->get_current_count();

				$message = sprintf(
					_n(
						/* translators: Singular affiliate number */
						'%s affiliate was added successfully.',
						/* translators: Plural affiliates number */
						'%s affiliates were added successfully.',
						$final_count,
						'affiliate-wp'
					), number_format_i18n( $final_count )
				);
				break;

			default:
				$message = '';
				break;
		}

		return $message;
	}

}
