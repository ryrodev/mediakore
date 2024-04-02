<?php

// Inicie a sessão

session_start();



// Verifique se o usuário está logado

if (!isset($_SESSION['user_id'])) {

    // Redirecionar para a página de login

    header('Location: login.php');

    exit;

}



// Verificar se o usuário tem permissão (group_id igual a 1) para acessar esta página

if ($_SESSION['group_id'] != 1) {

   // Redirecionar para o index.php se não tiver permissão

   header('Location: index.php');

   exit;

}



?>

<?php

require_once 'config.php';

$sql_categories = "SELECT * FROM categories";

$result_categories = $conn->query($sql_categories);



// Verificar se a requisição é POST

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (

      !empty($_POST["title"]) &&

      !empty($_POST["content"]) &&

      isset($_POST["category"]) &&

      !empty($_POST["category"])

    ) {

      $title = $_POST["title"];

      $content = $_POST["content"];

      $category = $_POST["category"];

  

      // Remover caracteres especiais e evitar injeção de SQL

      $title = $conn->real_escape_string($title);

      $content = $conn->real_escape_string($content);

      $category = $conn->real_escape_string($category);

  

      // Verificar se o título já existe no banco de dados

      $checkTitleQuery = "SELECT COUNT(*) AS count FROM posts WHERE title = '$title'";

      $checkTitleResult = $conn->query($checkTitleQuery);

      $checkTitleRow = $checkTitleResult->fetch_assoc();

      $titleCount = $checkTitleRow['count'];

  

      if ($titleCount > 0) {

        echo "<script>alert('Já existe um post com esse título. Por favor, escolha outro título.');</script>";

      } else {

        $sql = "INSERT INTO posts (title, content, category) VALUES ('$title', '$content', '$category')";

        if ($conn->query($sql) === TRUE) {

          // Redirecionar para evitar o reenvio do formulário

          header("Location: index.php");

          exit();

        } else {

          echo "Erro ao adicionar o post: " . $conn->error;

        }

      }

    }

  }



  

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

    <!-- Formulário para adicionar um novo post -->

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

      <input class="title" type="text" name="title" placeholder="Titulo" required><br><br>

      

      <textarea name="content" id="content"></textarea>

      <br>

      <select class="category" name="category" required>

        <option value="" disabled selected>Selecione uma categoria</option>

        <?php exibirCategorias(); ?>

      </select><br><br>

      <input class="submit" type="submit" value="Enviar">

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

