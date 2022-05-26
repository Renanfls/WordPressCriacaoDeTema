**Para acessar o tema siga os seguintes passos:**

1. Painel administrativo do WordPress
2. Aparência
3. Temas

#
# **Criação de tema**

## **Passo a passo**

Caminho para acessar a pasta do seu projeto:

- Exemplo utilizando **XAMPP**: `C:\xampp\htdocs\pasta-do-seu-projeto`

- Exemplo utilizando **Local WP**: `C:\Users\pasta-do-seu-usuário\Local Sites\pasta-do-seu-projeto`

1. Abrir pasta do projeto em um editor de texto
2. Acessar pasta `wp-content`
3. Acessar pasta `themes`
4. Criar uma pasta com o nome do tema dentro da pasta `themes`
5. Dentro dessa pasta deve conter um arquivo `style.css` e `index.php`

## **Adicionando Informações Sobre o Tema**

Dentro do arquivo `style.css` adicione dentro de um comentario o `Theme Name:`, `Author:`, `Description:`,
`Version:`, `Tags:`.

**EX.:**

<code>
/* 

Theme Name: Alura Intercâmbios

Author: Renan Fabricio Lima da Silva

Description: Tema customizado para a Alura 
Intercâmbios

Version: 1.0.0

Tags: cursos, idiomas, intercâmbios, viagens

*/
</code>

## **Colocando Imagem Customizada do Tema**

A imagem que vai ser utilizada deve estar renomeada como `screenshot`

E deve estar dentro da pasta do Tema que estamos criando

# **Header e Footer**

1. Criar dentro da pasta do tema que estamos criando, os arquivos `header.php` e `footer.php`

## **Criando Header**

2. Dentro do `header.php` crie a base de um HTML
3. Dentro da tag `<title>` abra e feche a tag PHP `<?php ?>`
4. Dentro da tag PHP chame a função `bloginfo()` e passe como parâmetro o `name`

`bloginfo()` é uma função utilizada para buscarmos informações de forma dinâmica do site que estamos desenvolvendo no Wordpress e uma dessas informações é o nome do site. 

Passando o parâmetro `name` é possível pegar o nome do site dado no Painel Administrativo do WordPress sem ter que ficar mexendo no código caso o nome do site seja alterado pelo Admin do Site no Painel

**Ex.:**

<code>

    `<title><?php bloginfo('name') ?></title>`
</code>

#

5. Logo abaixo da tag `<title>` abra e feche novamente a tag PHP
6. Dentro dela adicione `wp_head();`

`wp_head();` é uma função responsável por inserir códigos do WordPress para que o sistema funcione de maneira adequada. Essa função adiciona a barra administrativa do WordPress

**Ex.:**

<code>

    `<?php wp_head(); ?>`
</code>

#

## **Criando footer**

7. Retire o fechamento das tags `</body>` e `</html>` do arquivo `header.php` e adicione no arquivo `footer.php`
8. Logo após o fechamento da tag `</body>` abra e feche a tag PHP
9. Dentro dela chame a função `wp_footer();`

**Ex.:**

<code>

    </body>
    <?php wp_footer(); ?>
    </html>
</code>

#

## **Adicionando opção menu no Painel do WP**

Por padrão quando criamos temas o WordPress não consegue saber se nesse tema que vamos criar irá ter um menu, por isso ele não adiciona no painel e pra isso temos que seguir os adiante:

10. Criar dentro da pasta do tema o arquivo com nome `functions.php`
11. criar uma função que chama a função `register_nav_menu( $location, $description)` essa função espera receber os parâmetros `$location` e `$description`

Nosso parâmetro `$location` será `'menu-navegacao'` e o parâmetro `$description` será `'Menu navegação'`

**EX.:**

<code>

    function resgistrandoMenu()
    {
        register_nav_menu(
            'menu-navegacao',
            'Menu navegação'
        );
    }
</code>

#

## **Executando funções com Action Hook**

12. Logo após a função adicione a action hook `add_action('init', 'resgistrandoMenu');`

**action hook** é uma ação que engancha uma função

https://codex.wordpress.org/Plugin_API/Action_Reference

`add_action()` Adiciona uma ação e recebe como primeiro parâmetro a action hook que desejamos vamos usar a `'init'` poís queremos que a função seja executada assim que o WordPress é inicializado, e como segundo parâmetro passamos a função que queremos que seja executada `'resgistrandoMenu'`

**EX.:**

<code>

    `add_action('init', 'resgistrandoMenu');`
</code>

#

## **Função responsável por exibir Menu**

13. No arquivo `header.php` logo após o `<body>` abra a tag PHP 
14. Logo abaixo chama a função `wp_nav_menu()`
15. passe como parâmetro o `array( 'menu' => 'menu-navegacao')`

`wp_nav_menu( $args = array() )` é a função do WP responsável por exibir o menu na página e recebe como parâmetro uma variável `$args` que é do tipo `array()` em seguida dentro do array passamos a chave `'menu'` e referenciamos(`=>`) com o valor `'menu-navegacao'` que é a localização que passamos como parâmetro anteriormente na função `register_nav_menu` que está presente no arquivo `functions.php`

**EX.:**

<code>

    wp_nav_menu(
        array(
            'menu' => 'menu-navegacao'
        )
    );
</code>

#

## **Função que da suporte a logos customizados**

16. Adicionar uma nova função do WP chamada `add_theme_support( $feature, ...$args )` função responsável por dar suporte a logos customizados
17. Em seguida devemos passar como parâmetro uma `$feature`(recurso) que é `custom-logo`(recurso já predefinido pelo WordPress para dar suporte a logos customizados)
18. Logo após a função adicionamos o action hook `'after_setup_theme'` que é responsável por executar a função somente depois que o WordPress inicializar os Temas e depois enganchamos a função `'adicionando_recursos_ao_tema'`

**EX.:**

<code>

    `add_action('after_setup_theme', 'adicionando_recursos_ao_tema');`
</code>
#

## **Função responsável por exibir o Logo**

19. No arquivo `header.php` devemos definir a função do WP `the_custom_logo()` antes da função `wp_nav_menu()`

**EX.:**

<code>

    <?php
    the_custom_logo();
    wp_nav_menu(
        array(
            'menu' => 'menu-navegacao'
        )
    );
</code>

#
## **Referenciando arquivos de estilos**

20. Criar um novo diretório chamado `css` na pasta do tema
21. Mover os arquivos `bootstrap.css`, `header.css` e `normalize.css`
22. Voltamos pra o arquivo `header.php` e logo depois de `<?php wp_head(); ?>` abrimos a tag `<link rel="stylesheet" href="">` para referenciarmos os arquivos de estilo
23. Dentro do `href=""` devemos abrir e fechar a tag PHP `<?= ?>` essa é uma forma que identifica que virá execuções html dentro. Logo dentro da tag, chamamos a função do WP `get_template_directory_uri()`
responsável por imprimir o caminho do diretório raiz do tema que estamos criando, logo depois vamos concatenar(`.`) com `'/css/normalize.css'`. Devemos referenciar o arquivo `normalize.css` primeiro, pós ele é o responsável por retirar configurações de estilos padrões aplicados pelo navegador.
24. E em seguinda referenciamos os arquivos `bootstrap.css` e `header.css`

**EX.:**

<code>

    <?php wp_head(); ?>
        <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/normaliza.css' ?>">
        <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/bootstrap.css' ?>">
        <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/header.css' ?>">
</code>

#
## **Adicionando `class` do WP no Body**

25. No arquivo `header.php` dentro da tag `<body>` abra e feche a tag PHP
26. Dentro da tag PHP adicione a função do WP `body_class();`

#
## **Adicionando `<header>` + `class`**

27. Logo abaixo da tag `<body>` adicione a tag `<header>` e em seguida atribua a class com a sua estilização

**Ex.:**

<code>

    <body <?php body_class(); ?>>
    <header class="nome-da-sua-class">
</code>

#
## **Adicionando `<div>`**

28. Logo abaixo da tag `<header>` adicione a tag `<div>` e em seguida atribua a class com a sua estilização
29. Passe a tag PHP junto com a função do WP `the_custom_logo();` para dentro da `<div`

**Ex.:**

<code>

    <div class="nome-da-sua-class">
        <?php
        the_custom_logo();
        ?>
    </div>
</code>

## **Adicionando `<nav>`**

30. Dentro da `<div>`, de baixo da tag PHP, adicione a tag `<nav>`
31. Passe a tag PHP junto com a função do WP `wp_nav_menu()` para dentro da tag `<nav>`
32. Para definir um `id=""` para tag `<nav>` inclua um segundo argumento dentro do array localizado dentro da função `wp_nav_menu()` passando como chave `menu_id` e referenciando(`=>`) com o valor sendo o nome do `id`

**Ex.:**

<code>

    <?php
    the_custom_logo();
    ?>
    <nav>
        <?php 
        wp_nav_menu(
            array(
                'menu' => 'menu-navegacao',
                'menu_id' => 'menu-principal'
            )
        );
        ?>
    </nav>
</code>

## **Resultado Final do código do header:**

<code>

    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title><?php bloginfo('name') ?></title>

        <?php wp_head(); ?>

        <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/normaliza.css' ?>">
        <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/bootstrap.css' ?>">
        <link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/header.css' ?>">

    </head>
    <body <?php body_class(); ?>>
    <header class="site-header">
        <div class="container-alura">
            <?php
            the_custom_logo();
            ?>
            <nav>
                <?php 
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
</code>

## **Adicionando Opção de imagens em páginas e posts no Painel do WP**

33. No arquivo `functions.php` dentro da função `adicionando_recursos_ao_tema()` adicione mais uma função `add_theme_support()` passando como parâmetro a recurso `'post-thumbnails'`

## **Pegando conteúdo do Painel Administrativo e exibindo**

### **Loop WordPress**

Responsável por mostrar conteúdo de posts e páginas.

Depois de criar uma Página ou post colocando o **titulo**, **imagem** e **conteúdo** temos que configurar o WP para que ele capture as informações do painel administrativo e exiba na pág. ou post. Pra isso temos que ir no arquivo `index.php` e adicionar o **Loop WordPress**

34. Dentro do arquivo `index.php` abaixo de `require_once 'header.php';` adicione o seguinte código:

<code>

    <?php
    require_once 'header.php';

    // Se tive conteúdo quanto post ou pág.
    if(have_posts()):
        // O Loop Wordpress, função responsável por pegar o conteúdo do Painel Administrativo do WordPress
        // Enquanto tive conteúdo ele é exibido, referenciando(:) cada post
        while(have_posts()): the_post();
            // Função do WP responsável por pegar a imagem
            the_post_thumbnail();
            // Função do WP responsável por pegar o titulo
            the_title();
            // Função do WP responsável por pegar o conteúdo
            the_content();
        endwhile;
    endif;

    require_once 'footer.php';
</code>

## **Atribuindo Estilo no conteúdo**

35. Vamos adicionar o arquivo de estilização da página `sobre_nos.css` dentro da pasta `css`
36. No arqv. `header.php` vamos referenciar o novo arquivo `sobre_nos.css`, logo abaixo dos outro, pós queremos que essa estilização seja aplicada apenas na página sobre nós, para isso temos que deixar da seguinte maneira:

<code>

    `<link rel="stylesheet" href="<?= get_template_directory_uri() . '/css/' . $estiloPagina ?>">`
</code>

37. No arqv. `index.php` antes do `require_once 'header.php';` criamos a variável `$estiloPagina` recebendo o caminho até o arquivo de estilização da página sobre nós

**EX.:**
<code>

    `$estiloPagina = 'sobre_nos.css';`
</code>

38. Vamos agora adicionar a tag `<main>` que irá receber todo o conteúdo, e logo em seguida já aplicando a class com a estilização
39. Dentro da tag `<main>` vamos abrir e fechar a tag PHP e adicionar **Loop WordPress** dentro 
40. Passaremos os parâmetros para a função `the_post_thumbnail( $size = 'post-thumbnail', $attr = '')` sendo o 1° parâmetro `$size` que é o tamanho da imagem, por padrão o WP define como `'post-thumbnail'`(Tamanho padrão da imagem colocada no Painel) e o 2° parâmetro `$attr = ''` são os atributos sendo do tipo `array` nesse caso atribuimos a chave `'class'` e o valor sendo `'nome-da-sua-class'`

**EX.:**

<code>

    `the_post_thumbnail('post-thumbnail', array('class' => 'nome-da-sua-class'));`
</code>

41. Logo em baixo da função `the_post_thumbnail()` adicionaremos um `echo '<div class="nome-da-sua-class">';` responsável por exibir o conteudo da `<div>`

**EX.:**

<code>

    the_post_thumbnail('post-thumbnail', array('class' => 'imagem-sobre-nos'));
    echo '<div class="conteudo container-alura">';
</code>

42. Na função `the_title( $before, $after )` passaremos o `<h2>` como o 1° argumento e o `</h2>` como o 2° argumento, assim envolvendo o titulo com a tag `h2`
43. Logo depois da função `the_content();` colocamos o fechamento da `</div>` com o `echo`

**Resultado final até o momento**

<code>

    if(have_posts()):
        ?>
        <main class="main-sobre-nos">
            <?php
            while(have_posts()): the_post();
                the_post_thumbnail('post-thumbnail', array('class' => 'imagem-sobre-nos'));
                echo '<div class="conteudo container-alura">';
                the_title('<h2>', '<h2>');
                the_content();
                echo'</div>';
            endwhile;
            ?>
        </main>
    <?php    
</code>

## **Criando footer**

44. Adicionar arquivo da estilização do footer na pasta `css`
45. Referenciar ele no arquivo `header.php`
46. No arquivo `footer.php` antes da tag `</body>` vamos criar abrir e fechar a tag `<footer>`
47. Dentro da tag `<footer>` vamos incluir um paragrafo adicionar o simbolo do copy `&copy;`
48. Logo em seguida na mesma linha abrimos e fechamos a tag PHP `<?= ?>` e detro dela chamamos a função do PHP `date()` que vai refletir o ano em que estamos visitando o site

<code>

    <footer>
        <p class="container-alura">&copy; <?= date("Y") ?> - Todos os direitos reservados a Alura Intercâmbios</p>
    </footer>
    </body>
    <?php wp_footer(); ?>
    </html>
</code>

## **Hierarquia dos templates**

https://codex.wordpress.org/pt-br:Hierarquia_de_Modelos_WordPress

Se retirar todo o conteúdo do `index.php` e passar para um arquivo mais especifíco sendo `page-$slug.php` esse arquivo será mais especifíco que o `index.php`. E caso esse arquivo `page-$slug.php` não exista o WP tenta achar o arquivo mais especifíco, que no caso seria o `index.php`, e resultaria em uma página em branco, pós o arqv. `index.php` está vazio.

## **Posts customizados**

Adicionando função personalizada na barra lateral esquerda do Painel Admin do WP

49. No arquivo `functions.php` adicione uma função com o nome `registrando_post_customizado()`
50. Dentro dela chame a função do WP `register_post_type( $post_type, $args = array() )` em que o 1° parâmetro - é a chave indentificação do post customizado em que não pode exceder mais que 20 caracteres, devendo ter apenas letras minusculas, caracteres alfanumericos, com ifens, underlines - e o 2° parâmetro são a funcionalidades que serão aplicadas, e cada funcionalidade é definida por uma chave de identificação especificada dentro do `array()`

**Chaves de identicação:**

`'labels'` Define qual o nome será exibido no menu lateral esquerdo do Painel sendo passado por um `array('name' => 'nome-desejado')`

**EX.:**

<code>

    'labels' => array('name' => 'Destinos'),
</code>

`'public'` Indica a visibilidade para administradores do site e deve receber valor do tipo boolean

**EX.:**

<code>

    // Todos os Adms do site teram acesso
    'public' => true,
</code>

`'menu_position'` Define a posição que irá aparecer no menu 

**EX.:**

<code>

    // Aparece na primeira posição do menu
    'menu_position' => 0,
</code>

`'supports'` Indica quais suportes irá fornecer quando acessado. Deverá ser declarado dentro de um array

**EX.:**

<code>
    // Nesse caso poderá editar: 'title'(titulo), 'editor'(descrição), 'thumbnail'(imagem)
    'supports' => array('title', 'editor', 'thumbnail'),
</code>

`'menu_icon'` Indica qual icone irá aparecer ao lado do nome do post personalizado

**EX.:**

<code>

    // Adiciona um icone de mapa
    'menu_icon' => 'dashicons-admin-site'
</code>

**Resultado Final:**

<code>

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
</code>

## **Taxonomia**

Nomenclatura utilizada para agrupar posts de acordo com alguma característica em comum.

51. No arquivo `functions.php` adicione uma nova função `registrando_taxonomia()`
52. Dentro dela adicione a função do WP `register_taxonomy()` passando com 1° argumento o identificador, como 2° argumento passe o identificador do post customizado em que a taxonomia será adicionada, como 3° argumento passe o `array()` passe a chave `'labels' => ('name' => 'nome-desejado')` aplique uma segunda chave `'hierarchical' => true`

<code>

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
</code>

## **Configurando página destinos**

53. No arqv. `page-destinos.php` temos que adicionar um `require_once 'header.php'` e `require_once 'footer.php'`
54. Entre os requires adicione o **Loop WordPress**
55. Dentro do loop adicione as funções `the_post_thumbnail();`, `the_title();` e `the_content();`

## **`WP_Query()`**

Consulta personalizada

56. Logo a cima do loop iremos adicionar as variáveis com a consulta personalizada
57. O construtor espera receber a costumização que desejamos fazer e devemos passar em forma de `string/array`

<code>

    $args = array('post_type' => 'destinos');
    $query = new WP_Query($args);
</code>

`'post_type'` é a chave utilizada quando queremos referenciar um post customizado, e passamos como valor `destinos`, mesmo nome que declaramos quando registramos o post customizado

Passamos a costumização para o construtor do `WP_Query()` através da variável `$args`

58. Agora temos que vincular(`->`) a consulta personalizada com o `have_posts()` e `the_post()`:

<code>

    $args = array('post_type' => 'destinos');
    $query = new WP_Query($args);

    if($query->have_posts()):
        while($query->have_posts()): $query->the_post();
</code>

59. Abrimos a tag `<main class="sua-class">` com o `echo` logo depois da condição `if`
60. Logo abaixo abrimos a tag `<ul class="sua-class">` com o `echo`
61. Depois do fechamento do `while` fechamos a tag `ul` com o `echo`
62. E em seguida fechamos a tag `main` com o `echo`
63. Dentro do `while` no inicio abrimos a tag `li` passando a class `col-md-3` do bootstrap junto com a `sua-class`
64. dentro da função `the_title($before, $after)` no `$before` passamos a abertura da tag `p` e no `$after` passamos o fechamento da tag `p`
65. Logo após as funções do WP dentro do `while` fechamos a tag `li` com o `echo`

**Resultado até o momento do arquivo `page-destinos.php`:**

<code>

    <?php
    $estiloPagina = 'destinos.css';
    require_once 'header.php';

    $args = array('post_type' => 'destinos');
    $query = new WP_Query($args);

    if($query->have_posts()):
        echo '<main class="page-destinos">';
        echo '<ul class="lista-destinos container-alura">';
        while($query->have_posts()): $query->the_post();
            echo '<li class="col-md-3 destinos">';
            the_post_thumbnail();
            the_title('<p class="titulo-destino"', '</p>');
            the_content();
            echo '</li>';
        endwhile;
        echo '</ul>';
        echo '</main>';
    endif;
    require_once 'footer.php';
</code>

## **Formulário**

Pegando nome das taxonomias de forma dinâmica com a função `get_terms($query = '')` que pode retornar um **array()**, **int** ou **Error**. O contrutor dessa função espera receber um `$query` do tipo `array()` como queremos o nome das taxonomias usaremos a chave `'taxonomy'` passando como valor identificador que atribuimos na função `register_taxonomy()` que seria `paises`

<code>

    <form action="#" class="container-alura formulario-pesquisa-paises">
    <h2>Conheça nossos destinos</h2>
    <select name="paises" id="paises">
        <option value="">--Selecione--</option>
        <?php
            get_terms(array('taxonomy' => 'paises'));
        ?>
    </select>
    <input type="submit" value="Pesquisar">
    </form>
</code>

`get_terms(array('taxonomy' => 'paises'));` trás os dados da taxonomia `'paises'` e imprime o campo nome de um deles

Para conseguirmos pegar o nome de cada país é necessário utilizar o `foreach`, mas antes disso vamos colocar a função `get_terms(array('taxonomy' => 'paises'));` dentro da variável `$paises` e assim passarmos a condição para o `foreach`

<code>

    <form action="#" class="container-alura formulario-pesquisa-paises">
    <h2>Conheça nossos destinos</h2>
    <select name="paises" id="paises">
        <option value="">--Selecione--</option>
        <?php
            $paises = get_terms(array('taxonomy' => 'paises'));
            foreach($paises as $pais):?>
                <option value="<?= $pais->name ?>"><?= $pais->name ?></option>
            <?php endforeach;
        ?>
    </select>
    <input type="submit" value="Pesquisar">
    </form>
</code>

Verificando as informações retornadas pelo array da função `get_terms(array('taxonomy' => 'paises'));`

<code>

    echo '<pre>';
    $paises = get_terms(array('taxonomy' => 'paises'));
    print_r($paises)
    echo '</pre>';
</code>

Através do array gerado da taxonomia fazemos a filtragem `$pais->name` e pegamos apenas o atributo name, que contém o nome dos paises e exibimos dentro das opções

Quando o valor retornado pelo array for um objeto usamos `->` e quando o valor retornado for um array usamos `[]`

## **Filtrando categorias**

No do arquivo `page-destinos.php` dentro da variável `$args` vamos passar mais uma chave dentro do array que será `'tax_query'` responsável por realizar as consultas refente as taxonomias e passamos como valor a `$paisSelecionado` onde irá conter todas as informações necessárias para que seja feita filtragem

<code>

    $paisSelecionado = array(array(
        'taxonomy' => 'paises',
        'field' => 'name',
        'terms' => $_GET['paises']
    ));

    $args = array(
        'post_type' => 'destinos',
        'tax_query' => $paisSelecionado
    );
</code>

Chaves passadas no array da variável `$paisSelecionado`:

`''taxonomy''` seguido do valor `'paises'` pois queremos aplicar a filtragem nessa taxonomia

`'field'` seguido do valor `'name'` para que possamos pegar apenas o campo nome

`'terms'` seguido do valor `$_GET['paises']` que será responsável por pegar a requisição atráves da URL

**EX.:**

http://alura-intercambios.local/destinos/?`paises=Austrália#`

## **Resolvendo problema da opção `--Selecione--` no campo de busca**

Essa opção quando ativa deverá mostrar todos os países novamente

Para que isso seja resolvido devemos envolver a variável `$paisSelecionado` dentro de uma condição `if` verificando se a requisição `$_GET['paises']` não for vazia(`!empty`)

**EX.:**

<code>

    if(!empty($_GET['paises'])) {
        $paisSelecionado = array(array(
            'taxonomy' => 'paises',
            'field' => 'name',
            'terms' => $_GET['paises']
        ));
    }
</code>

Em seguida na variável `$args` no valor da chave `tax_query` temos que atribuir um `if ternário` que irá validar se o usuário filtrou algum país ou se ele colocou a opção **--Selecione--**. Caso tenha selecionado a opção **--Selecione--** o seu valor recebido será nulo `''`

<code>

    $args = array(
        'post_type' => 'destinos',
        'tax_query' => !empty($_GET['paises']) ? $paisSelecionado : ''
    );
</code>

**Ajustando para que quando o usuário selecione uma opção desejada, essa mesma opção selecionada seja mostrada, em vez de permanecer a opção `--Selecione--`**

Para isso temos que volta na tag `option` que está presente no formulário e fazer algumas configurações

<code>

    <option value="<?= $pais->name ?>"
    <?= !empty($_GET['paises']) && $_GET['paises'] === $pais->name ? 'selected' : '' ?>
    ><?= $pais->name ?></option>
</code>

## **Retirando o `/home/` da URL da pág. principal**

No painel admin do WP vá em:
1. Configurações
2. Leitura
3. Na opção **Sua página inicial exibe** marque a opção de pág. estática e atribua na opção **Página inicial:** sendo a pág. da **Home**

Agora para que o WP identifique a pagina frontal(principal) é necessario o arquivo `front-page.php`

## **Configurando Metabox**

Criamos uma nova função `registrando_metabox()` e dentro dela chamamos a função do WP `add_meta_box('id', 'title', 'callback', 'screen')`

<code>

    function registrando_metabox()
    {
        add_meta_box(
            'ai_registrando_metabox',   // id
            'Texto para a home',        // title
            'ai_funcao_callback',       // callback
            'banners'                   // screen
        );
    }
</code>

Agora precisamos criar a função `ai_funcao_callback` que será responsável por adicionar os campos de input para o usuário adicionar os textos. E essa função recebe `$post` como parâmetro diretamento do WordPress

<code>

    function ai_funcao_callback($post)
    {
        ?>
        <label for="texto_home_1">Texto 1</label>
        <input type="text" name="texto_home_1" style="width: 100%">
        <br>
        <br>
        <label for="texto_home_2">Texto 2</label>
        <input type="text" name="texto_home_2" style="width: 100%">
        <?php
    }
</code>

## **Salvando dados metabox**

Vamos criar a função `salvando_dados_metabox()` passando como parâmetro a variável responsável por armazenar o id que será gerado pelo WP assim que publicarmos os textos adicionado no Painel Admin, dentro do post customizado **Banner**

<code>

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
                $post_id,       // id
                '_' . $key,     // meta_key
                $_POST[$key]    // Pega o valor de cada uma das chaves

            );
        }
    }
    // Action Hook responsável por salvar os posts
    add_action('save_post', 'salvando_dados_metabox');
</code>

Agora vamos adicionar algumas alterações na função `ai_funcao_callback()` para que quando usuário clicar em publicar, o post continue aparecendo o texto que ele digitou nos inputs, assim fazendo com que ele não pense que o conteúdo que ele adicionou não tenha sido salvo

<code>

    function ai_funcao_callback($post)
    {
        // Função do WP responsável por pegar os dados salvos do input texto_home_1
        $texto_home_1 = get_post_meta(
            $post->ID,          // id
            '_texto_home_1',    // key
            true                // single
        );

        // Função do WP responsável por pegar os dados salvos do input texto_home_2
        $texto_home_2 = get_post_meta(
            $post->ID,          // id
            '_texto_home_2',    // key
            true                // single
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
</code>

## **Trazendo imagem banner**

Vamos adicionar o arquivo de estilo da home e referenciar ele em seguida
no arquivo `front-page.php` e a cima de `require_once 'header.php';` vamos a chamar o arquivo de estilização `$estiloPagina = 'home.css'` que será carregado quando a pág. for acessada

<code>

    <?php
    $estiloPagina = 'home.css';
    require_once 'header.php';

    $args = array(
        'post_type' => 'banners',   // Tipo de post a ser consultado
        'post_status' => 'publish', // Considerar apenas posts publicados
        'posts_per_page' => 1       // Limita para apenas aparecer 1 banner, sendo referenciado sempre o banner do ultimo post
    );
    $query = new WP_Query($args);
    if($query->have_posts()):
        while($query->have_posts()): $query->the_post();
        ?>
        <main>
            <div class="imagem-banner">
                <?php the_post_thumbnail(); ?>
            </div>
        </main>
        <?php
        endwhile;
    endif;
    require_once 'footer.php';
</code>

## **Adicionando scripts**

Adicionamos o arqv. `typed.min.js` dentro de uma pasta `js` na pasta do tema que estamos criando

**Documentação typed.js**

https://github.com/mattboldt/typed.js/

Criamos um arqv. `texto-banner.js` e dentro dele adicionamos o setup segundo a documentação

<code>

    var options = {
        strings: ['Texto1', 'Texto2'],  // Texto
        typeSpeed: 80,                  // Velocidade de digitação
        backSpeed: 80,                  // Velocidade pra apagar as letras
        loop: true                      // Loop
    };
</code>

## **Texto dinâmico**

No arquivo `front-page.php` adicionamos a `div` com `span`

<code>

    <main>
        <div class="imagem-banner">
            <?php the_post_thumbnail(); ?>
        </div>
        <div class="texto-banner-dinamico">
            <span id="texto-banner"></span>
        </div>
    </main>
</code>

Em seguida vamos referencia o `id` no arqv. `texto-banner.js`

<code>

    var typed = new Typed('#texto-banner', options);
</code>

Vamos adicionar a função `adicionando_scripts()` dentro arqv. `functions.php`

<code>

    function adicionando_scripts()
    {
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
        }
    }
    add_action('wp_enqueue_scripts', 'adicionando_scripts');
</code>

No arqv. `functions.php` dentro da função `adicionando_scripts()` logo a cima da condição criamos uma variável `$textosBanner` recebendo os textos da função `pegandoTextosParaBanner();`

<code>

    function adicionando_scripts()
    {
        $textosBanner = pegandoTextosParaBanner();

        if(is_front_page()){
</code>

Depois Criamos a função `pegandoTextosParaBanner();`

<code>

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
</code>

Depois dentro da função `adicionando_scripts()` dentro da condição `if` no final chamamos uma função do WP responsável por localizar um arqv. JS para assim passar os textos do banner de forma dinâmica, esses textos foram declarados no Painel Admin. do WP. Com essa função passamos os dados para o arquivo `texto-banner.js` responsável por exibir o texto com a animação de escrita

<code>

    // Função do WP responsável por localizar um arqv. JS
    wp_localize_script(
        'texto-banner-js',      // $handle - referencia do arqv. que vai ser passado os dados dinâmicos
        'data',                 // $object_name - nome que queremos referenciar dentro o arqv. 'texto-banner-js'
        $textosBanner           // Valor que queremos passar para o arqv. 'texto-banner-js'
    );
</code>

**Resultado final da função ``adicionando_scripts()``**

<code>

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
                'data',                 // $object_name - nome que queremos referenciar dentro no arqv. 'texto-banner-js'
                $textosBanner           // Valor que queremos passar para o arqv. 'texto-banner-js'
            );
        }
    }
    add_action('wp_enqueue_scripts', 'adicionando_scripts');
</code>

Por fim temos que ir até o arquivo `texto-banner.js` e adicionar `data.texto_1, data.texto_2` dentro da string pra que seja capturado os texto informados No Painel Admin. do WP, colocando o `data.` nome de referencia passado dentro da função `wp_localize_script()` juntando com `texto_1` e `texto_2` retornado pela função `pegandoTextosParaBanner()`

### **Resultado final do arquivo `texto-banner.js`**

<code>

    var options = {
        strings: [data.texto_1, data.texto_2],  // Texto
        typeSpeed: 80,                          // Velocidade de digitação
        backSpeed: 80,                          // Velocidade pra apagar as letras
        loop: true                              // Loop
    };

    var typed = new Typed('#texto-banner', options);
</code>