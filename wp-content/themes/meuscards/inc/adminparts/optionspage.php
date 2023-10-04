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
    <h1>Bem vindo!</h1>
    <?php

    $args = array(
        'post_type' => 'projeto', // Nome do seu CPT
        'posts_per_page' => -1,   // Para recuperar todos os posts, você pode definir -1
        'orderby' => 'date',      // Ordenar por data (você pode alterar isso para suas necessidades)
        'order' => 'DESC',        // Ordem decrescente (do mais recente para o mais antigo)
    );

    echo '<pre>';
    var_dump($args);
    echo '</pre>';
    
    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();

            // Faça algo com os posts, por exemplo, exibi-los

            $html = "";

            $html .= '<div class="card" style="width: 18rem; ">' .
            '<img src="..." class="card-img-top" alt="...">'.
            '<div class="card-body">'.
                '<h5 class="card-title"> '. get_the_title()  .' </h5>'.
                '<p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>'.
                '<a href="#" class="btn btn-primary">Go somewhere</a>'.
            '</div>'.
            '</div>';

            echo $html;
            

        endwhile;
        wp_reset_postdata(); // Restaura os dados do post original
    else :
        // Caso não haja posts
        'Nenhum projeto encontrado.';
    endif;

}