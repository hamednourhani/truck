<?php
/* truck Custom Post Type Example
This page walks you through creating 
a custom post type and taxonomies. You
can edit this one or copy the following code 
to create another one. 

I put this in a separate file so as to 
keep it organized. I find it easier to edit
and change things if they are concentrated
in their own file.

Developed by: Eddie Machado
URL: http://themble.com/truck/
*/

// Flush rewrite rules for custom post types
add_action( 'after_switch_theme', 'truck_flush_rewrite_rules' );

// Flush your rewrite rules
function truck_flush_rewrite_rules() {
	flush_rewrite_rules();
}

// let's create the function for the custom type
//function product_post_type() {
//	// creating (registering) the custom type
//	register_post_type( 'product', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
//		// let's now add all the options for this post type
//		array( 'labels' => array(
//			'name' => __( 'Product', 'truck' ), /* This is the Title of the Group */
//			'singular_name' => __( 'Product', 'truck' ), /* This is the individual type */
//			'all_items' => __( 'All Products', 'truck' ), /* the all items menu item */
//			'add_new' => __( 'Add New', 'truck' ), /* The add new menu item */
//			'add_new_item' => __( 'Add New Products', 'truck' ), /* Add New Display Title */
//			'edit' => __( 'Edit', 'truck' ), /* Edit Dialog */
//			'edit_item' => __( 'Edit Product', 'truck' ), /* Edit Display Title */
//			'new_item' => __( 'New Product', 'truck' ), /* New Display Title */
//			'view_item' => __( 'View Product', 'truck' ), /* View Display Title */
//			'search_items' => __( 'Search Products', 'truck' ), /* Search Custom Type Title */
//			'not_found' =>  __( 'Nothing found in the Database.', 'truck' ), /* This displays if there are no entries yet */
//			'not_found_in_trash' => __( 'Nothing found in Trash', 'truck' ), /* This displays if there is nothing in the trash */
//			'parent_item_colon' => ''
//			), /* end of arrays */
//			'description' => __( 'This is a Product', 'truck' ), /* Custom Type Description */
//			'public' => true,
//			'show_in_nav_menus' => true,
//			'publicly_queryable' => true,
//			'exclude_from_search' => false,
//			'show_ui' => true,
//			'query_var' => true,
//			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
//			'menu_icon' => get_stylesheet_directory_uri() . '/images/product-icon.png', /* the icon for the custom post type menu */
//			'rewrite'	=> array( 'slug' => 'product', 'with_front' => false ), /* you can specify its url slug */
//			'has_archive' => 'product', /* you can rename the slug here */
//			'capability_type' => 'post',
//			'hierarchical' => false,
//			/* the next one is important, it tells what's enabled in the post editor */
//			'supports' => array( 'title', 'editor', /*'author',*/ 'thumbnail', /*'excerpt','trackbacks', 'custom-fields','comments','revisions','sticky'*/)
//		) /* end of options */
//	); /* end of register post type */
//
//	/* this adds your post categories to your custom post type */
//	//register_taxonomy_for_object_type( 'category', 'tour' );
//	/* this adds your post tags to your custom post type */
//	//register_taxonomy_for_object_type( 'post_tag', 'tour' );
//
//}
//
//
//function pharmacy_post_type() {
//	// creating (registering) the custom type
//	register_post_type( 'pharmacy', /* (http://codex.wordpress.org/Function_Reference/register_post_type) */
//		// let's now add all the options for this post type
//		array( 'labels' => array(
//			'name' => __( 'pharmacy', 'truck' ), /* This is the Title of the Group */
//			'singular_name' => __( 'pharmacy', 'truck' ), /* This is the individual type */
//			'all_items' => __( 'All pharmacys', 'truck' ), /* the all items menu item */
//			'add_new' => __( 'Add New', 'truck' ), /* The add new menu item */
//			'add_new_item' => __( 'Add New pharmacy', 'truck' ), /* Add New Display Title */
//			'edit' => __( 'Edit', 'truck' ), /* Edit Dialog */
//			'edit_item' => __( 'Edit pharmacy', 'truck' ), /* Edit Display Title */
//			'new_item' => __( 'New pharmacy', 'truck' ), /* New Display Title */
//			'view_item' => __( 'View pharmacy', 'truck' ), /* View Display Title */
//			'search_items' => __( 'Search pharmacys', 'truck' ), /* Search Custom Type Title */
//			'not_found' =>  __( 'Nothing found in the Database.', 'truck' ), /* This displays if there are no entries yet */
//			'not_found_in_trash' => __( 'Nothing found in Trash', 'truck' ), /* This displays if there is nothing in the trash */
//			'parent_item_colon' => ''
//			), /* end of arrays */
//			'description' => __( 'This is a pharmacy', 'truck' ), /* Custom Type Description */
//			'public' => true,
//			'show_in_nav_menus' => true,
//			'publicly_queryable' => true,
//			'exclude_from_search' => false,
//			'show_ui' => true,
//			'query_var' => true,
//			'menu_position' => 8, /* this is what order you want it to appear in on the left hand side menu */
//			'menu_icon' => get_stylesheet_directory_uri() . '/images/pharmacy-icon.png', /* the icon for the custom post type menu */
//			'rewrite'	=> array( 'slug' => 'pharmacy', 'with_front' => false ), /* you can specify its url slug */
//			'has_archive' => 'pharmacy', /* you can rename the slug here */
//			'capability_type' => 'post',
//			'hierarchical' => false,
//			/* the next one is important, it tells what's enabled in the post editor */
//			'supports' => array( 'title', 'editor', /*'author',*/ 'thumbnail',/*'excerpt', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'sticky'*/)
//		) /* end of options */
//	); /* end of register post type */
//
//	/* this adds your post categories to your custom post type */
//	//register_taxonomy_for_object_type( 'category', 'tour' );
//	/* this adds your post tags to your custom post type */
//	//register_taxonomy_for_object_type( 'post_tag', 'tour' );
//
//}
//
//
//
//	// adding the function to the Wordpress init
//	add_action( 'init', 'product_post_type',1);
////	add_action( 'init', 'pharmacy_post_type');
//
//
//
//
//
//	/*
//	for more information on taxonomies, go here:
//	http://codex.wordpress.org/Function_Reference/register_taxonomy
//	*/
//
//	// now let's add custom categories (these act like categories)
//	register_taxonomy( 'product_cat',
//		array('product'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
//		array('hierarchical' => true,     /* if this is true, it acts like categories */
//			'labels' => array(
//				'name' => __( 'Product Categories', 'truck' ), /* name of the custom taxonomy */
//				'singular_name' => __( 'Product Category', 'truck' ), /* single taxonomy name */
//				'search_items' =>  __( 'Search Product Categories', 'truck' ), /* search title for taxomony */
//				'all_items' => __( 'All Product Categories', 'truck' ), /* all title for taxonomies */
//				'parent_item' => __( 'Parent Product Category', 'truck' ), /* parent title for taxonomy */
//				'parent_item_colon' => __( 'Parent Product Category:', 'truck' ), /* parent taxonomy title */
//				'edit_item' => __( 'Edit Product Category', 'truck' ), /* edit custom taxonomy title */
//				'update_item' => __( 'Update Product Category', 'truck' ), /* update title for taxonomy */
//				'add_new_item' => __( 'Add New Product Category', 'truck' ), /* add new title for taxonomy */
//				'new_item_name' => __( 'New Product Category Name', 'truck' ) /* name title for taxonomy */
//			),
//			'show_admin_column' => true,
//			'show_ui' => true,
//			'query_var' => true,
//			'rewrite' => array( 'slug' => 'product-cat' ),
//			'show_in_nav_menus' => true,
//		)
//	);
//
//
//	// now let's add custom tags (these act like categories)
//	register_taxonomy( 'product_tag',
//		array('product'), /* if you change the name of register_post_type( 'custom_type', then you have to change this */
//		array('hierarchical' => false,    /* if this is false, it acts like tags */
//			'labels' => array(
//				'name' => __( 'Product Tags', 'truck' ), /* name of the custom taxonomy */
//				'singular_name' => __( 'Product Tag', 'truck' ), /* single taxonomy name */
//				'search_items' =>  __( 'Search Product Tags', 'truck' ), /* search title for taxomony */
//				'all_items' => __( 'All Product Tags', 'truck' ), /* all title for taxonomies */
//				'parent_item' => __( 'Parent Product Tag', 'truck' ), /* parent title for taxonomy */
//				'parent_item_colon' => __( 'Parent Product Tag:', 'truck' ), /* parent taxonomy title */
//				'edit_item' => __( 'Edit Product Tag', 'truck' ), /* edit custom taxonomy title */
//				'update_item' => __( 'Update Product Tag', 'truck' ), /* update title for taxonomy */
//				'add_new_item' => __( 'Add New Product Tag', 'truck' ), /* add new title for taxonomy */
//				'new_item_name' => __( 'New Product Tag Name', 'truck' ) /* name title for taxonomy */
//			),
//			'show_admin_column' => true,
//			'show_ui' => true,
//			'query_var' => true,
//			'show_in_nav_menus' => true,
//		)
//	);
//
//

?>