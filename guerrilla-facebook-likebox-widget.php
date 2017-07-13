<?php
/*
Plugin Name: Guerrilla's Facebook Like Box Widget
Plugin URI: http://madebyguerrilla.com
Description: This is a plugin that adds a widget you can use to display a Facebook like box in the sidebar of your WordPress powered website.
Version: 1.1
Author: Mike Smith
Author URI: http://www.madebyguerrilla.com
*/

/*  Copyright 2012-2016  Mike Smith (email : hi@madebyguerrilla.com)

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

class FacebookLikeBoxWidget extends WP_Widget
{
    function FacebookLikeBoxWidget(){
		$widget_ops = array('description' => 'Displays A Facebook Like Box');
		$control_ops = array('width' => 300, 'height' => 300);
		parent::WP_Widget(false,$name='Facebook Like Box Widget',$widget_ops,$control_ops);
    }

  /* Displays the Widget in the front-end */
    function widget($args, $instance){
		extract($args);
		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);
		$FacebookID = empty($instance['FacebookID']) ? '' : $instance['FacebookID'];
		$FacebookAPP = empty($instance['FacebookAPP']) ? '' : $instance['FacebookAPP'];
		$Width = empty($instance['Width']) ? '' : $instance['Width'];
		$Height = empty($instance['Height']) ? '' : $instance['Height'];
		$ShowCoverImage = empty($instance['ShowCoverImage']) ? '' : $instance['ShowCoverImage'];
		$SmallHeader = empty($instance['SmallHeader']) ? '' : $instance['SmallHeader'];
		$ShowFaces = empty($instance['ShowFaces']) ? '' : $instance['ShowFaces'];

		echo $before_widget;

		if ( $title )
		echo $before_title . $title . $after_title;
?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=<?php if( $FacebookAPP == '') { echo''; } else { echo($FacebookAPP); }; ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-page" data-href="<?php echo($FacebookID); ?>" data-tabs="timeline" data-width="<?php echo($Width); ?>" data-height="<?php echo($Height); ?>" data-small-header="<?php if( $SmallHeader == 'on') { echo'true'; } else { echo'false'; }; ?>" data-adapt-container-width="true" data-hide-cover="<?php if( $ShowCoverImage == 'on') { echo'true'; } else { echo'false'; }; ?>" data-show-facepile="<?php if( $ShowFaces == 'on') { echo'true'; } else { echo'false'; }; ?>"><div class="fb-xfbml-parse-ignore"><blockquote cite="<?php echo($FacebookID); ?>"><a href="<?php echo($FacebookID); ?>"><?php echo($title); ?></a></blockquote></div></div>

<?php
		echo $after_widget;
	}

  /*Saves the settings. */
    function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = stripslashes($new_instance['title']);
		$instance['FacebookID'] = stripslashes($new_instance['FacebookID']);
		$instance['FacebookAPP'] = stripslashes($new_instance['FacebookAPP']);
		$instance['Width'] = stripslashes($new_instance['Width']);
		$instance['Height'] = stripslashes($new_instance['Height']);
		$instance['ShowCoverImage'] = stripslashes($new_instance['ShowCoverImage']);
		$instance['SmallHeader'] = stripslashes($new_instance['SmallHeader']);
		$instance['ShowFaces'] = stripslashes($new_instance['ShowFaces']);

		return $instance;
	}

  /*Creates the form for the widget in the back-end. */
    function form($instance){
		//Defaults
		$instance = wp_parse_args( (array) $instance,
			array(
				'title'=>'',
				'FacebookID'=>'',
				'FacebookAPP'=>'',
				'Width'=>'',
				'Height'=>'',
				'ShowCoverImage'=>'',
				'SmallHeader'=>'',
				'ShowFaces'=>'on'
			)
		);

		$title = htmlspecialchars($instance['title']);
		$FacebookID = htmlspecialchars($instance['FacebookID']);
		$FacebookAPP = htmlspecialchars($instance['FacebookAPP']);
		$Width = htmlspecialchars($instance['Width']);
		$Height = htmlspecialchars($instance['Height']);
		$ShowCoverImage = htmlspecialchars($instance['ShowCoverImage']);
		$SmallHeader = htmlspecialchars($instance['SmallHeader']);
		$ShowFaces = htmlspecialchars($instance['ShowFaces']);

		# Title
		echo '<p><label for="' . $this->get_field_id('title') . '">' . 'Title:' . '</label><input class="widefat" id="' . $this->get_field_id('title') . '" name="' . $this->get_field_name('title') . '" type="text" value="' . $title . '" /></p>';
		# Facebook URL
		echo '<p><label for="' . $this->get_field_id('FacebookID') . '">' . 'Facebook URL (full http://):' . '</label><input class="widefat" id="' . $this->get_field_id('FacebookID') . '" name="' . $this->get_field_name('FacebookID') . '" type="text" value="' . $FacebookID . '" /></p>';
		# Facebook APP ID
		echo '<p><label for="' . $this->get_field_id('FacebookAPP') . '">' . 'Facebook APP ID (<a href="https://developers.facebook.com/apps" target="_blank">create app</a>):' . '</label><input class="widefat" id="' . $this->get_field_id('FacebookAPP') . '" name="' . $this->get_field_name('FacebookAPP') . '" type="text" value="' . $FacebookAPP . '" /></p>';

	{ ?>

	    <p><input class="checkbox" type="checkbox" <?php checked($ShowCoverImage, 'on'); ?> id="<?php echo $ShowCoverImage; ?>" name="<?php echo $this->get_field_name('ShowCoverImage'); ?>" /> <label for="<?php echo $ShowCoverImage; ?>">Hide Cover Image?</label></p>
			
	    <p><input class="checkbox" type="checkbox" <?php checked($SmallHeader, 'on'); ?> id="<?php echo $SmallHeader; ?>" name="<?php echo $this->get_field_name('SmallHeader'); ?>" /> <label for="<?php echo $SmallHeader; ?>">Make Header Small?</label></p>
			
	    <p><input class="checkbox" type="checkbox" <?php checked($ShowFaces, 'on'); ?> id="<?php echo $ShowFaces; ?>" name="<?php echo $this->get_field_name('ShowFaces'); ?>" /> <label for="<?php echo $ShowFaces; ?>">Display User Faces?</label></p>
						
	<?php }

		# Width
		echo '<p><label for="' . $this->get_field_id('Width') . '">' . 'Width (ex: 250):' . '</label><input class="widefat" id="' . $this->get_field_id('Width') . '" name="' . $this->get_field_name('Width') . '" type="text" value="' . $Width . '" /></p>';
		# Height
		echo '<p><label for="' . $this->get_field_id('Height') . '">' . 'Height (ex: 300):' . '</label><input class="widefat" id="' . $this->get_field_id('Height') . '" name="' . $this->get_field_name('Height') . '" type="text" value="' . $Height . '" /></p>';


	}

}// end FacebookLikeBoxWidget class

function FacebookLikeBoxWidgetInit() {
  register_widget('FacebookLikeBoxWidget');
}

add_action('widgets_init', 'FacebookLikeBoxWidgetInit');

?>