<?php
/*
Plugin Name: Slider
Version: 1.0
Plugin URI:
Description:
Author: Marine Bourgeois
Author URI:
text Domain: slider
*/

function eemi_oop_init() {
	load_plugin_textdomain(
		'slider',
		false,
		dirname( plugin_basename( __FILE__ ) ) . '/languages'
	);
}

add_action( 'plugins_loaded', 'eemi_oop_init' );

add_action('init', 'slider_init');

function slider_init(){

	$labels = array(
		'name' => 'Slide',
		'singular_name' => 'Slide',
		'add_new' => __('Ajouter un slide', 'slider'),
		'add_new_item' => __('Editer un Slide','slider'),
		'edit_item' => __('Modifier un slide', 'slider'),
		'new_item' => __('Nouvelle slide', 'slider'),
		'view_item' => __('Voir l\' Slide', 'slider'),
		'search_items' =>__('Recherche un slide', 'slider'),
		'not_found' => __('Aucun Slide', 'slider'),
		'not_found_in_trash' => __('Auncun slide dans la corbeille', 'slider'),
		'parent_item_colon' => '',
		'menu_name' => 'Slides',
		'mounth' => 3,
		);

register_post_type('slide', array(
	'public' => true,
	'publicity_queryable' => false,
	'labels' => $labels,
	'capability_type' => 'post',
	'supports' => array('title', 'thumbnail'),


));

add_image_size('slider', 1000, 300, true);

}


// Affiche le slider
function add_script(){
	wp_enqueue_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js', null,true);
	wp_enqueue_script('caroufredsel', plugins_url().'/plugin-slider/js/jquery.carouFredSel-6.0.0.js', array('jquery'), null,true);
	wp_enqueue_script('main', plugins_url().'/plugin-slider/js/main.js', array('jquery'), null,true);
}

add_action( 'wp_enqueue_scripts', 'add_script' );

function insert_css() {
    // Ajout du css dans le Header
    wp_register_style( 'slider',  esc_url( plugins_url('css/plugin-slider.css', __FILE__ )));
    wp_enqueue_style( 'slider' );
}
add_action('wp_enqueue_scripts', 'insert_css');



function affiche_slider($limit = 10){
	$slides = new WP_query("post_type=slide&posts_per_page=".$limit,array('jquery'), null, false);
	echo '<div id="plugin-slider">';
	



		while ($slides->have_posts()){
			$slides->the_post();
		
		global $post;	

		the_post_thumbnail('slider', array('style' => 'width: 1000px!important;'));
		}
		echo'</div>';
}

add_action('wp_head', 'affiche_slider');


