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

    ?>

    <div class="container d-flex wrap justify-content-start">
        <div class="row gap-5">
            <div id="carouselExample" class="carousel slide">
                <div class="carousel-inner">
                    <?php
                    $query = new WP_Query($args);
                    if ($query->have_posts()) :
                        while ($query->have_posts()) :
                            $query->the_post();
                            $i = 0;
                            echo '<pre>';
                            var_dump($query);
                            echo '</pre>';
                            // Faça algo com os posts, por exemplo, exibi-los

                            $html = "";

                            $get_image = get_field('imagem_do_projeto');

                            $html .= '<div class="carousel-item' . $i == 0 ?'active' : '' . '">'.
                                '<div class="card p-0" style="width: 18rem; ">' .
                                '<img src=" '. $get_image . ' " class="card-img-top" alt="...">'.
                                '<div class="card-body">'.
                                '<h5 class="card-title"> '. get_the_title() .' </h5>'.
                                '<span class="card-text"> '. get_post_status() . '</span>'.
                                '<p class="card-text"> '. get_the_excerpt() . '</p>'.
                                '<span class="card-text"> '. get_the_date() .'</span>'.
                                '</div>'.
                                '</div>'.
                                '</div>';

                            echo $html;

                            $i++;
                        endwhile;
                        wp_reset_postdata(); // Restaura os dados do post original
                    else :
                        // Caso não haja posts
                        'Nenhum projeto encontrado.';
                    endif;
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    <?php

}