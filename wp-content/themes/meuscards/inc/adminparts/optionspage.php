<?php

//function acf_painel_de_projetos()
//{
//    if (function_exists('acf_add_options_page'))
//    {
//        /** PÁGINA DE OPÇÕES **/
//        acf_add_options_page(array(
//            'page_title' => 'Estatísticas',
//            'menu_title' => 'Estatísticas',
//            'menu_slug'  => 'estatisticas',
//            'capability' => 'edit_posts',
//            'position'   =>  2,
//            'icon_url'   =>  'dashicons-chart-bar',
//        ));
//    }
//}
//
//add_action('admin_menu', 'acf_painel_de_projetos');

function painel_de_projetos()
{
    add_menu_page(
        __( 'Estatísticas', 'estatisticas' ),
        __( 'Estatísticas', 'estatisticas' ),
        'manage_options',
        'estatisticas',
        'pagina_de_estatisticas',
        'dashicons-chart-bar',
        3
    );
}

add_action( 'admin_menu', 'painel_de_projetos' );

function pagina_de_estatisticas ()
{
    ?>
    <h1>Welcome to the jungle!</h1>
    <?php

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

}