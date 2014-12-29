<?php
/**
 * Ad Widget
 *
 * @package   Hihat_Ad_Widget
 * @author    Mike Turner <turner.mike@gmail.com>
 * @license   GPL-2.0+
 * @link      http://hi-hatconsulting.com
 * @copyright 2014 Hi-hat Consulting
 */

class Hihat_Ad_Widget_Widget extends WP_Widget{

	//constructor
	function Hihat_Ad_Widget_Widget(){

		$name = __('Hi-hat Ad Widget', 'hihat-ad-widget');
		$desc = __('This widget  will allow you to display custom ads on your widget enabled sidebars.', 'hihat-ad-widget');
		$class_name = 'hihat-ad-widget';
		parent::WP_Widget(false, $name, array('classname' => $class_name, 'description' => $desc));
	}

	//widget form creation
	function form($instance){

		// print('<pre>');
		// print_r($instance);
		// print('</pre>');

		// Check values
		if( $instance) {
		     $title = esc_attr($instance['title']);
		     if(isset($instance['desc'])){
		     	$desc = esc_attr($instance['desc']);
		     }
		     if(isset($instance['target_url'])){
		     	$target_url = esc_attr($instance['target_url']);
		     }
		     if(isset($instance['alt_text'])){
		     	$alt_text = esc_attr($instance['alt_text']);
		     }
		     if(isset($instance['image_url'])){
		     	$image_url = esc_attr($instance['image_url']);
		     }
		     if(isset($instance['attachment_id'])){
		     	$attachment_id = esc_attr($instance['attachment_id']);
		     }
		     if(isset($instance['new_window'])){
		     	$new_window = $instance['new_window'];
		     }

		} else {
		     $title = '';
		     $desc = '';
		     $target_url = '';
		     $alt_text = '';
		     $image_url = '';
		     $attachment_id = '';
		     $new_window = '';
		}
		?>

		<!-- title -->
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'hihat-ad-widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<!-- desc -->
		<p>
		<label for="<?php echo $this->get_field_id('desc'); ?>"><?php _e('Description', 'hihat-ad-widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('desc'); ?>" name="<?php echo $this->get_field_name('desc'); ?>" type="text" value="<?php echo $desc; ?>" />
		</p>
		<!-- link target url -->
		<p>
		<label for="<?php echo $this->get_field_id('target_url'); ?>"><?php _e('Link Target URL', 'hihat-ad-widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('target_url'); ?>" name="<?php echo $this->get_field_name('target_url'); ?>" type="text" value="<?php echo $target_url; ?>" />
		</p>
		<!-- alt text -->
		<p>
		<label for="<?php echo $this->get_field_id('alt_text'); ?>"><?php _e('Alternate Text', 'hihat-ad-widget'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('alt_text'); ?>" name="<?php echo $this->get_field_name('alt_text'); ?>" type="text" value="<?php echo $alt_text; ?>" />
		</p>
		<!-- image -->
		<div class="uploader">
		<p>
		<input type="submit" class="button" name="<?php echo $this->get_field_name('uploader_button'); ?>" id="<?php echo $this->get_field_id('uploader_button'); ?>" value="<?php _e('Select an Image', ''); ?>" onclick="imageWidget.uploader( '<?php echo $this->id; ?>', '<?php echo $id_prefix; ?>' ); return false;" />
		</p>
		<div id="<?php echo $this->get_field_id('preview'); ?>" class="preview">
			<p><?php echo $this->get_image_html($instance, false); ?></p>
		</div>
		<input type="hidden" id="<?php echo $this->get_field_id('attachment_id'); ?>" name="<?php echo $this->get_field_name('attachment_id'); ?>" value="<?php echo $attachment_id; ?>" />
		<input type="hidden" id="<?php echo $this->get_field_id('image_url'); ?>" name="<?php echo $this->get_field_name('image_url'); ?>" value="<?php echo $image_url; ?>" />
		</div>
		<!-- new window -->
		<?php
			$checked = '';
			if($new_window === 'true'){ $checked = ' checked="checked"'; }
		?>
		<p>
		<label for="<?php echo $this->get_field_id('new_window'); ?>"><?php _e('Open Link In New Window', 'hihat-ad-widget'); ?><br />
		<input type="checkbox"  id="<?php echo $this->get_field_id('new_window'); ?>" name="<?php echo $this->get_field_name('new_window'); ?>" <?php echo $checked; ?>></label>
		</p>
		<p>This widget is used to display custom ad content. All fields are optional.</p>

		<?php
	}

	//widget update
	function update($new_instance, $old_instance){

		$instance = $old_instance;

		// Fields
		$instance['title'] = $new_instance['title'];
		$instance['desc'] = strip_tags($new_instance['desc']);
		$instance['target_url'] = strip_tags($new_instance['target_url']);
		$instance['alt_text'] = strip_tags($new_instance['alt_text']);
		$instance['image_url'] = strip_tags($new_instance['image_url']);
		$instance['attachment_id'] = strip_tags($new_instance['attachment_id']);
		$instance['new_window'] = $new_instance['new_window'] ? 'true' : 'false';

		return $instance;

	}

	//widget display
	function widget($args, $instance){

		// wp_reset_postdata();

		global $post;
		extract( $args );

		// get the widget values
		$title = $instance['title'];
		$desc = $instance['desc'];
		$target_url = $instance['target_url'];
		$alt_text = $instance['alt_text'];
		$image_url = $instance['image_url'];
		$attachment_id = $instance['attachment_id'];
		$new_window = ($instance['new_window'] === 'true') ? 'true' : 'false';

		echo $before_widget;

		if(isset($title) && $title != ''){
			//output the widget if we have an image url
			//title
			if(isset($title) && (isset($target_url) && $target_url != '')) echo $before_title . "<a href='$target_url' " . (($new_window === 'true') ? " target='_blank'" : '') . ">" . $title . "</a>" . $after_title;
			else echo $before_title . $title . $after_title;
			//desc
			if(isset($desc) && $desc != ''){
				if(isset($target_url) && $target_url != '') echo "<a href='$target_url' " . (($new_window === 'true') ? " target='_blank'" : '') . ">" . wpautop($desc) . "</a>";
				else echo wpautop($desc);
			}
			//image
			if(isset($image_url) && $image_url != ''){
				if(isset($target_url) && $target_url != '') echo "<a href='$target_url' " . (($new_window === 'true') ? " target='_blank'" : '') . "><img src='$image_url' width='100%' height='auto'" . ((isset($alt_text) && $alt_text != '')  ? " alt='$alt_text'" : '') . " /></a>";
				else echo "<img src='$image_url' width='100%' height='auto'" . ((isset($alt_text) && $alt_text != '')  ? " alt='$alt_text'" : '') . " />";
			}
		}

		echo $after_widget;

	}

	/**
	 * Render the image html output.
	 *
	 * @param array $instance
	 * @param bool $include_link will only render the link if this is set to true. Otherwise link is ignored.
	 * @return string image html
	 */
	private function get_image_html( $instance, $include_link = true ) {

		// If there is an image_url, use it to render the image. Eventually we should kill this and simply rely on attachment_ids.
		if ( !empty( $instance['image_url'] ) ) {
			// If all we have is an image src url we can still render an image.
			$attr['src'] = $instance['image_url'];
			$attr['alt'] = $instance['alt_text'];
			$attr = array_map( 'esc_attr', $attr );

			// $hwstring = image_hwstring( $instance['width'], $instance['height'] );
			$hwstring = 'width="100%" height="auto" ';
			$output .= rtrim("<img $hwstring");
			foreach ( $attr as $name => $value ) {
				$output .= sprintf( ' %s="%s"', $name, $value );
			}
			$output .= ' />';
		} elseif( abs( $instance['attachment_id'] ) > 0 ) {
			$output .= wp_get_attachment_image($instance['attachment_id'], $size, false, $attr);
		}

		if ( $include_link && !empty( $instance['link'] ) ) {
			$output .= '</a>';
		}

		return $output;
	}

	/**
	 * Assesses the image size in case it has not been set or in case there is a mismatch.
	 *
	 * @param $instance
	 * @return array|string
	 */
	private function get_image_size( $instance ) {
		if ( !empty( $instance['size'] ) && $instance['size'] != self::CUSTOM_IMAGE_SIZE_SLUG ) {
			$size = $instance['size'];
		} elseif ( isset( $instance['width'] ) && is_numeric($instance['width']) && isset( $instance['height'] ) && is_numeric($instance['height']) ) {
			//$size = array(abs($instance['width']),abs($instance['height']));
			$size = array($instance['width'],$instance['height']);
		} else {
			$size = 'full';
		}
		return $size;
	}

}

add_action('widgets_init', create_function('', 'return register_widget("Hihat_Ad_Widget_Widget");'));




/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-plugin-name-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Hihat_Ad_Widget
 * @author  Your Name <email@example.com>
 */
class Hihat_Ad_Widget {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'hihat-ad-widget';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// load plugin text domain
		// add_action( 'init', array( $this, 'load_plugin_textdomain' ) );
		// enquue scripts
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		if ( $this->use_old_uploader() ) {
			require_once( 'lib/ImageWidgetDeprecated.php' );
			new ImageWidgetDeprecated( $this );
		} else {
			add_action( 'sidebar_admin_setup', array( $this, 'admin_setup' ) );
		}
	}

	/**
	 * Test to see if this version of WordPress supports the new image manager.
	 * @return bool true if the current version of WordPress does NOT support the current image management tech.
	 */
	private function use_old_uploader() {
		if ( defined( 'IMAGE_WIDGET_COMPATIBILITY_TEST' ) ) return true;
		return !function_exists('wp_enqueue_media');
	}

	/**
	 * Enqueue all the javascript.
	 */
	function admin_setup() {
		wp_enqueue_media();
		wp_enqueue_script( 'tribe-image-widget', plugins_url('/js/image-widget.js', __FILE__), array( 'jquery', 'media-upload', 'media-views' ), self::VERSION );

		wp_localize_script( 'tribe-image-widget', 'TribeImageWidget', array(
			'frame_title' => __( 'Select an Image', 'image_widget' ),
			'button_title' => __( 'Insert Into Widget', 'image_widget' ),
		) );
	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();

					restore_current_blog();
				}

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

					restore_current_blog();

				}

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}

	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {

		//debug
		ob_start();

	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {

	}

	// /**
	//  * Load the plugin text domain for translation.
	//  *
	//  * @since    1.0.0
	//  */
	// public function load_plugin_textdomain() {

	// 	$domain = $this->plugin_slug;
	// 	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );
	// 	load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
	// 	load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	// }

	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style('thickbox');
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}

}