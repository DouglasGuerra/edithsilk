<?php
include get_template_directory() . '/inc/functionparts/mc_functions.php';

function painel_de_projetos()
{
    add_menu_page(
        __('Estatísticas', 'estatisticas'),
        __('Estatísticas', 'estatisticas'),
        'manage_options',
        'estatisticas',
        'pagina_de_estatisticas',
        'dashicons-chart-bar',
        3
    );
}

add_action('admin_menu', 'painel_de_projetos');

function pagina_de_estatisticas()
{
    // Configuração da consulta inicial
    $args = array(
        'post_type' => 'projeto', // Nome do seu CPT
        'posts_per_page' => 8,   // Número de projetos por página
        'paged' => 1, // Página inicial
        'orderby' => 'date',      // Ordenar por data (você pode alterar isso para suas necessidades)
        'order' => 'DESC',        // Ordem decrescente (do mais recente para o mais antigo)
    );

    $query = new WP_Query($args);

    $projetos_ativos = get_posts(array(
        'post_type' => 'projeto', // Substitua pelo nome do seu tipo de post
        'meta_key' => 'projeto_ativo',
        'meta_value' => true
    ));
    $projetos = count(get_posts(array('post_type' => 'projeto')));
    $projetos_inativos = $projetos - count($projetos_ativos);
    $comments = count(get_comments());

    ?>

    <h3 class="ms-3">Olá, <?= get_current_user() ?> </h3>

    <div class="container text-center">
        <div class="row align-items-start">

            <div class="col-9">
                <div>
                    <canvas id="barsChart"></canvas>
                </div>
            </div>
            <!--            <div class="col">-->
            <!--                <div>-->
            <!--                    <canvas id="lineChart"></canvas>-->
            <!--                </div>-->
            <!--            </div>-->
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const ctxBars = document.getElementById('barsChart');
        const ctxLine = document.getElementById('lineChart');

        new Chart(ctxBars, {
            type: 'bar',
            data: {
                labels: ['Projetos ativos', 'Projetos inativos', 'Total de projetos', 'Total de comentários'],
                datasets: [{
                    label: 'Dados',
                    data: ['<?= count($projetos_ativos)?>', '<?= $projetos_inativos ?>', '<?= $projetos ?>', '<?= $comments ?>'],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        })


        //new Chart(ctxLine, {
        //    type: 'line',
        //    data: {
        //        labels: ['Users', 'Label 02', 'Label 03', 'Label 04', 'Label 05', 'Label 06'],
        //        datasets: [{
        //            label: 'Dashboard',
        //            data: ['<?php //= user ?>//', 6, 3, 1, 4, 2],
        //            borderWidth: 1
        //        }]
        //    },
        //    options: {
        //        scales: {
        //            y: {
        //                beginAtZero: true
        //            }
        //        }
        //    }
        //});
    </script>

    <div class="container d-flex wrap justify-content-start">
        <div class="row gap-5" id="projects-container">
            <?php
            if ($query->have_posts()) :
                while ($query->have_posts()) :
                    $query->the_post();
                    // Exibir os cartões aqui
                    $get_image = get_field('imagem_do_projeto');
                    $get_tasks = get_field('tarefas');
                    ?>

                    <div class="card p-0" style="width: 18rem;">
                        <img src="<?= $get_image ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?= get_the_title() ?><?php
                                if (get_field('projeto_concluido')) {
                                    echo '<span class="position-absolute top-0 start-100 translate-middle px-1 bg-success border border-light rounded-3 shadow">
                                          <span class="text-light"><i class="bi bi-check"></i></span>
                                          </span>';
                                } else {
                                    echo '<span class="position-absolute top-0 start-100 translate-middle px-1 bg-warning border border-light rounded-3 shadow">
                                          <span class="text-light"><i class="bi bi-caret-right-fill"></i></i></span>
                                          </span>';
                                }
                                ?></h5>
                            <span class="card-text"><?= get_post_status() ?></span>
                            <p class="card-text"><?= get_the_excerpt() ?></p>
                            <span class="card-text"><?= get_the_date() ?></span>
                            <button type="button" class=" mt-2 btn btn-primary w-100"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modal-<?= get_the_ID() ?>">
                                Detalhes <?php
                                if (get_approved_comments(get_the_ID())) {
                                    echo '<i class="bi bi-chat-dots-fill"> ' . count(get_approved_comments(get_the_ID())) . ' </i>';
                                }
                                ?>
                            </button>
                        </div>
                    </div>

                    <div class="modal fade"
                         id="modal-<?= get_the_ID() ?>" tabindex="-1"
                         aria-labelledby="modal-<?= get_the_ID() ?>Label"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                            <div class="modal-content overflow-auto">
                                <div class="modal-header">
                                    <h3 class="fw-bold"><?= get_the_title() ?></h3>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <img src="<?= $get_image ?>" alt="">
                                <div class="container">
                                    <p class="px-2 mt-4"><?= get_the_excerpt() ?></p>
                                </div>
                                <ul class="list-group p-2">
                                    <?php

                                    foreach ($get_tasks as $task) {
                                        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
                                        echo $task['value'];
                                        echo '<span class="badge bg-primary rounded-pill"><i class="bi bi-check-all"></i></span>
                                    </li>';
                                    }
                                    ?>
                                </ul>
                                <?php
                                foreach (get_approved_comments(get_the_ID()) as $comment) {
                                    echo '<p class="px-4 text-break">' . $comment->comment_author . ' Comentou: ' . $comment->comment_content . '</p>';
                                }
                                ?>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php
                endwhile;
                wp_reset_postdata(); // Restaura os dados do post original
            else :
                // Caso não haja posts
                echo 'Nenhum projeto encontrado.';
            endif;
            ?>
        </div>
    </div>

    <div class="container flex text-center mt-5">
        <button id="load-more-projects" class="btn btn-primary">Carregar Mais</button>
    </div>

    <script>
        let page = 2; // Próxima página a ser carregada
        const maxPages = <?= $query->max_num_pages ?>; // Número máximo de páginas

        jQuery('#load-more-projects').on('click', function () {
            if (page <= maxPages) {
                const data = {
                    action: 'load_more_projects',
                    page: page,
                };

                jQuery.post(ajaxurl, data, function (response) {
                    jQuery('#projects-container').append(response);
                    page++;
                    if (page > maxPages) {
                        jQuery('#load-more-projects').hide();
                    }
                });
            }
        });
    </script>
    <?php
}

// Função para carregar mais projetos
add_action('wp_ajax_load_more_projects', 'load_more_projects');
add_action('wp_ajax_nopriv_load_more_projects', 'load_more_projects');

function load_more_projects()
{
    $args = array(
        'post_type' => 'projeto', // Nome do seu CPT
        'posts_per_page' => 8,   // Número de projetos por página
        'paged' => $_POST['page'], // Próxima página
        'orderby' => 'date',      // Ordenar por data (você pode alterar isso para suas necessidades)
        'order' => 'DESC',        // Ordem decrescente (do mais recente para o mais antigo)
    );

    $query = new WP_Query($args);

    ob_start();

    if ($query->have_posts()) :
        while ($query->have_posts()) :
            $query->the_post();
            // Exibir os cartões aqui
            $get_image = get_field('imagem_do_projeto');
            ?>

            <div class="card p-0" style="width: 18rem;">
                <img src="<?= $get_image ?>" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title"><?= get_the_title() ?></h5>
                    <span class="card-text"><?= get_post_status() ?></span>
                    <p class="card-text"><?= get_the_excerpt() ?></p>
                    <span class="card-text"><?= get_the_date() ?></span>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal-<?= get_the_ID() ?>">
                    Detalhes
                </button>
            </div>

            <div class="modal fade" id="modal-<?= get_the_ID() ?>" tabindex="-1"
                 aria-labelledby="modal-<?= get_the_ID() ?>Label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <img src="<?= $get_image ?>" alt="">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        <?php
        endwhile;
        wp_reset_postdata(); // Restaura os dados do post original
    endif;

    $response = ob_get_clean();
    echo $response;
    wp_die();
}
