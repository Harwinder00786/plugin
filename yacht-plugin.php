<?php
/*
Plugin Name: Yacht Addon
Plugin URI: http://ancorathemes.com
Description: Yacht Plugin - Premium plugin for yachts
Version: 1.1
Author: AncoraThemes
Author URI: http://ancorathemes.com
License: GPL2
*/

define( 'yacht_PLUGIN_VER', '1.1' );

// Plugin's core files
require_once 'core/core.plugin.php';

add_action( 'plugins_loaded', 'yacht_load_plugin_textdomain' );

// Register post type and taxonomy
if ( ! function_exists('yacht_plugin_cpt_yacht_init') ) {

    // Register Custom Post Type yacht
    function yacht_plugin_cpt_yacht_init() {

        $labels = array(
            'name'                  => esc_html_x( 'Yachts', 'Post Type General Name', 'yacht-plugin' ),
            'singular_name'         => esc_html_x( 'yacht', 'Post Type Singular Name', 'yacht-plugin' ),
            'menu_name'             => esc_html__( 'Yachts', 'yacht-plugin' ),
            'name_admin_bar'        => esc_html__( 'yacht', 'yacht-plugin' ),
            'archives'              => esc_html__( 'Item Archives', 'yacht-plugin' ),
            'parent_item_colon'     => esc_html__( 'Parent Item:', 'yacht-plugin' ),
            'all_items'             => esc_html__( 'All yachts', 'yacht-plugin' ),
            'add_new_item'          => esc_html__( 'Add New yacht', 'yacht-plugin' ),
            'add_new'               => esc_html__( 'Add New', 'yacht-plugin' ),
            'new_item'              => esc_html__( 'New yacht', 'yacht-plugin' ),
            'edit_item'             => esc_html__( 'Edit yacht', 'yacht-plugin' ),
            'update_item'           => esc_html__( 'Update yacht', 'yacht-plugin' ),
            'view_item'             => esc_html__( 'View yacht', 'yacht-plugin' ),
            'search_items'          => esc_html__( 'Search yacht', 'yacht-plugin' ),
            'not_found'             => esc_html__( 'Not found', 'yacht-plugin' ),
            'not_found_in_trash'    => esc_html__( 'Not found in Trash', 'yacht-plugin' ),
            'featured_image'        => esc_html__( 'Featured Image', 'yacht-plugin' ),
            'set_featured_image'    => esc_html__( 'Set featured image', 'yacht-plugin' ),
            'remove_featured_image' => esc_html__( 'Remove featured image', 'yacht-plugin' ),
            'use_featured_image'    => esc_html__( 'Use as featured image', 'yacht-plugin' ),
            'insert_into_item'      => esc_html__( 'Insert into item', 'yacht-plugin' ),
            'uploaded_to_this_item' => esc_html__( 'Uploaded to this item', 'yacht-plugin' ),
            'items_list'            => esc_html__( 'Items list', 'yacht-plugin' ),
            'items_list_navigation' => esc_html__( 'Items list navigation', 'yacht-plugin' ),
            'filter_items_list'     => esc_html__( 'Filter items list', 'yacht-plugin' ),
        );
        $args = array(
            'label'                 => esc_html__( 'Yacht', 'yacht-plugin' ),
            'description'           => esc_html__( 'Yacht Description', 'yacht-plugin' ),
            'labels'                => $labels,
            'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'custom-fields', 'page-attributes', ),
            'hierarchical'          => false,
            'public'                => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'menu_position'         => 5,
            'menu_icon'             => plugins_url( '/images/icon.png', __FILE__ ),
            'show_in_admin_bar'     => true,
            'show_in_nav_menus'     => true,
            'can_export'            => true,
            'has_archive'           => true,
            'exclude_from_search'   => false,
            'rewrite'               => array('slug' => 'yacht', 'with_front' => false),
            'publicly_queryable'    => true,
            'capability_type'       => 'page',
        );
        register_post_type( 'yacht', $args );

    }

    add_action( 'init', 'yacht_plugin_cpt_yacht_init', 0 );


    // Register Custom Taxonomy
    function yacht_plugin_taxonomy_reg() {
        $labels = array(
            'name'                       => _x( 'Yacht Group', 'Taxonomy General Name', 'yacht-plugin' ),
            'singular_name'              => _x( 'Group', 'Taxonomy Singular Name', 'yacht-plugin' ),
            'menu_name'                  => __( 'Yacht Group', 'yacht-plugin' ),
            'all_items'                  => __( 'All Groups', 'yacht-plugin' ),
            'parent_item'                => __( 'Parent Group', 'yacht-plugin' ),
            'parent_item_colon'          => __( 'Parent Group:', 'yacht-plugin' ),
            'new_item_name'              => __( 'New Group Name', 'yacht-plugin' ),
            'add_new_item'               => __( 'Add New Group', 'yacht-plugin' ),
            'edit_item'                  => __( 'Edit Group', 'yacht-plugin' ),
            'update_item'                => __( 'Update Group', 'yacht-plugin' ),
            'view_item'                  => __( 'View Group', 'yacht-plugin' ),
            'separate_items_with_commas' => __( 'Separate groups with commas', 'yacht-plugin' ),
            'add_or_remove_items'        => __( 'Add or remove groups', 'yacht-plugin' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'yacht-plugin' ),
            'popular_items'              => __( 'Popular Groups', 'yacht-plugin' ),
            'search_items'               => __( 'Search Groups', 'yacht-plugin' ),
            'not_found'                  => __( 'Not Found', 'yacht-plugin' ),
            'no_terms'                   => __( 'No groups', 'yacht-plugin' ),
            'items_list'                 => __( 'Groups list', 'yacht-plugin' ),
            'items_list_navigation'      => __( 'Groups list navigation', 'yacht-plugin' ),
        );
        $args = array(
            'labels'                     => $labels,
            'hierarchical'               => true,
            'public'                     => true,
            'show_ui'                    => true,
            'show_admin_column'          => true,
            'show_in_nav_menus'          => false,
            'show_tagcloud'              => false,
            'rewrite'                    => true
        );
        register_taxonomy( 'yacht_taxonomy', array( 'yacht' ), $args );
        flush_rewrite_rules();
    }

    add_action( 'init', 'yacht_plugin_taxonomy_reg', 1 );
}



// Add the yacht Meta Boxes
if ( ! function_exists('yacht_plugin_add_metaboxes') ) {
    function yacht_plugin_add_metaboxes() {
        add_meta_box('yacht_plugin_meta', esc_html__( 'Yacht info', 'yacht-plugin' ), 'yacht_plugin_show_meta', 'yacht', 'side', 'high');
    }
    add_action( 'add_meta_boxes', 'yacht_plugin_add_metaboxes' );
}





// Show the yacht Metabox
if ( ! function_exists('yacht_plugin_show_meta') ) {
    function yacht_plugin_show_meta() {
        global $post;

        // Noncename needed to verify where the data originated
        ?><input type="hidden" name="yacht_plugin_meta" id="yacht_plugin_meta" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>"/><?php

        // Get the location data if its already been entered
        $yacht_plugin_destination = get_post_meta($post->ID, 'yacht_plugin_destination', true);

        // Echo out the field
        ?>
            <p><label for="yacht_plugin_destination_meta"><?php echo esc_html__('Destination:','yacht-plugin') ; ?></label></p>
            <input type="text" name="yacht_plugin_destination" value="<?php echo esc_attr($yacht_plugin_destination) ; ?>" class="widefat" />
        <?php

        // Start date
        $yacht_plugin_yacht_start = get_post_meta( $post->ID, 'yacht_plugin_yacht_start', true  );
        ?>
            <p><label for="yacht_plugin_yacht_start"><?php echo esc_html__('Start yacht:','yacht-plugin') ; ?></label></p>
            <input type="text" name="yacht_plugin_yacht_start" id="yacht_start" value="<?php echo esc_attr($yacht_plugin_yacht_start); ?>"  class="widefat" />
        <?php

        // End date
        $yacht_plugin_yacht_end = get_post_meta( $post->ID, 'yacht_plugin_yacht_end', true  );
        ?>
            <p><label for="yacht_plugin_yacht_end"><?php echo esc_html__('End yacht:','yacht-plugin') ; ?></label></p>
            <input type="text" name="yacht_plugin_yacht_end" id="yacht_end" value="<?php echo esc_attr($yacht_plugin_yacht_end); ?>" class="widefat" />
        <?php

        // Count of speed
        $yacht_plugin_speed = get_post_meta( $post->ID, 'yacht_plugin_speed', true  );
        ?>
            <p><label for="yacht_plugin_speed"><?php echo esc_html__('Speed:','yacht-plugin') ; ?></label></p>
            <input type="text" name="yacht_plugin_speed"  value="<?php echo esc_attr($yacht_plugin_speed); ?>" class="widefat" />
        <?php

        // Count of people
        $yacht_plugin_count_people = get_post_meta( $post->ID, 'yacht_plugin_count_people', true  );
        ?>
            <p><label for="yacht_plugin_count_people"><?php echo esc_html__('How many people:','yacht-plugin') ; ?></label></p>
            <select name="yacht_plugin_count_people">
                <?php
                $option_values = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
                foreach($option_values as $key => $value) {
                    if($value == $yacht_plugin_count_people){ ?>
                        <option selected><?php echo esc_attr($value); ?></option>
                    <?php
                    } else { ?>
                        <option><?php echo esc_attr($value); ?></option>
                    <?php
                    }
                }
                ?>
            </select>
        <?php

        // Count of beds
        $yacht_plugin_count_beds = get_post_meta( $post->ID, 'yacht_plugin_count_beds', true  );
        ?>
        <p><label for="yacht_plugin_count_beds"><?php echo esc_html__('How many beds:','yacht-plugin') ; ?></label></p>
        <select name="yacht_plugin_count_beds">
            <?php
            $option_values = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
            foreach($option_values as $key => $value) {
                if($value == $yacht_plugin_count_beds){ ?>
                    <option selected><?php echo esc_attr($value); ?></option>
                    <?php
                } else { ?>
                    <option><?php echo esc_attr($value); ?></option>
                    <?php
                }
            }
            ?>
        </select>
        <?php


        //Overview content
        $yacht_plugin_overview = get_post_meta( $post->ID, 'yacht_plugin_overview', true  );
        ?>
        <p><label for="yacht_plugin_overview"><?php echo esc_html__('Additional Info 1:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_overview"  value="<?php echo esc_attr($yacht_plugin_overview); ?>" class="widefat" />
        <?php

        //Overview content
        $yacht_plugin_overview1 = get_post_meta( $post->ID, 'yacht_plugin_overview1', true  );
        ?>
        <p><label for="yacht_plugin_information1"><?php echo esc_html__('Additional Info 2:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_overview1"  value="<?php echo esc_attr($yacht_plugin_overview1); ?>" class="widefat" />
        <?php

        //Overview content
        $yacht_plugin_overview2 = get_post_meta( $post->ID, 'yacht_plugin_overview2', true  );
        ?>
        <p><label for="yacht_plugin_information2"><?php echo esc_html__('Additional Info 3:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_overview2"  value="<?php echo esc_attr($yacht_plugin_overview2); ?>" class="widefat" />
        <?php

        //Overview content
        $yacht_plugin_overview3 = get_post_meta( $post->ID, 'yacht_plugin_overview3', true  );
        ?>
        <p><label for="yacht_plugin_information1"><?php echo esc_html__('Additional Info 4:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_overview3"  value="<?php echo esc_attr($yacht_plugin_overview3); ?>" class="widefat" />
        <?php

        //Currency
        $yacht_plugin_currency = get_post_meta( $post->ID, 'yacht_plugin_currency', true  );
        ?>
            <p><label for="yacht_plugin_currency"><?php echo esc_html__('Currency of price:','yacht-plugin') ; ?></label></p>
            <input type="text" name="yacht_plugin_currency"  value="<?php echo esc_attr($yacht_plugin_currency); ?>" class="widefat" />
        <?php

        //Price
        $yacht_plugin_price = get_post_meta( $post->ID, 'yacht_plugin_price', true  );
        ?>
            <p><label for="yacht_plugin_price"><?php echo esc_html__('Price of yacht:','yacht-plugin') ; ?></label></p>
            <input type="text" name="yacht_plugin_price"  value="<?php echo esc_attr($yacht_plugin_price); ?>" class="widefat" />
        <?php

        //Old price
        $yacht_plugin_old_price = get_post_meta( $post->ID, 'yacht_plugin_old_price', true  );
        ?>
            <p><label for="yacht_plugin_old_price"><?php echo esc_html__('Old price of yacht:','yacht-plugin') ; ?></label></p>
            <input type="text" name="yacht_plugin_old_price"  value="<?php echo esc_attr($yacht_plugin_old_price); ?>" class="widefat" />
        <?php


                ?>
            </select>
        <?php

        //Maker
        $yacht_plugin_maker = get_post_meta( $post->ID, 'yacht_plugin_maker', true  );
        ?>
        <p><label for="yacht_plugin_maker"><?php echo esc_html__('Maker:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_maker"  value="<?php echo esc_attr($yacht_plugin_maker); ?>" class="widefat" />
        <?php

        //Model
        $yacht_plugin_model = get_post_meta( $post->ID, 'yacht_plugin_model', true  );
        ?>
        <p><label for="yacht_plugin_model"><?php echo esc_html__('Model:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_model"  value="<?php echo esc_attr($yacht_plugin_model); ?>" class="widefat" />
        <?php

        //Fuel
        $yacht_plugin_fuel = get_post_meta( $post->ID, 'yacht_plugin_fuel', true  );
        ?>
        <p><label for="yacht_plugin_fuel"><?php echo esc_html__('Fuel:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_fuel"  value="<?php echo esc_attr($yacht_plugin_fuel); ?>" class="widefat" />
        <?php

        //Equipment
        $yacht_plugin_equipment = get_post_meta( $post->ID, 'yacht_plugin_equipment', true  );
        ?>
        <p><label for="yacht_plugin_equipment"><?php echo esc_html__('Equipment 1:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_equipment"  value="<?php echo esc_attr($yacht_plugin_equipment); ?>" class="widefat" />
        <?php

        //Equipment
        $yacht_plugin_equipment1 = get_post_meta( $post->ID, 'yacht_plugin_equipment1', true  );
        ?>
        <p><label for="yacht_plugin_equipment1"><?php echo esc_html__('Equipment 2:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_equipment1"  value="<?php echo esc_attr($yacht_plugin_equipment1); ?>" class="widefat" />
        <?php

        //Equipment
        $yacht_plugin_equipment2 = get_post_meta( $post->ID, 'yacht_plugin_equipment2', true  );
        ?>
        <p><label for="yacht_plugin_equipment2"><?php echo esc_html__('Equipment 3:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_equipment2"  value="<?php echo esc_attr($yacht_plugin_equipment2); ?>" class="widefat" />
        <?php

        //Equipment
        $yacht_plugin_equipment3 = get_post_meta( $post->ID, 'yacht_plugin_equipment3', true  );
        ?>
        <p><label for="yacht_plugin_equipment3"><?php echo esc_html__('Equipment 4:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_equipment3"  value="<?php echo esc_attr($yacht_plugin_equipment3); ?>" class="widefat" />
        <?php

        //Equipment
        $yacht_plugin_equipment4 = get_post_meta( $post->ID, 'yacht_plugin_equipment4', true  );
        ?>
        <p><label for="yacht_plugin_equipment4"><?php echo esc_html__('Equipment 5:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_equipment4"  value="<?php echo esc_attr($yacht_plugin_equipment4); ?>" class="widefat" />
        <?php

        //Equipment
        $yacht_plugin_equipment5 = get_post_meta( $post->ID, 'yacht_plugin_equipment5', true  );
        ?>
        <p><label for="yacht_plugin_equipment5"><?php echo esc_html__('Equipment 6:','yacht-plugin') ; ?></label></p>
        <input type="text" name="yacht_plugin_equipment5"  value="<?php echo esc_attr($yacht_plugin_equipment5); ?>" class="widefat" />
        <?php

        //Accommodation
        $yacht_plugin_accommodation = get_post_meta( $post->ID, 'yacht_plugin_accommodation', true  );
        ?>
        <p><label for="yacht_plugin_accommodation"><?php echo esc_html__('Accommodation:','yacht-plugin') ; ?></label></p>
        <textarea rows="10" name="yacht_plugin_accommodation"  class="widefat" ><?php echo esc_attr($yacht_plugin_accommodation); ?></textarea>
        <?php


    }
}

// Show the yacht Metabox
if ( ! function_exists('yacht_plugin_show_meta1') ) {
    function yacht_plugin_show_meta1() {
        global $post;

        // Noncename needed to verify where the data originated
        ?><input type="hidden" name="yacht_plugin_meta1" id="yacht_plugin_meta1" value="<?php echo wp_create_nonce(plugin_basename(__FILE__)); ?>"/><?php


        ?>
        <?php

    }
}




// Save the yacht Metabox Data
if ( ! function_exists('yacht_plugin_save_meta') ) {
    function yacht_plugin_save_meta($post_id, $post) {

        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        if (!isset($_POST["yacht_plugin_meta"]) || !wp_verify_nonce($_POST['yacht_plugin_meta'], plugin_basename(__FILE__))) {
            return $post->ID;
        }

        // Is the user allowed to edit the post or page?
        if (!current_user_can('edit_post', $post->ID)) {
            return $post->ID;
        }

        // Check autosave
        if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE) {
            return $post_id;
        }

        // OK, we're authenticated: we need to find and save the data
        // We'll put it into an array to make it easier to loop though.
        $yacht_plugin_meta['yacht_plugin_destination'] = $_POST['yacht_plugin_destination'];
        $yacht_plugin_meta['yacht_plugin_yacht_start'] = $_POST['yacht_plugin_yacht_start'];
        $yacht_plugin_meta['yacht_plugin_yacht_end'] = $_POST['yacht_plugin_yacht_end'];
        $yacht_plugin_meta['yacht_plugin_speed'] = $_POST['yacht_plugin_speed'];
        $yacht_plugin_meta['yacht_plugin_count_people'] = $_POST['yacht_plugin_count_people'];
        $yacht_plugin_meta['yacht_plugin_count_beds'] = $_POST['yacht_plugin_count_beds'];
        $yacht_plugin_meta['yacht_plugin_overview'] = $_POST['yacht_plugin_overview'];
        $yacht_plugin_meta['yacht_plugin_overview1'] = $_POST['yacht_plugin_overview1'];
        $yacht_plugin_meta['yacht_plugin_overview2'] = $_POST['yacht_plugin_overview2'];
        $yacht_plugin_meta['yacht_plugin_overview3'] = $_POST['yacht_plugin_overview3'];
        $yacht_plugin_meta['yacht_plugin_price'] = $_POST['yacht_plugin_price'];
        $yacht_plugin_meta['yacht_plugin_old_price'] = $_POST['yacht_plugin_old_price'];
        $yacht_plugin_meta['yacht_plugin_currency'] = $_POST['yacht_plugin_currency'];
        $yacht_plugin_meta['yacht_plugin_maker'] = $_POST['yacht_plugin_maker'];
        $yacht_plugin_meta['yacht_plugin_model'] = $_POST['yacht_plugin_model'];
        $yacht_plugin_meta['yacht_plugin_fuel'] = $_POST['yacht_plugin_fuel'];
        $yacht_plugin_meta['yacht_plugin_equipment'] = $_POST['yacht_plugin_equipment'];
        $yacht_plugin_meta['yacht_plugin_equipment1'] = $_POST['yacht_plugin_equipment1'];
        $yacht_plugin_meta['yacht_plugin_equipment2'] = $_POST['yacht_plugin_equipment2'];
        $yacht_plugin_meta['yacht_plugin_equipment3'] = $_POST['yacht_plugin_equipment3'];
        $yacht_plugin_meta['yacht_plugin_equipment4'] = $_POST['yacht_plugin_equipment4'];
        $yacht_plugin_meta['yacht_plugin_equipment5'] = $_POST['yacht_plugin_equipment5'];
        $yacht_plugin_meta['yacht_plugin_accommodation'] = $_POST['yacht_plugin_accommodation'];


        // Add values of $yacht_plugin_meta as custom fields
        foreach ($yacht_plugin_meta as $key => $value) {     // Cycle through the $yacht_plugin_meta array!
            if ($post->post_type == 'revision') return;     // Don't store custom data twice
            $value = implode(',', (array)$value);           // If $value is an array, make it a CSV (unlikely)
            if (get_post_meta($post->ID, $key, FALSE)) {    // If the custom field already has a value
                update_post_meta($post->ID, $key, $value);
            } else {                                        // If the custom field doesn't have a value
                add_post_meta($post->ID, $key, $value);
            }
            if (!$value) delete_post_meta($post->ID, $key); // Delete if blank
        }
    }

    add_action('save_post', 'yacht_plugin_save_meta', 1, 2); // save the custom fields
}


// Add new image size for featured images
if ( !function_exists( 'yacht_plugin_add_new_image_size' ) ) {
    function yacht_plugin_add_new_image_size()
    {
        add_image_size('yacht-large', 770, 420, true);
        add_image_size('yacht-medium', 740, 482, true);
        add_image_size('yacht-small', 740, 402, true);
    }
    add_action('init', 'yacht_plugin_add_new_image_size');
}

// Add yacht form shortcode
if ( !function_exists( 'yacht_plugin_form_shortcode' ) ) {
    function yacht_plugin_form_shortcode($atts) {
        $atts = shortcode_atts( array(
                // Individual params
                "title" => esc_html__ ('Find Your Perfect Adventure', 'yacht-plugin')
            ), $atts , 'yacht_plugin_form_shortcode'
        );
        ob_start();
        ?>
        <div class="yacht-plugin yacht-plugin-form-shortcode">
            <div class="yacht-plugin yacht-plugin-form-content">
                <form role="search" action="<?php echo esc_url(site_url('/')); ?>" method="get" id="yacht-search-form-full" class="yacht-plugin yacht-plugin-form-full-search">
                    <input type="hidden" name="post_type" value="yacht" />
                <div class="yacht-plugin-column-row"><div class="yacht-plugin-column yacht-plugin-space">
                    </div><div class="yacht-plugin-column yacht-plugin-three">
                        <input class="yacht-field" type="text" name="s" placeholder="<?php echo esc_html__ ('Enter keyword', 'yacht-plugin')?>" autocomplete="off"/>
                    </div><div class="yacht-plugin-column yacht-plugin-three">
                        <div class="yacht-plugin yacht-plugin-datepicker">
                            <input class="yacht-field" type="text" id="yacht_start" name="yacht-start" placeholder="<?php echo esc_html__ ('Date', 'yacht-plugin')?>" autocomplete="off"/>
                        </div>
                    </div><div class="yacht-plugin-column yacht-plugin-three">
                        <input id="yacht-price-begin" name="yacht-price-begin" type="hidden">
                        <input id="yacht-price-end" name="yacht-price-end" type="hidden">
                        <?php
                            global $wpdb;
                            $sql = "SELECT max( cast( meta_value as UNSIGNED ) ) FROM {$wpdb->postmeta} WHERE meta_key='%s'";
                            $query = $wpdb->prepare( $sql, 'yacht_plugin_price');
                            $max_price = $wpdb->get_var( $query );
                        ?>
                        <div id="yacht-plugin-price" data-maxvalue="<?php echo esc_html($max_price);?>"></div>
                    </div><div class="yacht-plugin-column yacht-plugin-two">
                        <button type="submit" value="<?php echo esc_html__ ('Search', 'yacht-plugin')?>"><?php echo esc_html__ ('Find a yacht', 'yacht-plugin')?></button>
                    </div><div class="yacht-plugin-column yacht-plugin-space">
                    </div></div>
                </form>
            </div>
        </div>
        <?php
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    add_shortcode('yacht_plugin_form_shortcode', 'yacht_plugin_form_shortcode');
}




// Add search template
if ( !function_exists( 'yacht_plugin_search' ) ) {
    function yacht_plugin_search($template)
    {
        global $wp_query, $post;
        $post_type = get_query_var('post_type');
        if ($wp_query->is_search && $post_type == 'yacht') {
            $template = plugin_dir_path(__FILE__) . ('template/archive-search.php');
        }
        return $template;
    }

    add_filter('template_include', 'yacht_plugin_search');
}


// Add yacht shortcode
if ( !function_exists( 'yacht_plugin_shortcode' ) ) {
    function yacht_plugin_shortcode($atts) {
        $atts = shortcode_atts( array(
                // Individual params
                "style" => 'original' || 'original-noborder',
                "group" => '',
                "count" => 3,
                "columns" => 2,
                "slider" => 0,
            ), $atts , 'yacht_plugin_shortcode'
        );
        $atts['count'] = max(1, (int) $atts['count']);
		$atts['columns'] = max(2, (int) $atts['columns']);
        //$atts['columns'] = max(2, min( 3,(int) $atts['columns']));
        $atts['slider'] = $atts['slider'] > 0 && $atts['count'] > $atts['columns'];

        ob_start();
        $query = new WP_Query(array(
            'post_type' => 'yacht',
            'posts_per_page' => $atts['count'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'yacht_taxonomy',
                    'field'    => 'term_id',
                    'terms' => intval($atts['group'])
                ),
            ),
            'order' => 'ASC',
            'orderby' => 'title'
        ));
        if ($query->have_posts()) {
            ?><div class="yacht-plugin yacht-container<?php
                if ($atts['slider']) echo ' swiper-container';
                echo ' yacht-style-' . esc_html($atts['style']);
            ?>"<?php
            echo ($atts['columns'] > 1
                    ? ' data-slides="' . esc_attr($atts['columns']) . '"'
                    : '');
            ?>><?php

            if ($atts['slider']) {
                ?><div class="swiper-wrapper"><?php
            } else if ($atts['columns'] > 1) {
                ?><div class="yacht-plugin yacht-columns-container"><?php
            }

            while ($query->have_posts()) : $query->the_post();
                    if ($atts['slider']) {
                        ?><div class="swiper-slide"><?php
                    } else if ($atts['columns'] > 1) {
                        ?><div class="<?php echo esc_html('yacht-plugin column-1-'.$atts['columns']); ?>"><?php
                    }
                    ?><div id="post-<?php the_ID(); ?>" <?php post_class();?>>
                        <div class="yacht-plugin yacht-single">
                            <div class="yacht-plugin yacht-featured">
                                <?php
                                    if($atts['style'] == 'original' || 'original-noborder') {
                                        echo get_the_post_thumbnail(get_the_ID(), 'yacht-medium');
                                    } else {
                                        echo get_the_post_thumbnail(get_the_ID(), 'yacht-small');
                                    }
                                ?>
                                <div class="yacht-plugin yacht-featured-overlay">
                                    <?php
                                        $meta = get_post_meta(get_the_ID(), '', true);


                                    ?>
                                </div>
                            </div>
                            <div class="yacht-plugin yacht-plugin-content">
                                <div class="yacht-title">
                                    <a class="yacht-plugin yacht-title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </div>
                                <?php
                                //Price
                                if (isset($meta['yacht_plugin_price'][0])) {
                                    if (($price = $meta['yacht_plugin_price'][0]) != '') {
                                        $currency = '';
                                        if (isset($meta['yacht_plugin_currency'][0])) {
                                            $currency = $meta['yacht_plugin_currency'][0];
                                        }
                                        ?><div class="yacht-plugin yacht-price"><?php
                                        //Old price
                                        if (isset($meta['yacht_plugin_old_price'][0])) {
                                            if (($old_price = $meta['yacht_plugin_old_price'][0]) != '') {
                                                ?><span class="yacht-plugin yacht-old-price"><?php
                                                echo esc_html($currency . $old_price);
                                                ?></span><?php
                                            }
                                        }
                                        ?><span class="yacht-plugin yacht-present-price"><?php
                                        echo esc_html($currency . $price); ?>
                                        </span><span class="yacht-plugin yacht-week"><?php echo esc_html__ (' / week', 'yacht-plugin')?>
                                        </span><?php
                                        ?></div><?php
                                    }
                                }
                                    //Destination
                                    if (isset($meta['yacht_plugin_destination'][0])) {
                                        if (($destination = $meta['yacht_plugin_destination'][0]) != '') {
                                            ?><div class="yacht-plugin yacht-destination"><?php
                                            echo esc_html($destination);
                                            ?></div><?php
                                        }
                                    }
                                ?>
                                <div class="yacht-plugin yacht-info">
                                    <?php if($atts['style'] == 'original' || 'original-noborder') { ?>
                                        <div class="yacht-plugin yacht-info-part"><?php
                                            //Count of speed
                                            if (isset($meta['yacht_plugin_speed'][0])) {
                                                if (($speed_count = $meta['yacht_plugin_speed'][0]) != '') {
                                                    ?>
                                                    <div class="icon-4-1"><?php
                                                    echo esc_html($speed_count);
                                                    ?></div><?php
                                                }
                                            }
                                            //Count of people
                                            if (isset($meta['yacht_plugin_count_people'][0])) {
                                                if (($people_count = $meta['yacht_plugin_count_people'][0]) != '') {
                                                    ?>
                                                    <div class="icon-5-1"><?php
                                                    echo esc_html($people_count);
                                                    ?></div><?php
                                                }
                                            }
                                            //Count of beds
                                            if (isset($meta['yacht_plugin_count_beds'][0])) {
                                                if (($beds_count = $meta['yacht_plugin_count_beds'][0]) != '') {
                                                    ?>
                                                    <div class="icon-6-1"><?php
                                                    echo esc_html($beds_count);
                                                    ?></div><?php
                                                }
                                            }

                                            ?></div>
                                    <?php
                                    } else {
                                        //List
                                        if (isset($meta['yacht_plugin_transfer'][0]) || isset($meta['yacht_plugin_information'][0]) || isset($meta['yacht_plugin_information1'][0]) || isset($meta['yacht_plugin_information2'][0])) {
                                            ?><ul class="yacht-plugin yacht-list"><?php


                                            //Count days
                                            if (isset($meta['yacht_plugin_yacht_start'][0]) && isset($meta['yacht_plugin_yacht_end'][0])) {
                                                $datetime = new DateTime();
                                                $date1 = $datetime->createFromFormat('d/m/Y', $meta['yacht_plugin_yacht_start'][0]);
                                                $datetime = new DateTime();
                                                $date2 = $datetime->createFromFormat('d/m/Y', $meta['yacht_plugin_yacht_end'][0]);
                                                $datediff = $date2->diff($date1)->format("%a") + 1;
                                                ?>
                                                <li class="yacht-icon-ok"><?php
                                                echo esc_html($datediff) . ' ' . ($datediff > 1 ? esc_html__('Days', 'yacht-plugin') : esc_html__('Day', 'yacht-plugin'));
                                                ?></li><?php
                                            }

                                            //Count of people
                                            if (isset($meta['yacht_plugin_count_people'][0])) {
                                                if (($people_count = $meta['yacht_plugin_count_people'][0]) != '') {
                                                    ?>
                                                    <li class="yacht-icon-ok"><?php
                                                    echo esc_html($people_count) . ' ' . esc_html__('Persons', 'yacht-plugin');
                                                    ?></li><?php
                                                }
                                            }

                                            if (isset($meta['yacht_plugin_transfer'][0])) {
                                                if (($transfer = $meta['yacht_plugin_transfer'][0]) != '') {
                                                    ?>
                                                    <li class="yacht-icon-ok"><?php
                                                    echo esc_html($transfer);
                                                    ?></li><?php
                                                }
                                            }

                                            if (isset($meta['yacht_plugin_information'][0])) {
                                                if (($information = $meta['yacht_plugin_information'][0]) != '') {
                                                    ?>
                                                    <li class="yacht-icon-ok"><?php
                                                    echo esc_html($information);
                                                    ?></li><?php
                                                }
                                            }

                                            if (isset($meta['yacht_plugin_information1'][0])) {
                                                if (($information = $meta['yacht_plugin_information1'][0]) != '') {
                                                    ?>
                                                    <li class="yacht-icon-ok"><?php
                                                    echo esc_html($information);
                                                    ?></li><?php
                                                }
                                            }

                                            if (isset($meta['yacht_plugin_information2'][0])) {
                                                if (($information = $meta['yacht_plugin_information2'][0]) != '') {
                                                    ?>
                                                    <li class="yacht-icon-ok"><?php
                                                    echo esc_html($information);
                                                    ?></li><?php
                                                }
                                            }
                                            ?></ul>
                                            <div class="yacht-plugin yacht-info"><div class="yacht-plugin yacht-info-part">
                                            <a class="yacht-plugin yacht-title-read-more yacht-icon-icon9"
                                               href="<?php the_permalink(); ?>"><?php echo esc_html__('More info', 'yacht-plugin'); ?></a>
                                            </div><div class="yacht-plugin yacht-info-part">
                                                <a class="yacht-plugin yacht-button-read-more"
                                                   href="<?php the_permalink(); echo '#book' ;?>"><?php echo esc_html__('Book', 'yacht-plugin'); ?></a>
                                            </div></div><?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div></div><?php
                endwhile;
                wp_reset_postdata();
            ?></div><div class="swiper-scrollbar"></div></div><?php
        }
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
    add_shortcode('yacht_plugin_shortcode', 'yacht_plugin_shortcode');
}

// Add yacht shortcode to Visual Composer
if (!function_exists('yacht_plugin_shortcode_add_vc')) {
    function yacht_plugin_shortcode_add_vc() {
        //Register shortcode yacht in Visual Composer
        vc_map(array(
            "name" => esc_html__("Yachts", 'yacht-plugin'),
            "description" => esc_html__("Display team members from specified group", 'yacht-plugin'),
            "base" => "yacht_plugin_shortcode",
            "content_element" => true,
            "category" => esc_html__('yacht Plugin', 'yacht-plugin'),
            "show_settings_on_create" => true,
            "is_container" => false,
            "class" => "yacht_plugin_shortcode",
            "icon" => 'icon-yacht-plugin',
            "params" => array(
                array(
                    "param_name" => "style",
                    "heading" => esc_html__("Style", 'yacht-plugin'),
                    "description" => esc_html__("Select style yacht shortcode", 'yacht-plugin'),
                    "value" => array(
                        esc_html__("Original style", 'yacht-plugin') => 'original',
                        esc_html__("Extended style", 'yacht-plugin') => 'extended',
                        esc_html__("Original no border style", 'yacht-plugin') => 'original-noborder'
                    ),
                    "type" => "dropdown"
                ),
                array(
                    "param_name" => "group",
                    "heading" => esc_html__("Group", 'yacht-plugin'),
                    "description" => esc_html__("Yacht group", 'yacht-plugin'),
                    "value" => array_merge(array(esc_html__('- Select yacht group -', 'yacht-plugin') => 0), array_flip(yacht_plugin_get_list_cats())),
                    "type" => "dropdown"
                ),
                array(
                    "param_name" => "count",
                    "heading" => esc_html__("Count", 'yacht-plugin'),
                    "description" => esc_html__("Specify number of yachts to display", 'yacht-plugin'),
                    "admin_label" => true,
                    "type" => "textfield"
                ),
                array(
                    "param_name" => "columns",
                    "heading" => esc_html__("Columns", 'yacht-plugin'),
                    "description" => esc_html__("Specify number of columns. If empty - auto detect by yachts number", 'yacht-plugin'),
                    "admin_label" => true,
                    "value" => array(
                        '2' => '2',
                        '3' => '3',
                    ),
                    "type" => "dropdown"
                ),
                array(
                    "param_name" => "slider",
                    "heading" => esc_html__("Slider", 'yacht-plugin'),
                    "description" => esc_html__("Show items as slider (only if count sliders more then columns)", 'yacht-plugin'),
                    "admin_label" => true,
                    "std" => "0",
                    "value" => array(esc_html__("Slider", 'yacht-plugin') => "1" ),
                    "admin_label" => true,
                    "type" => "checkbox"
                )
            ),
        ));
    }
    add_action( 'vc_before_init', 'yacht_plugin_shortcode_add_vc' );
}


// Add yacht form shortcode to Visual Composer
if (!function_exists('yacht_plugin_form_shortcode_add_vc')) {
    function yacht_plugin_form_shortcode_add_vc() {
        //Register shortcode yacht in Visual Composer
        vc_map(array(
            "name" => esc_html__("Yacht Search Form", 'yacht-plugin'),
            "description" => esc_html__("Display yacht search form", 'yacht-plugin'),
            "base" => "yacht_plugin_form_shortcode",
            "content_element" => true,
            "category" => esc_html__('yacht Plugin', 'yacht-plugin'),
            "show_settings_on_create" => true,
            "is_container" => false,
            "class" => "yacht_plugin_form_shortcode",
            "icon" => 'icon-yacht-plugin',
            "params" => array(
                array(
                    "param_name" => "title",
                    "heading" => esc_html__("Title", 'yacht-plugin'),
                    "description" => esc_html__("Title for search form", 'yacht-plugin'),
                    "admin_label" => true,
                    "type" => "textfield"
                )
            ),
        ));
    }
    add_action( 'vc_before_init', 'yacht_plugin_form_shortcode_add_vc' );
}


// Change standard single template for yachts
if ( !function_exists( 'yacht_plugin_single' ) ) {
    function yacht_plugin_single($template) {
        global $post;
        if (is_single() && $post->post_type == 'yacht') {
            $template = plugin_dir_path(__FILE__).('/template/single-yacht.php');
        }
        return $template;
    }
    add_filter('single_template', 'yacht_plugin_single');
}

// Change standard category template for services categories (groups)
if ( !function_exists( 'yacht_plugin_taxonomy_template' ) ) {
    function yacht_plugin_taxonomy_template( $template ) {
        if ( is_tax('yacht_taxonomy') )
            $template = plugin_dir_path(__FILE__).('template/archive-yacht.php');
        return $template;
    }
    add_filter('taxonomy_template',	'yacht_plugin_taxonomy_template');
}


// Load required styles and scripts in the admin mode
if ( !function_exists( 'yacht_plugin_admin_enqueue_script' ) ) {
    function yacht_plugin_admin_enqueue_script() {
        // Enqueue Datepicker + jQuery UI CSS
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script('jquery-ui-slider');

        wp_enqueue_style( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);

        // Admin styles and scripts
        wp_enqueue_style( 'yacht-plugin-style', plugins_url( '/css/style.css', __FILE__ ) );
        wp_enqueue_script( 'yacht-plugin-admin-script', plugins_url( '/js/yacht-plugin.admin.js', __FILE__ ), array('jquery'), null, true );
    }
    add_action("admin_enqueue_scripts", 'yacht_plugin_admin_enqueue_script');
}

// Load required styles and scripts
if ( !function_exists( 'yacht_plugin_enqueue_script' ) ) {
    function yacht_plugin_enqueue_script() {
        // Enqueue Datepicker + jQuery UI CSS
        wp_enqueue_script( 'jquery-ui-datepicker' );
        wp_enqueue_script('jquery-ui-slider');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_style( 'jquery-ui-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.1/themes/smoothness/jquery-ui.css', true);

        // Styles and scripts
        wp_enqueue_style( 'yacht-plugin-style', plugins_url( '/css/style.css', __FILE__ ) );
        wp_enqueue_style( 'yacht-plugin-colors', plugins_url( '/css/colors.css', __FILE__ ) );
        wp_enqueue_style( 'yacht-plugin-fontello-style', plugins_url( '/css/fontello/css/fontello.css', __FILE__ ) );
        wp_enqueue_script( 'yacht-plugin-script', plugins_url( '/js/yacht-plugin.js', __FILE__ ), array('jquery'), null, true );
        wp_enqueue_script( 'yacht-plugin-admin-script', plugins_url( '/js/yacht-plugin.admin.js', __FILE__ ), array('jquery'), null, true );
    }
    add_action("wp_enqueue_scripts", 'yacht_plugin_enqueue_script');
}

function yacht_load_plugin_textdomain() {
	static $loaded = false;
	if ( $loaded ) return true;
	$domain = 'yacht-plugin';
	if ( is_textdomain_loaded( $domain ) && !is_a( $GLOBALS['l10n'][ $domain ], 'NOOP_Translations' ) ) return true;
	$loaded = true;
	load_plugin_textdomain( $domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
?>