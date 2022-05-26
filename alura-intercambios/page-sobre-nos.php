<?php
$estiloPagina = 'sobre_nos.css';
require_once 'header.php';

// Se tive conteudo quanto post ou pág.
if(have_posts()):
    ?>
    <main class="main-sobre-nos">
        <?php
        // O Loop Wordpress, função responsável por pegar o conteudo do Painel Administrativo do WordPress
        // Enquanto tive conteudo ele é exibido, referenciando(:) cada post
        while(have_posts()): the_post();
            // Função do WP responsável por pegar a imagem
            the_post_thumbnail('post-thumbnail', array('class' => 'imagem-sobre-nos'));
            echo '<div class="conteudo container-alura">';
            // Função do WP responsável por pegar o titulo
            the_title('<h2>', '</h2>');
            // Função do WP responsável por pegar o conteudo
            the_content();
            echo'</div>';
        endwhile;
        ?>
    </main>
<?php    
endif;
require_once 'footer.php';
