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

function mlp_shortcode()    {
    $posts = new WP_Query([
        'posts_per_page'    =>  3,
    ]);

    $output = "<h2>Latest Posts</h2>";
    if($posts->have_posts())    {
        $output .= "<ul>";
        while ($posts->have_posts()) {
            $posts->the_post();
            $output .= "<li>";
            $output .= "<a href='" . get_the_permalink() . "'>";
            $output .= get_the_title();
            $output .= "</a></li>";
        }
        wp_reset_postdata();
        $output .= "</ul>";
    }   else    {
        $output .= "No Latest posts available.";
    }

    return $output;
}

function mlp_show_post($atts = [])    {
    $atts = array_change_key_case((array)$atts, CASE_LOWER);
    $textProps = shortcode_atts([
        'text'  =>  'Hello',
        'color' => 'red',
    ], $atts);
    return "<h1 style='color: " . $textProps['color'] . "'>" . $textProps['text'] . "</h1>";
}

function mlp_init() {
    add_shortcode('latest-posts', 'mlp_shortcode');

    add_shortcode('show-post', 'mlp_show_post');
}

add_action('init', 'mlp_init');