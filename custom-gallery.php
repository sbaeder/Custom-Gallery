<?php
/*
Plugin Name: Custom Gallery (BFM)
Plugin URI: 
Description: Declares a plugin that will create a custom post type
Version: 1.5
Author: BFM - original as a gallery; Scott Baeder - as just a plug-in that is more simplistic.
Author URI: 
License: GPLv2
*/

/*  NOTES - 3/26/15
This relies on all the other things BFM added to the EQL DB (using acf from the original theme).
It appears that the 5 link version is broken, and I (Scott) heavily modified the display of the short-code
so that this would at least do something for all the older versions created.

This content and plug-in should be phased out...

*/
add_action('init', 'theme_posttype_init');
function theme_posttype_init() {
	$labels = array(
		'name'               => _x('Custom Galleries', 'post type general name'),
		'singular_name'      => _x('Custom Gallery', 'post type singular name'),
		'menu_name'          => _x('Custom Gallery', 'admin menu'),
		'name_admin_bar'     => _x('Custom Gallery', 'add new on admin bar'),
		'add_new'            => _x('Add New', 'custom-gallery'),
		'add_new_item'       => __('Add New Custom Gallery'),
		'new_item'           => __('New Custom Gallery'),
		'edit_item'          => __('Edit Custom Gallery'),
		'view_item'          => __('View Custom Gallery'),
		'all_items'          => __('All Custom Galleries'),
		'search_items'       => __('Search Custom Galleries'),
		'parent_item_colon'  => __('Parent Custom Gallery:'),
		'not_found'          => __('No custom galleries found.'),
		'not_found_in_trash' => __('No custom galleries found in Trash.')
	);
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array('slug' => 'custom-galleries'),
		'exclude_from_search'=> true,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields')
	);
	register_post_type('custom-gallery', $args);
}


function image_gallery_func($atts) {
	
	$atts = shortcode_atts(array(
		'id' => 0,
	), $atts);
	$id = intval($atts['id']);
	global $wpdb;
	$return = '';
	if($id > 0) {
		$type = get_field('type', $id);
		$image = get_field('image', $id);
		if(!$image){
			$theimage = $wpdb->get_row("SELECT * FROM $wpdb->posts WHERE post_title = 'custom-gallery-placeholder'");
			if($theimage){
				$image = $theimage->ID;
			}
		}
		if($type && $image){
			$title = get_field('title', $id);
			
			$image_1 = get_field('image_1', $id);
			$text_1 = get_field('text_1', $id);
				if($text_1){ $text_1 = strip_tags($text_1, '<br><a><span><strong><em>'); }
			$price_1 = get_field('price_1', $id);
			$link_1 = get_field('link_1', $id);
			
			$image_2 = get_field('image_2', $id);
			$text_2 = get_field('text_2', $id);
				if($text_2){ $text_2 = strip_tags($text_2, '<br><a><span><strong><em>'); }
			$price_2 = get_field('price_2', $id);
			$link_2 = get_field('link_2', $id);
			
			if(($type == '3-img') || ($type == '4-img') || (type == '5-img')){
				$image_3 = get_field('image_3', $id);
				$text_3 = get_field('text_3', $id);
					if($text_3){ $text_3 = strip_tags($text_3, '<br><a><span><strong><em>'); }
				$link_3 = get_field('link_3', $id);
				$price_3 = get_field('price_3', $id);
			}
			if(($type == '4-img') || ($type == '5-img')){
				$image_4 = get_field('image_4', $id);
				$text_4 = get_field('text_4', $id);
					if($text_4){ $text_4 = strip_tags($text_4, '<br><a><span><strong><em>'); }
				$link_4 = get_field('link_4', $id);
				$price_4 = get_field('price_4', $id);
			} 
			if($type == '5-img'){
				$image_5 = get_field('image_5', $id);
				$text_5 = get_field('text_5', $id);
					if($text_5){ $text_5 = strip_tags($text_5, '<br><a><span><strong><em>'); }
				$link_5 = get_field('link_5', $id);
				$price_5 = get_field('price_5', $id);
			}
			$return .= '<a href="#">'. wp_get_attachment_image($image, 'big-size') .'</a><div id="custom-gallery-'. $id . '" class=center >';

				if($image_1 || $text_1){
					$return .= '<br><br>';
					if($image_1){
						if($link_1){
							$return .= '<a target="_blank" href="'. $link_1 .'">';
						}
						$return .= wp_get_attachment_image($image_1, array(50,50), false);
						if($link_1){
							$return .= '</a>';
						}
					}
					if($text_1){
						$return .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>    '. $text_1 .'</b><br>';
					}
					if($price_1){
						$return .= '<p class="price">' . $price_1 . '</p>';
					}
				}

				if($image_2 || $text_2){
					$return .= '<br><br>';
					if($image_2){
						if($link_2){
							$return .= '<a target="_blank" href="'. $link_2 .'">';
						}
						$return .= wp_get_attachment_image($image_2, array(50,50), false);
						if($link_2){
							$return .= '</a>';
						}
					}
					if($text_2){
						$return .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'. $text_2 .'</b><br>';
					}
					if($price_2){
						$return .= '<p class="price">' . $price_2 . '</p>';
					}
				}

			if(($type == '3-img') || ($type == '4-img') || (type == '5-img')){
				$return .= '<br><br>';
				if($image_3 || $text_3){
					if($image_3){
						if($link_3){
							$return .= '<a target="_blank" href="'. $link_3 .'">';
						}
						$return .= wp_get_attachment_image($image_3, array(50,50), false);
						if($link_3){
							$return .= '</a>';
						}
					}
					if($text_3){
						$return .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'. $text_3 .'</b><br>';
					}
					if($price_3){
						$return .= '<p class="price">' . $price_3 . '</p>';
					}
				}
			}
			if(($type == '4-img') || (type == '5-img')){
				$return .= '<br><br>';
				if($image_4 || $text_4){
					if($image_4){
						if($link_4){
							$return .= '<a target="_blank" href="'. $link_4 .'">';
						}
						$return .= wp_get_attachment_image($image_4, array(50,50), false);
						if($link_4){
							$return .= '</a>';
						}
					}
					if($text_4){
						$return .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'. $text_4 .'</b><br>';
					}
					if($price_4){
						$return .= '<p class="price">' . $price_4 . '</p>';
					}
				}
			}
			if(type == '5-img'){
				$return .= '<br><br>';
				if($image_5 || $text_5){
					if($image_5){
						if($link_5){
							$return .= '<a target="_blank" href="'. $link_5 .'">';
						}
						$return .= wp_get_attachment_image($image_5, array(50,50), false);
						if($link_5){
							$return .= '</a>';
						}
					}
					if($text_5){
						$return .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'. $text_5 .'</b><br>';
					}
					if($price_5){
						$return .= '<p class="price">' . $price_5 . '</p>';
					}
				}
			}

			$return .= '</div>';
		}
	}
	return $return;
}
add_shortcode('custom-gallery', 'image_gallery_func');




add_action( 'admin_init', 'my_admin' );


function my_admin() {
add_meta_box( 'custom_gallery_meta_box',
'Movie Review Details',
'display_custom_gallery_meta_box',
'custom_gallerys', 'normal', 'high' );
}

function display_custom_gallery_meta_box( $custom_gallery ) {
// Retrieve current name of the Director and Movie Rating based on review ID
$movie_director =
esc_html( get_post_meta( $custom_gallery->ID,
'movie_director', true ) );
$movie_rating =
intval( get_post_meta( $custom_gallery->ID,
'movie_rating', true ) );
?>
<table>
<tr>
<td style="width: 100%">Movie Director</td>
<td><input type="text" size="80"
name="custom_gallery_director_name"
value="<?php echo $movie_director; ?>" /></td>
</tr>
<tr>
<td style="width: 150px">Movie Rating</td>
<td>
<select style="width: 100px"
name="custom_gallery_rating">
<?php
// Generate all items of drop-down list
for ( $rating = 5; $rating >= 1; $rating -- ) {
?>
<option value="<?php echo $rating; ?>"
<?php echo selected( $rating,
$movie_rating ); ?>>
<?php echo $rating; ?> stars
<?php } ?>
</select>
</td>
</tr>
</table>
<?php }


add_action( 'save_post',
'add_custom_gallery_fields', 10, 2 );


function add_custom_gallery_fields( $custom_gallery_id,
$custom_gallery ) {
// Check post type for movie reviews
if ( $custom_gallery->post_type == 'custom_gallerys' ) {
// Store data in post meta table if present in post data
if ( isset( $_POST['custom_gallery_director_name'] ) &&
$_POST['custom_gallery_director_name'] != '' ) {
update_post_meta( $custom_gallery_id, 'movie_director',
$_POST['custom_gallery_director_name'] );
}
if ( isset( $_POST['custom_gallery_rating'] ) &&
$_POST['custom_gallery_rating'] != '' ) {
update_post_meta( $custom_gallery_id, 'movie_rating',
$_POST['custom_gallery_rating'] );
}
}
}


?>