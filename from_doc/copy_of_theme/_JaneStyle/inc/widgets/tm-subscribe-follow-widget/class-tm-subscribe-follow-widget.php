<?php
/**
 * Widget jane_style subscribe and follow
 *
 * @package jane_style
 */

class Jane_Style_Subscribe_Follow_Widget extends Cherry_Abstract_Widget {

	/**
	 * MailChimp API server
	 *
	 * @var string
	 */
	private $api_server = 'https://%s.api.mailchimp.com/2.0/';

	/**
	 * Service errors set
	 *
	 * @var array
	 */
	public $errors = array();

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->widget_cssclass    = 'jane_style widget-subscribe';
		$this->widget_description = __( 'Display subscribe form and follow links.', 'jane_style' );
		$this->widget_id          = 'jane_style_widget_subscribe_follow';
		$this->widget_name        = __( 'Subscribe and Follow', 'jane_style' );
		$this->settings           = array(
			'enable_subscribe' => array(
				'type'   => 'checkbox',
				'value'  => array(
					'enable_subscribe' => 'true',
				),
				'options' => array(
					'enable_subscribe' => __( 'Enable Subscribe Box', 'jane_style' ),
				),
			),
			'subscribe_title' => array(
				'type'  => 'text',
				'value' => __( 'Subscribe', 'jane_style' ),
				'label' => __( 'Subscribe Title', 'jane_style' ),
			),
			'subscribe_message' => array(
				'type'  => 'textarea',
				'label' => __( 'Subscribe text message', 'jane_style' ),
			),
			'subscribe_input' => array(
				'type'  => 'text',
				'value' => __( 'Enter your email', 'jane_style' ),
				'label' => __( 'Subscribe input placeholder', 'jane_style' ),
			),
			'subscribe_submit' => array(
				'type'  => 'text',
				'value' => __( 'Subscribe', 'jane_style' ),
				'label' => __( 'Subscribe submit label', 'jane_style' ),
			),
			'subscribe_success' => array(
				'type'  => 'text',
				'value' => __( 'You successfully subscribed', 'jane_style' ),
				'label' => __( 'Subscribe success', 'jane_style' ),
			),
			'enable_follow' => array(
				'type'   => 'checkbox',
				'value'  => array(
					'enable_follow' => 'true',
				),
				'options' => array(
					'enable_follow' => __( 'Enable Follow Box', 'jane_style' ),
				),
			),
			'follow_title' => array(
				'type'  => 'text',
				'value' => __( 'Follow', 'jane_style' ),
				'label' => __( 'Follow Title', 'jane_style' ),
			),
			'follow_message' => array(
				'type'  => 'textarea',
				'label' => __( 'Follow text message', 'jane_style' ),
			),
		);

		add_action( 'wp_ajax_jane_style_subscribe', array( $this, 'process_subscribe' ) );
		add_action( 'wp_ajax_nopriv_jane_style_subscribe', array( $this, 'process_subscribe' ) );

		$this->errors = array(
			'nonce'     => esc_html__( 'Security validation failed', 'jane_style' ),
			'mail'      => esc_html__( 'Please, provide valid mail', 'jane_style' ),
			'mailchimp' => esc_html__( 'Please, set up MailChimp API key and List ID', 'jane_style' ),
			'internal'   => esc_html__( 'Internal error. Please, try again later', 'jane_style' ),
		);

		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$this->setup_widget_data( $args, $instance );
		$this->widget_start( $args, $instance );

		$subscribe_enabled = ( ! empty( $instance['enable_subscribe'] ) ) ? $instance['enable_subscribe'] : false;

		if ( is_array( $subscribe_enabled ) && 'true' === $subscribe_enabled['enable_subscribe'] ) {
			$subscribe_enabled = true;
		} else {
			$subscribe_enabled = false;
		}

		$follow_enabled = ( ! empty( $instance['enable_follow'] ) ) ? $instance['enable_follow'] : false;

		if ( is_array( $follow_enabled ) && 'true' === $follow_enabled['enable_follow'] ) {
			$follow_enabled = true;
		} else {
			$follow_enabled = false;
		}

		$follow_template = locate_template( 'inc/widgets/tm-subscribe-follow-widget/view/follow-view.php' );

		// Load follow template
		if ( $follow_template && $follow_enabled ) {
			include $follow_template;
		}

		$subscribe_template = locate_template( 'inc/widgets/tm-subscribe-follow-widget/view/subcribe-view.php' );

		$api_key = get_theme_mod( 'mailchimp_api_key' );
		$list_id = get_theme_mod( 'mailchimp_list_id' );

		// Load subscribe tamplate
		if ( $subscribe_enabled && $subscribe_template && $api_key && $list_id ) {
			include $subscribe_template;
		} elseif ( ! $api_key || ! $list_id ) {
			_e( 'Please set up MailChimp API key and List ID', 'jane_style' );
		}

		$this->widget_end( $args );
		$this->reset_widget_data();

		echo $this->cache_widget( $args, ob_get_clean() );
	}

	/**
	 * Get social navigation menu
	 *
	 * @return string
	 */
	public function get_social_nav() {
		return jane_style_get_social_list( 'widget' );
	}

	/**
	 * Get subscribe button HTML.
	 *
	 * @param  string $class CSS class.
	 * @return string
	 */
	public function get_subscribe_submit( $class ) {

		$subscribe_submit = ( ! empty( $this->instance['subscribe_submit'] ) ) ? $this->instance['subscribe_submit'] : '';

		return '<a href="#" class="subscribe-block__submit ' . esc_attr( $class ) . '">' . esc_html( $subscribe_submit ) . '</a>';
	}

	/**
	 * Get subscribe or follow block title.
	 *
	 * @param  string $block Block name to get title for.
	 * @return string
	 */
	public function get_block_title( $block = 'follow' ) {

		$setting = $block . '_title';
		$title   = ( ! empty( $this->instance[ $setting ] ) ) ? $this->instance[ $setting ] : '';

		if ( $title ) {
			return $this->args['before_title'] . $title . $this->args['after_title'];
		}
	}

	/**
	 * Get subscribe or follow block title.
	 *
	 * @param  string $block Block name to get title for.
	 * @return string
	 */
	public function get_block_message( $block = 'follow' ) {

		$setting = $block . '_message';
		$message = ( ! empty( $this->instance[ $setting ] ) ) ? $this->instance[ $setting ] : '';

		if ( $message ) {
			return '<div class="' . $block . '-block__message">' . wp_kses( $message, wp_kses_allowed_html( 'post' ) ) . '</div>';
		}

	}

	/**
	 * Get subscribe form input
	 *
	 * @return string
	 */
	public function get_subscribe_input() {
		return '<input class="subscribe-block__input" type="email" name="subscribe-mail" value="" placeholder="' . esc_attr( $this->instance['subscribe_input'] ) . '">';
	}

	/**
	 * Get subscribe form service messages
	 *
	 * @return string
	 */
	public function get_subscribe_messages() {

		$success = ( ! empty( $this->instance['subscribe_success'] ) ) ? $this->instance['subscribe_success'] : '';

		return '<div class="subscribe-block__messages">
					<div class="subscribe-block__success hidden">' . esc_html( $success ) . '</div>
					<div class="subscribe-block__error hidden"></div>
				</div>';
	}

	/**
	 * Process subscribtion form
	 *
	 * @return void
	 */
	public function process_subscribe() {

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'jane_style_subscribe' ) ) {
			wp_send_json_error( array( 'message' => $this->errors['nonce'] ) );
		}

		$mail = ( ! empty( $_POST['mail'] ) ) ? esc_attr( $_POST['mail'] ) : false;

		if ( ! is_email( $mail ) ) {
			wp_send_json_error( array( 'message' => $this->errors['mail'] ) );
		}

		$args = array(
			'email' => array(
				'email' => $mail,
			),
			'double_optin' => false,
		);

		$response = $this->api_call( 'lists/subscribe', $args );

		if ( false === $response ) {
			wp_send_json_error( array( 'message' => $this->errors['mailchimp'] ) );
		}

		$response = json_decode( $response, true );

		if ( empty( $response ) ) {
			wp_send_json_error( array( 'message' => $this->errors['internal'] ) );
		}

		if ( isset( $response['status'] ) && 'error' == $response['status'] ) {
			wp_send_json_error( array( 'message' => esc_html( $response['error'] ) ) );
		}

		wp_send_json_success();

	}

	/**
	 * Make remote request to mailchimp API
	 *
	 * @param  string $method API method to call.
	 * @param  array  $args   API call arguments.
	 * @return array|bool
	 */
	public function api_call( $method, $args = array() ) {

		if ( ! $method ) {
			return false;
		}

		$api_key = get_theme_mod( 'mailchimp_api_key' );
		$list_id = get_theme_mod( 'mailchimp_list_id' );

		if ( ! $api_key || ! $list_id ) {
			return false;
		}

		$key_data = explode( '-', $api_key );

		if ( empty( $key_data ) || ! isset( $key_data[1] ) ) {
			return false;
		}

		$this->api_server = sprintf( $this->api_server, $key_data[1] );

		$url      = esc_url( trailingslashit( $this->api_server . $method ) );
		$defaults = array( 'apikey' => $api_key, 'id' => $list_id );
		$data     = json_encode( array_merge( $defaults, $args ) );

		$request = wp_remote_post( $url, array( 'body' => $data ) );

		return wp_remote_retrieve_body( $request );

	}

}

add_action( 'widgets_init', 'jane_style_register_subscribe_follow_widgets' );
function jane_style_register_subscribe_follow_widgets() {
	register_widget( 'jane_style_Subscribe_Follow_Widget' );
}
