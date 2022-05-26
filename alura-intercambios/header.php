<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- bloginfo('name') Imprime o nome do titulo do site dado no painel Admin do WordPress -->
    <title><?php bloginfo('name') ?></title>

    <!-- Função responsável por inserir códigos do WordPress para que o sistema funcione de maneira adequada -->
    <!-- Adiciona a barra adiministrativa do WordPress -->
    <?php wp_head(); ?>

    <!-- Referenciando arquivos de estilos -->
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/normaliza.css' ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/bootstrap.css' ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/header.css' ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/' . $estiloPagina ?>">
    <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/footer.css' ?>">

</head>
<body <?php body_class(); ?>>
<header class="site-header">
    <div class="container-alura">
        <?php
        // Função responsável por exibir o logo na pág.
        the_custom_logo();
        ?>
        <nav>
            <?php 
            // Função responsável por exibir o menu de navegação na pág
            wp_nav_menu(
                array(
                    'menu' => 'menu-navegacao',
                    'menu_id' => 'menu-principal'
                )
            );
            ?>
        </nav>
    </div>
</header>
