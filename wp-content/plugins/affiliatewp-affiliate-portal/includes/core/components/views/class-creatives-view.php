<?php
/**
 * Views: Creatives View
 *
 * @package   Core/Components
 * @copyright Copyright (c) 2021, Sandhills Development, LLC
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since     1.0.0
 */

namespace AffiliateWP_Affiliate_Portal\Core\Components\Views;

use AffiliateWP_Affiliate_Portal\Core\Components\Controls;
use AffiliateWP_Affiliate_Portal\Core\Interfaces\View;

/**
 * Sets up the Creatives view.
 *
 * @since 1.0.0
 */
class Creatives_View implements View {

	/**
	 * Retrieves the view sections.
	 *
	 * @since 1.0.0
	 *
	 * @return array[] Sections.
	 */
	public function get_sections() {
		return array(
			'creatives' => array(
				'priority' => 1,
				'wrapper'  => false,
				'columns'  => array(
					'header'  => 3,
					'content' => 3,
				),
			),
		);
	}

	/**
	 * Retrieves the view controls.
	 *
	 * @since 1.0.0
	 *
	 * @return array[] Sections.
	 */
	public function get_controls() {

		// Get Creatives.
		$page     = 1;
		$per_page = 30;
		$args     = array(
			'number' => $per_page,
			'offset' => $per_page * ( $page - 1 ),
			'status' => 'active',
		);
		$creatives = affiliate_wp()->creatives->get_creatives( $args );

		// Wrapper div.
		$controls = array(
			new Controls\Wrapper_Control( array(
				'id'      => 'wrapper',
				'view_id' => 'creatives',
				'section' => 'wrapper',
				'atts'    => array(
					'id' => 'affwp-affiliate-portal-creatives',
				),
			) )
		);

		// Creatives cards.
		$creatives_cards = array();
		foreach ( $creatives as $creative ) {
			$image_id = attachment_url_to_postid( $creative->image );
			$image    = wp_get_attachment_image_src( $image_id, 'full' );

			$creatives_cards[] = new Controls\Creative_Card_Control( array(
				'id'      => 'creative_card',
				'view_id' => 'creatives',
				'section' => 'creatives',
				'args'    => array(
					'image'       => $image ? $image[0] : '',
					'text'        => $creative->text,
					'url'         => $creative->url,
					'description' => $creative->description ? $creative->description : '',
				),
			) );
		}

		$controls[] = new Controls\Card_Group_Control( array(
			'id'       => 'creatives_card_group',
			'view_id'  => 'creatives',
			'section'  => 'creatives',
			'priority' => 5,
			'args'     => array(
				'columns' => 4,
				'cards'   => $creatives_cards,
			),
		) );

		return $controls;
	}

}
