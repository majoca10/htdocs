<?php
/*
Plugin Name: WP Coming Soon - By Miriam de Paula
Plugin URI: http://wpmidia.com.br/laboratorio/wp-coming-soon/
Description: This plugin adds a countdown clock in the Coming Soon page... Nothing more! 
Version: 1.2.1
Author: Miriam de Paula
Author Email: wpmidia@gmail.com
Author URI: http://wpmidia.com.br/

License:

  Copyright 2012 - 2013 Miriam de Paula (wpmidia@gmail.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

register_activation_hook( __FILE__, 'install_wp_coming_soon' );

/**
* Runs when the plugin is activated
*/  
function install_wp_coming_soon() {
  // do not generate any output here
}

//Hook up to the init action
add_action( 'init', 'init_wp_coming_soon' );
/**
* Runs when the plugin is initialized
*/

function init_wp_coming_soon() {
  
  add_action('admin_init', 'settings_init');	  
  
  // Load JavaScript and stylesheets
  register_scripts_and_styles();	
  
  // Register the shortcode [wp_coming_soon_shortcode]
  add_shortcode('wp_coming_soon', 'wp_coming_soon_shortcode');
  
  add_action('wp_footer', 'frontend_add_to_footer');  
  add_action('admin_footer', 'backend_add_to_footer');	
  add_action('admin_menu', 'wp_coming_soon_add_admin_menu');
	
  // Setup localization
  load_plugin_textdomain( 'wp_coming_soon', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
	
}

function register_scripts_and_styles() {
	$lang = get_option('wp_coming_soon_language');
	
	if ( is_admin() ) {
		
		wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-datepicker');
		/*wp_deregister_script( 'jquery-ui-core' );
		wp_register_script('jquery-ui-core', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js', false, '1.8.16');
		wp_enqueue_script('jquery-ui-core');*/
		//css do jquery ui
		wp_enqueue_style('jquery-ui-css', 'http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css');
		
	} else {		
		wp_register_script( 'wp_coming_soon-script', plugins_url('/js/jquery.countdown.js', __FILE__) , array('jquery') );
		wp_register_style( 'wp_coming_soon-style', plugins_url('/css/countdown-style.css', __FILE__) );
		wp_enqueue_script( 'wp_coming_soon-script' );
		wp_enqueue_style( 'wp_coming_soon-style' );
		
		if( !empty($lang) && isset($lang) ){			
			wp_register_script( 'wp_coming_soon-script-'. $lang, plugins_url('/js/jquery.countdown-'. $lang .'.js', __FILE__) , array('jquery') );
			wp_enqueue_script( 'wp_coming_soon-script-'. $lang );
		}

	} // end if/else
} // end register_scripts_and_styles

function backend_add_to_footer(){
	
	$l = get_locale(); //pt_BR
?>
	
    <script type="text/javascript">
		jQuery( function($){
			var locale = '<?php echo $l ?>';
			var format;
			
			if( locale == 'pt_BR' )
				format = 'dd/mm/yy';
			else
				format = 'yy/mm/dd';
							
			$('.datepicker').datepicker({
				  dateFormat : format
			});
			
		});
	</script>

<?php }
	
function frontend_add_to_footer(){ ?>
		
	<script type="text/javascript">
		<?php 			
			$launchDate = get_option( 'wp_coming_soon_launch_date' );
			$data = date('Y-m-d', strtotime(implode('-', explode('/', $launchDate)))); 
			$lang = get_option('wp_coming_soon_language'); 
			$gmt_offset = get_option('gmt_offset'); 
		?>
		var Countdown_Settings = {
			launchDate_year:  <?php echo date('Y', strtotime( $data ) ); ?>,
			launchDate_month: <?php echo date('n', strtotime( $data ) ); ?>,
			launchDate_day:   <?php echo date('j', strtotime( $data ) ); ?>,
			clang: '<?php echo $lang?>',
			gmt_offset: <?php echo $gmt_offset?>	  
		};
		
		(function($) {
		  Countdown = {
			init: function() {
		
			  $('.countdown').countdown({
				until: new Date( Countdown_Settings.launchDate_year, Countdown_Settings.launchDate_month - 1, Countdown_Settings.launchDate_day ),
				timezone: Countdown_Settings.gmt_offset,
				layout: '<div class="digit"><div id="days"><span></span>{dn}</div> <div class="digit_label">{dl}</div></div>' +
				 		'<div class="digit"><div id="hours"><span></span>{hn}</div> <div class="digit_label">{hl}</div></div>' +
						'<div class="digit"><div id="minutes"><span></span>{mn}</div> <div class="digit_label">{ml}</div></div>' +
						'<div class="digit"><div id="seconds"><span></span>{sn}</div> <div class="digit_label">{sl}</div></div>'
			  });
			  
			  if( Countdown_Settings.clang != '' || Countdown_Settings.clang != '0' ){
			  	$.countdown.regional[Countdown_Settings.clang]
			  }
			}
		  }
		})(jQuery);
		
		jQuery(document).ready(function() { 
			Countdown.init();
		});
    </script>
        
<?php }	

function get_countdown(){
	
	$html = '<div class="wp-coming-soon-box">';
	
	if( get_option('wp_coming_soon_default_message') ){
		$html.= '<div class="default_message">'.get_option('wp_coming_soon_default_message').'</div>';			
	}
	
	$html.= '<div class="countdown"></div>';
	$html.=	'</div>';
	
	echo apply_filters( 'get_countdown', $html );
}

function wp_coming_soon_shortcode($atts){
	//prints the countdown into shortcode .....
	get_countdown();	
}

/* options page */
function settings_init() {
	global $wp_coming_soon_options;	

	$wp_coming_soon_options = array (    	
		  array( 
			  'name' => __('Launch Date', 'wp_coming_soon'),
			  'desc' => __('Define the launch date.', 'wp_coming_soon'),
			  'id' => 'wp_coming_soon_launch_date',
			  'type' => 'date'
		  ),        
		  array(
			  'name' => __('Select your language', 'wp_coming_soon'),
			  'desd' => '',
			  'id' => 'wp_coming_soon_language',
			  'type' => 'select',
			  'options' => array(
					  '0' => '-- Select --',
					  'al' => 'Albanian',
					  'ar' => 'Arabic',
					  'hy' => 'Armenian',
					  'bn' => 'Bengali/Bangla',
					  'bs' => 'Bosnian (Bosanski)',
					  'bg' => 'Bulgarian',
					  'my' => 'Burmese',
					  'ca' =>	'Catalan (Català)',
					  'zh-CN' => 'Chinese/Simplified',
					  'zh-TW' => 'Chinese/Traditional',
					  'hr' => 'Croatian (Hrvatski jezik)',
					  'cs' => 'Czech',
					  'da' => 'Danish (Dansk)',
					  'nl' => 'Dutch (Nederlands)',
					  'en' => 'English',
					  'et' => 'Estonian (eesti keel)',
					  'fa' => 'Farsi/Persian',
					  'fi' => 'Finnish (suomi)',
					  'fr' => 'French (Français)',
					  'gl' => 'Galician (Galego)',
					  'de' => 'German (Deutsch)',
					  'el' => 'Greek',
					  'gu' => 'Gujarati',
					  'he' => 'Hebrew',
					  'hu' => 'Hungarian (Magyar)',
					  'id' => 'Indonesian (Bahasa Indonesia)',
					  'it' => 'Italian (Italiano)',
					  'ja' => 'Japanese',
					  'kn' => 'Kannada',
					  'ko' => 'Korean',
					  'lv' => 'Latvian',
					  'lt' => 'Lithuanian',
					  'ml' => 'Malayalam',
					  'ms' => 'Malaysian (Bahasa Melayu)',
					  'nb' => 'Norwegian (Bokmål)',
					  'pl' => 'Polish (Polski)',
					  'pt-BR' => 'Portuguese (Brazilian)',
					  'pt' => 'Portuguese (Portugal)',
					  'ro' => 'Romanian',
					  'ru' => 'Russian',
					  'sr' => 'Serbian',
					  'sr-SR' => 'Serbian (srpski jezik)',
					  'sk' => 'Slovak',
					  'sl' => 'Slovenian',
					  'es' => 'Spanish (Español)',
					  'sv' => 'Swedish (Svenska)',
					  'th' => 'Thai',
					  'tr' => 'Turkish (Türkçe)',
					  'uk' => 'Ukranian',
					  'uz' => 'Uzbek',
					  'vi' => 'Vietnamese',
					  'cy' => 'Welsh'
			  ),
			  'std' => ''		
		  ),   
		  array( 
			  'name' => __('Default message until launch', 'wp_coming_soon'),
			  'desc' => __('Define the message you will show in the home. You can use HTML tags here!', 'wp_coming_soon'),
			  'id' => 'wp_coming_soon_default_message',
			  'type' => 'textarea',
			  'std' => ''
		  )
	);
	
	foreach( $wp_coming_soon_options as $option ){		
		//register settings
		register_setting( 'wp-coming-soon-settings-group', $option['id'] );
		
	}
}

function wp_coming_soon_add_admin_menu() {
	
	add_options_page(__('WP Coming Soon Options', 'wp_coming_soon'), __('WP Coming Soon Options', 'wp_coming_soon'), 'manage_options', basename(__FILE__), 'wp_coming_soon_admin');
}	


function wp_coming_soon_admin() {
	global $wp_coming_soon_options;
		
   	echo '<div class="wrap">';
	echo '	<div class="icon32" id="icon-options-general"><br></div>';
	echo '	<h2>'. __('WP Coming Soon Options', 'wp_coming_soon') .'</h2>';
   	echo '  <form method="post" action="options.php">';
            
	settings_fields( 'wp-coming-soon-settings-group' );
              
    echo '	<table class="form-table">';
    echo '		<tbody>';   
                  	
	foreach ($wp_coming_soon_options as $value) {
							
		echo '	<tr valign="top">';
		switch ( $value['type'] ) {
			case 'text':
				echo '<th scope="row"><label for="' . $value['id'] . '">' . $value['name'] . '</label></th>';
                echo '<td><input class="regular-text" type="text" name="' . $value['id'] . '" value="' . get_option($value['id']) .'" />'.($value['desc']? '<p>'.$value['desc'].'</p>' : '').'</td>';                    
			break; 
			
			case 'select':
				echo '<th scope="row"><label for="' . $value['id'] . '">' . $value['name'] . '</label></th>';
				echo '<td><select name="' . $value['id'] . '">';
				foreach ($value['options'] as $key => $option) {
					echo '	<option value="'.$key.'" ' . selected(get_option($value['id']), $key, false) . '>'.$option.'</option>';
				}
				echo '</select></td>';
				
			break;
			
			case 'textarea':
	           	echo '<th scope="row"><label for="' . $value['id'] . '">' . $value['name'] . '</label></th>';
	            echo '<td><textarea name="' . $value['id'] . '" rows="5" cols="40">' . get_option($value['id']) . '</textarea>'.($value['desc']? '<p>'.$value['desc'].'</p>' : '').'</td>';
    		break;
			
			case 'date':			
				echo '<th scope="row"><label for="' . $value['id'] . '">' . $value['name'] . '</label></th>';
				echo '<td><input class="datepicker" type="text" name="' . $value['id'] . '" value="' . get_option($value['id']) . '" />'.($value['desc']? '<p>'.$value['desc'].'</p>' : '').'</td>';
			break;
		}
		echo '	</tr>';

	}
	
	echo '		</tbody>';                  
	echo '	</table>';
	
	echo '<p class="submit"><input type="submit" class="button-primary" value="' . __('Save Changes') . '" /></p>';

	echo '</form>';
	echo '	</div>';
	
	echo '<div id="how-to-use">';
	echo '	<h3>' . __('Basic usage:', 'wp_coming_soon') . '</h3>';
	echo '	<p>' .__('Put the code below where you want to display the countdown clock. If you want to use the countdown timer within a page or page template, you can use the shortcode <strong>[wp_coming_soon]</strong>.', 'wp_coming_soon'). '</p>';
	echo '	<code>if ( function_exists(\'get_countdown\')) get_countdown();</code> ';
	echo '</div>';
}	

// A simple Widget
class WP_Coming_Soon_Widget extends WP_Widget {
	
	function __construct() {
		
		load_plugin_textdomain( 'wp_coming_soon', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );
		
		parent::WP_Widget( /* Base ID */'wp_coming_soon_widget', /* Name */'WP Coming Soon Widget', array( 'description' => __('Adds a countdown counter in sidebar.', 'wp_coming_soon') ) );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		//$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		
		get_countdown();

		echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new, $old ) {
		$instance = $old;
		//$instance['title'] = trim($new['title']);

		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) { 
		
		$launchDate = get_option( 'wp_coming_soon_launch_date' );
		if( !empty($launchDate) )			
			printf( __('The launch date is: %1$s', 'wp_coming_soon'), $launchDate );
			
		else	
			_e('<p>Set the Launch Date on the settings page.</p>', 'wp_coming_soon');

	}

}  
/* TODO
add_action('widgets_init', create_function('', 'register_widget("WP_Coming_Soon_Widget");'));
*/