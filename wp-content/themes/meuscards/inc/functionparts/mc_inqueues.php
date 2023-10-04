<?php

function mc_enqueues_scripts_and_styles ()
{
    /** BOOTSTRAP - STYLES **/
    wp_enqueue_style('mc_bootstrap_style', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), '1.0', 'all');

    /** BOOTSTRAP - ICONS **/
    wp_enqueue_style('mc_bootstrap_icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css', array(), '1.0', 'all');

    /** STYLE PRINCIPAL - /style.css **/
    wp_enqueue_style('mc_style', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');

    /** POOPER - JS **/
    wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js', array('jquery'), null, true);

    /** BOOTSTRAP - JS **/
    wp_enqueue_script('mc_bootstrap_script', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), null, true);

    /** CHART JS **/
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', array(), null, false);

    /** JS PRINCIPAL - /assets/js/scripts.js **/
    wp_enqueue_script('mc_scripts', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), null, true);

}

add_action('wp_enqueue_scripts', 'mc_enqueues_scripts_and_styles');
add_action('admin_enqueue_scripts', 'mc_enqueues_scripts_and_styles');