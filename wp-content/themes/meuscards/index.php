<?php
get_header();

$args = array(
    'post_type' => 'projeto', // Nome do seu CPT
    'posts_per_page' => -1,   // Para recuperar todos os posts, você pode definir -1
    'orderby' => 'date',      // Ordenar por data (você pode alterar isso para suas necessidades)
    'order' => 'DESC',        // Ordem decrescente (do mais recente para o mais antigo)
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) :
        $query->the_post();

        // Faça algo com os posts, por exemplo, exibi-los
        echo '<h2>' . get_the_title() . '</h2>';
        echo '<div>' . get_the_content() . '</div>';

    endwhile;
    wp_reset_postdata(); // Restaura os dados do post original
else :
    // Caso não haja posts
    echo 'Nenhum projeto encontrado.';
endif;

get_footer();
