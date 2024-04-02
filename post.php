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

  

  <title>MediaKore</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="icon" href="favicon.png" type="image/x-icon">

  <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

  <script src="https://kit.fontawesome.com/31b2f004d5.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css"/>

     <!-- Inclua o jQuery -->

     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="zoom-master/jquery.zoom.js"></script>

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

<!-- area de pesquisa -->



<main class="post-main">

<?php

require_once 'config.php';



// Check if the user has group_id equal to 1 and if the deletepost parameter is set

if (isset($_SESSION['user_id']) && $_SESSION['group_id'] == 1 && isset($_GET['deletepost'])) {

    $postId = $_GET["deletepost"];



    // Check if the user confirmed the deletion

    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {

        // Consulta SQL para deletar o post pelo ID

        $sql = "DELETE FROM posts WHERE id = $postId";

        if ($conn->query($sql) === TRUE) {

            // Post deleted successfully

            echo '<script>alert("Post deletado com sucesso.");</script>';

            // You can redirect the user to the homepage or any other appropriate page

            header("Location: index.php");

            exit;

        } else {

            echo '<script>alert("Erro ao deletar o post: ' . $conn->error . '");</script>';

        }

    } else {

        // Show the confirmation alert and go back to the post on cancel

        echo '<script>

            if (confirm("Tem certeza que deseja deletar este post?")) {

                window.location.href = "post.php?deletepost=' . $postId . '&confirm=true";

            } else {

                history.back();

            }

        </script>';

    }

}



// Verificar se o parâmetro 'id' está presente na URL

if (isset($_GET["id"])) {

  $postId = $_GET["id"];



  // Consulta SQL para obter o post pelo ID

  $sql = "SELECT * FROM posts WHERE id = $postId";

  $result = $conn->query($sql);



  if ($result->num_rows > 0) {

      $row = $result->fetch_assoc();

      $title = $row["title"];

      $content = $row["content"];

      $category = $row["category"];



      if (isset($_SESSION['user_id']) && $_SESSION['group_id'] == 1) {

          echo '<h2 class="post-title">' . $title . '<div><a href="editar.php?id=' . $postId . '"><i class="fa-solid fa-pen-to-square" style="margin-right: 15px;"></i></a><a href="post.php?deletepost=' . $postId . '"><i class="fa-solid fa-trash"></i></a></div></h2>';

      } else {

          echo '<h2 class="post-title">' . $title . '</h2>';

      }

      

      echo '<div class="post-content">' . $content . '</div>';

  } else {

      echo "Post não encontrado.";

  }

} else {

  echo "ID do post não especificado.";

}



?>

<br>

<?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $mac_address = $_POST["mac_address"];



    $url = "https://api.macvendors.com/" . urlencode($mac_address);

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($ch);

    if ($response) {

      echo "Vendor: $response";

    } else {

      echo "Not Found";

    }

  }

  ?>



  </main>

<script>

   function redirectToPage(id) {

  window.location.href = 'post.php?id=' + id;

}

</script>

  <script src="script.js"></script>



  <script>

        $(document).ready(function () {

            // Adicione a função grab ao inicializar o zoom

            $('img')

                .wrap('<span style="display:inline-block"></span>')

                .css('display', 'block')

                .parent()

                .zoom({

                    on: 'grab', // Ativa a função grab

                    magnify: 1.3

                });

        });

    </script>









  <div class="push"></div>

  </div>

  <footer class="footer">

        <div class="footer-container">

            <p>© 2024 MiguelH</p>

        

    </footer>

</body>

</html>

