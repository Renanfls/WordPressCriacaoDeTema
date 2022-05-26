<?php

// Atribui a opção 'Países' dentro do Post Customizado 'Destinos' que permite adicionar categorias 
function registrando_taxonomia()
{
    register_taxonomy(
        'paises',
        'destinos',
        array(
            'labels' => array('name' => 'Países'),
            'hierarchical' => true
        )
    );
}
add_action('init', 'registrando_taxonomia');


// Função que adiciona um Post Customizado 'Destinos' no menu do Painel WP
function registrando_post_customizado()
{
    register_post_type(
        'destinos',
        array(
            'labels' => array('name' => 'Destinos'),
            'public' => true,
            'menu_position' => 0,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-admin-site'
        )
    );
}
add_action('init', 'registrando_post_customizado');


function registrando_post_customizado_banner()
{
    register_post_type(
        'banners',
        array(
            'labels' => array('name' => 'Banner'),
            'public' => true,
            'menu_position' => 1,
            'supports' => array('title', 'thumbnail'),
            'menu_icon' => 'dashicons-format-image'
        )
    );
}
add_action('init', 'registrando_post_customizado_banner');


// Função responsével por adicionar o campo dentro do post customizado 'Banner' onde o usuário o Texto 
function registrando_metabox()
{
    add_meta_box(
        'ai_registrando_metabox',   // $id
        'Texto para a home',        // $title
        'ai_funcao_callback',       // $callback
        'banners'                   // $screen
    );
}
// Action hook especifica para metabox
add_action('add_meta_boxes', 'registrando_metabox');

// Função que adiciona os campos de input recebendo o parâmetro $post do WP
function ai_funcao_callback($post)
{
    // Função do WP responsável por pegar os dados salvos do input texto_home_1
    $texto_home_1 = get_post_meta(
        $post->ID,          // $id
        '_texto_home_1',    // $key
        true                // $single
    );

    // Função do WP responsável por pegar os dados salvos do input texto_home_2
    $texto_home_2 = get_post_meta(
        $post->ID,          // $id
        '_texto_home_2',    // $key
        true                // $single
    );

    ?>
    <label for="texto_home_1">Texto 1</label>
    <input type="text" name="texto_home_1" style="width: 100%" value="<?= $texto_home_1 ?>">
    <br>
    <br>
    <label for="texto_home_2">Texto 2</label>
    <input type="text" name="texto_home_2" style="width: 100%" value="<?= $texto_home_2 ?>">
    <?php
}


// Função responsável por salvar os dados metabox assim que selecionar a opção publicar
function salvando_dados_metabox($post_id)
{
    // Quebra os dados recebidos na chaves e valores
    foreach($_POST as $key=>$value) {
        // Se a chave for diferente de ambas a condições é porque é um dado do WP e ele que cuida do tratamento
        if($key !== 'texto_home_1' && $key !== 'texto_home_2') {
            continue;
        }

        // Função responsável por armazenar os dados no Banco de Dados do projeto
        update_post_meta(
            $post_id,       // $id
            '_' . $key,     // $meta_key
            $_POST[$key]    // Pega o valor de cada uma das chaves

        );
    }
}
// Action Hook responsável por salvar os posts
add_action('save_post', 'salvando_dados_metabox');


// Função responsável por dar suporte a logos customizados e imgs de Posts e págs.
function adicionando_recursos_ao_tema()
{
    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
}
// A função só será carregada somente depois que o WP inicializar os temas 
add_action('after_setup_theme', 'adicionando_recursos_ao_tema');


// Função responsável por Adicional o botão menu no Painel do WP
function resgistrando_menu()
{   
    register_nav_menu(
        'menu-navegacao',
        // Descrição exibida na parte de Configurações do menu no Painel do WP
        'Menu navegação'
    );
}
// Assim que WP inicializar a função será executada através da action hook 'init'
add_action('init', 'resgistrando_menu');


function pegandoTextosParaBanner()
{
    $args = array(
        'post_type' => 'banners',   // Tipo de post a ser consultado
        'post_status' => 'publish', // Considerar apenas posts publicados
        'posts_per_page' => 1       // Limita para apenas aparecer 1 banner, sendo referenciado sempre o banner do ultimo post
    );
    $query = new WP_Query($args);
    if($query->have_posts()):
        while($query->have_posts()): $query->the_post();
                $texto1 = get_post_meta(get_the_ID(), '_texto_home_1', true);
                $texto2 = get_post_meta(get_the_ID(), '_texto_home_2', true);
                return array(
                    'texto_1' => $texto1,
                    'texto_2' => $texto2,       
                );
        endwhile;
    endif;
}


function adicionando_scripts()
{

    $textosBanner = pegandoTextosParaBanner();

    // Verifica se o usuário está na home
    if(is_front_page()){
        // Função do WP responsável por carregar os arquivos .js
        wp_enqueue_script(
            'typed-js',                                             // $handle - nome que queremos dar ao arqv. .js que estamos adicionando
            get_template_directory_uri() . '/js/typed.min.js',      // $src - Caminho do arqv.
            array(),                                                // $deps - Se o arqv. depende de outro arqv. para executar - Do tipo array()
            false,                                                  // $ver - Se estamos trabalhando com versionamento
            true                                                    // $in_footer - Se o arqv. deve ser carregado no rodapé ou não
        );  
        wp_enqueue_script(
            'texto-banner-js',                                         // $handle - nome que queremos dar ao arqv. .js que estamos adicionando
            get_template_directory_uri() . '/js/texto-banner.js',      // $src - Caminho do arqv.
            array('typed-js'),                                         // $deps - Se o arqv. depende de outro arqv. para executar - Do tipo array()
            false,                                                     // $ver - Se estamos trabalhando com versionamento
            true                                                       // $in_footer - Se o arqv. deve ser carregado no rodapé ou não
        );
        // Função do WP responsável por localizar um arqv. JS que já tenha sido adicionado, podendo passar variáveis para esse arqv.
        wp_localize_script(
            'texto-banner-js',      // $handle - referencia do arqv. que vai ser passado os dados dinâmicos
            'data',                 // $object_name - nome que queremos referenciar dentro o arqv. 'texto-banner-js'
            $textosBanner           // Valor que queremos passar para o arqv. 'texto-banner-js'
        );
    }
}
add_action('wp_enqueue_scripts', 'adicionando_scripts');