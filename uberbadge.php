<?php
/****************************************************************************
Plugin Name: Uberspace Badge
Plugin URI: https://github.com/nalfion/Uberspace-Badge
Description: Adds a Uberspace Badge to you're sidebar.
Version: 0.1
Author: Daniel Ebbert
Author URI: http://nalf.eu
License: GPL2
****************************************************************************/
/*  Copyright 2012  Uberspace Badge  (email : d.ebbert@gmx.de)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

// This gets called at the plugins_loaded action
function widget_ubernaut_init() {
	
	// check for sidebar existance
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	// This saves options and prints the widget's config form.
	function widget_ubernaut_control() {
		$options = $newoptions = get_option('widget_ubernaut');
		if ( $_POST['ubernaut-submit'] ) {	
			$newoptions['image'] = strip_tags(stripslashes($_POST['ubernaut-image']));				
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_ubernaut', $options);
		}
	?>
				<p style="text-align:left;">
					<label for="ubernaut-image" style="line-height:25px;display:block;"><?php _e('Image:', 'widgets'); ?> 
						<select id="ubernaut-image" name="ubernaut-image">
							<option value="badge-white" <?php if ($options['image']=='badge-white') {echo "selected=\"selected\""; }?> >badge-white</option>
							<option value="badge-black" <?php if ($options['image']=='badge-black') {echo "selected=\"selected\""; }?> >badge-black</option>						
						</select>
					</label>					
				<input type="hidden" name="ubernaut-submit" id="ubernaut-submit" value="1" />				
				</p>
	<?php
	}		
	
		// This prints the widget
	function widget_ubernaut($args) {
		extract($args);
		$options = get_option('widget_ubernaut');
		$image = $options['image'];	
		
		// Creates widget configuration
		$text = '';
		$websiteUrl = 'https://uberspace.de';
		$imageUrl = '';
		
		switch ($image) {
			case 'badge-white':
					$imageUrl = get_bloginfo('wpurl') . '/wp-content/plugins/uberspace-badge/img/badge-white.png';
					break;
			case 'badge-black':
					$imageUrl = get_bloginfo('wpurl') . '/wp-content/plugins/uberspace-badge/img/badge-black.png';
					break;					
			default:
					$imageUrl = get_bloginfo('wpurl') . '/wp-content/plugins/uberspace-badge/img/badge-white.png';
					break;
		}
				
		

		// prints the widget.
		echo $before_widget;
		?>
			<!--ubernaut Widget-->
				<div style="text-align: center; font-size: small;">
								<a rel="uberspace_website" target="_blank" href="<?php echo $websiteUrl; ?>">
								<img alt="Uberspace Badge" border="0" src="<?php echo $imageUrl; ?>"/></a>
								</a>

				</div>
			<!--/ubernaut Widget-->
		<?php	 
			
		echo $after_widget;
	}
	
	// Tell Dynamic Sidebar about our new widget and its control
	register_sidebar_widget(array('Uberspace Badge', 'widgets'), 'widget_ubernaut');
	register_widget_control(array('Uberspace Badge', 'widgets'), 'widget_ubernaut_control');
}

// Delay plugin execution to ensure Dynamic Sidebar has a chance to load first
add_action('widgets_init', 'widget_ubernaut_init');
?>
