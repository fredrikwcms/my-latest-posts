<?php
/* 
*   Plugin Name:    My Latest Posts Plugin
*   Plugin URI:     https://data-lord.se/my-latest-posts-plugin
*   Description:    This is my second plugin. It fetches the latest posts.
*   Version:        0.1
*   Author:         Fredrik Larsson
*   Author URI:     http://lmgtfy.com
*   License:        WTFPL
*   License URI:    https://www.wtfpl.net/
*   Text Domain:    my-latest-posts
*   Domain Path:    /languages
*/

function mlp_shortcode($user_atts = [], $content = null, $tag = '')    {
    $default_atts = [
        'posts' => 3,
        'title' =>  __('Latest Posts', 'my-latest-posts'),
    ];

    $atts = shortcode_atts($default_atts, $user_atts, $tag);

    $posts = new WP_Query([
        'posts_per_page'    =>  $atts['posts'],
    ]);

    $output = "<h2>" . esc_html($atts['title']) . "</h2>";
    if($posts->have_posts())    {
        // Start the list
        $output .= "<ul>";
        while ($posts->have_posts()) {
            $posts->the_post();
            // Each post that we get
            $output .= "<li>";
            $output .= "<a href='" . get_the_permalink() . "'>";
            $output .= get_the_title();
            $output .= "</a>";
            // Show the categories and time since posted
            $output .= "<small>";
            $output .= " in ";
            $output .= get_the_category_list(', ');
            $output .= " by";
            $output .= human_time_diff(get_the_time('U')) . ' ago ';
            $output .= "</small>";

            $output .= "</li>";
        }
        wp_reset_postdata();
        $output .= "</ul>";
    }   else    {
        $output .= "No Latest posts available.";
    }

    return $output;
}

function mlp_init() {
    add_shortcode('latest-posts', 'mlp_shortcode');
}

add_action('init', 'mlp_init');