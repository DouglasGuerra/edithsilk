<?php get_header();

while ($query->have_posts()) :
    $query->the_post();

    // Faça algo com os posts, por exemplo, exibi-los
    echo '<h2>' . get_the_title() . '</h2>';
    echo '<div>' . get_the_content() . '</div>';

endwhile;

get_footer();