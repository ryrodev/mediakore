<?php

// Inicie a sessão

session_start();



// Verifique se o usuário está logado

if (!isset($_SESSION['user_id'])) {

    // Redirecionar para a página de login

    header('Location: login.php');

    exit;

}



?>



<?php

require_once 'config.php';

$sql_categories = "SELECT * FROM categories";

$result_categories = $conn->query($sql_categories);

?>





<!DOCTYPE html>

<html lang="pt-br">

<head>

  <meta charset="UTF-8" />

  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <link rel="stylesheet" href="style.css"/>

  <title>MediaKore</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="icon" href="favicon.png" type="image/x-icon">

  <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

  <script src="ckeditor/build/ckeditor.js"></script>

  <script src="https://kit.fontawesome.com/31b2f004d5.js" crossorigin="anonymous"></script>

</head>

<body>

<?php include 'header.php';?>

    <?php

    // Verificar se o ID do post a ser editado foi fornecido na URL

    if (!isset($_GET['id'])) {

        echo "ID do post não fornecido.";

        exit;

    }



    // Verifique se o usuário está logado

    if (!isset($_SESSION['user_id'])) {

        echo "Você precisa estar logado para editar um post.";

        exit;

    }



    // Verificar se o usuário tem permissão (group_id igual a 1) para acessar esta página

    if ($_SESSION['group_id'] != 1) {

        echo "Você não tem permissão para editar um post.";

        exit;

    }



    // Verificar se o formulário foi submetido

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $id = $_POST["id"];

        $content = $_POST["content"];



        // Atualizar o conteúdo do post no banco de dados

        $sql_update = "UPDATE posts SET content = '$content' WHERE id = $id";

        $result = $conn->query($sql_update);



        if ($result) {

            echo "Post atualizado com sucesso!";

        } else {

            echo "Erro ao atualizar o post: " . $conn->error;

        }

    }



    // Obter os detalhes do post para preencher o formulário de edição

    if (isset($_GET['id'])) {

        $post_id = $_GET['id'];

        $sql_get_post = "SELECT * FROM posts WHERE id = $post_id";

        $result_post = $conn->query($sql_get_post);



        // Verificar se o post com o ID fornecido existe no banco de dados

        if ($result_post->num_rows === 0) {

            echo "Post não encontrado.";

            exit;

        }



        $row_post = $result_post->fetch_assoc();

    } else {

        echo "ID do post não fornecido.";

        exit;

    }

    ?>

    <div class="search-box" id="searchBox">

            <form action="search.php" method="GET" style="display: flex">

                <input type="text" name="search_query" class="input-search" placeholder="Pesquise algo...">

                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>

            </form>

     </div>

    <div class="push"></div>

    <div class="push"></div>

    <main class="indexmain">

        <div class="submitpost">

            <h2><?php echo $row_post['title']; ?></h2>

            <p>Categoria: <?php echo getCategoryName($row_post['category']); ?></p>

            <!-- Formulário para editar o post -->

            <form method="POST">

                <input type="hidden" name="id" value="<?php echo $post_id; ?>">

                <textarea name="content" id="content" required><?php echo $row_post['content']; ?></textarea><br><br>

                <input type="submit" class="submit" value="Atualizar">

            </form>

        </div>

    </main>



    <script>

        ClassicEditor

            .create(document.querySelector('#content'), {

                simpleUpload: {

                    uploadUrl: 'upload.php', // URL para o script PHP que fará o upload do arquivo

                    headers: {

                        'X-CSRF-TOKEN': 'CSRF-Token', // Se você estiver usando proteção CSRF, inclua o token aqui

                    }

                }

            })

            .then(editor => {

                console.log('Editor was initialized', editor);

            })

            .catch(error => {

                console.error(error.stack);

            });

    </script>

    

  <script src="script.js"></script>

  

  <div class="push"></div>

  </div>

  <footer class="footer">

        <div class="footer-container">

            <p>© 2024 MiguelH</p>

        

    </footer>

</body>

</html>

