<?php

function project_enqueue_script() {
    wp_enqueue_style( 'style',get_template_directory_uri() . '/dist/style.css'  );
    wp_enqueue_script( 'script', get_template_directory_uri() . '/src/script.js' );
}
add_action('wp_enqueue_scripts', 'project_enqueue_script');