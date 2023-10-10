<?php
include get_template_directory() . '/inc/functionparts/mc_functions.php';
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

    $user ="";
     if(is_user_logged_in()){
        $user = wp_get_current_user();
     }
    ?>


    <h3>Olá </h3>
    <?php

    $args = array(
        'post_type' => 'projeto', // Nome do seu CPT
        'posts_per_page' => -1,   // Para recuperar todos os posts, você pode definir -1
        'orderby' => 'date',      // Ordenar por data (você pode alterar isso para suas necessidades)
        'order' => 'DESC',        // Ordem decrescente (do mais recente para o mais antigo)
    );

    ?>

    <div class="container d-flex wrap justify-content-start">

        <div class="row">
            <?php
                $labels =[
                        'Teste01',
                        'Teste02',
                        'Teste03',
                        'teste04',
                        'teste05',
            ];
                $data = [13, 15, 9, 5, 1];
            

            chart($labels, $data); ?>
        </div>
    
        <div class="row gap-5">
            <?php
            $query = new WP_Query($args);
            if ($query->have_posts()) :
                while ($query->have_posts()) :
                    $query->the_post();

                    // Faça algo com os posts, por exemplo, exibi-los

                    $html = "";

                    $get_image = get_field('imagem_do_projeto');

                    $html .= '<div class="card p-0" style="width: 18rem; ">' .
                        '<img src="' . $get_image . '" class="card-img-top" alt="...">' .
                        '<div class="card-body">' .
                        '<h5 class="card-title">' . get_the_title() . '</h5>' .
                        '<span class="card-text">' . get_post_status() . '</span>' .
                        '<p class="card-text">' . get_the_excerpt() . '</p>' .
                        '<span class="card-text">' . get_the_date() . '</span>' .
                        '<button class="open-modal-button" data-post-id="' . get_the_ID() . '">Abrir Modal</button>' .
                        '</div>' .
                        '</div>';

                    echo $html;
                endwhile;
                wp_reset_postdata(); // Restaura os dados do post original
            else :
                echo 'Nenhum projeto encontrado.';
            endif;
            ?>

            <!-- Modal Genérico -->
            <div id="genericModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="modal-content"></div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    var genericModal = document.getElementById('genericModal');
                    var modalContent = document.getElementById('modal-content');
                    var closeModalButton = document.querySelector('.close');
                    var openModalButtons = document.querySelectorAll('.open-modal-button');

                    openModalButtons.forEach(function (button) {
                        button.addEventListener('click', function () {
                            var postId = button.getAttribute('data-post-id');
                            var postContent = 'Conteúdo do modal para o post ID ' + postId; // Personalize conforme necessário
                            modalContent.innerHTML = postContent;
                            genericModal.style.display = 'block';
                        });
                    });

                    closeModalButton.addEventListener('click', function () {
                        genericModal.style display = 'none';
                    });

                    window.addEventListener('click', function (event) {
                        if (event.target === genericModal) {
                            genericModal.style.display = 'none';
                        }
                    });
                });
            </script>
        </div>
    </div>
    <?php

}