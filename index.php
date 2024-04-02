<?php
require_once 'config.php';

// Inicie a sess�o para verificar se o usu�rio est� logado
session_start();

// Verifique se o usu�rio N�O est� logado
if (!isset($_SESSION['user_id'])) {
    // Redirecione para a p�gina de login SOMENTE se a p�gina atual n�o for a de login
    if (!strpos($_SERVER['REQUEST_URI'], 'login.php')) {
        header('Location: login.php');
        exit;
    }
}


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

    <!-- Include Bootstrap CSS and JS -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="style.css" />

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

    <br>

<!-- Categorias -->

<div class="index-posts">

        <?php

        $sql = "SELECT * FROM categories";

        $result = $conn->query($sql);



        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

                echo "<div class='post-outline' style='cursor:pointer;' onclick='redirectToCategory(" . $row["id"] . ")'>";

                echo "<div class='title-post'><h2><a href='categoria.php?id=" . $row["id"] . "'>" . $row["name"] . "</a></h2>";

                echo "</div>";

                echo "<div class='index-options category_icon'>";

                // Display the image representing the category

                echo $row["category_icon"];

                echo "</div>";

                echo "</div>";

            }

        } else {

            echo "Nenhuma categoria encontrada.";

        }

        ?>

    </div>

    <script>

    function redirectToCategory(id) {

        window.location.href = 'categoria.php?id=' + id;

    }

</script>





</main>

  <script src="script.js"></script>



  <div class="push"></div>

  </div>

  <footer class="footer">

        <div class="footer-container">

            <p>© 2024 MiguelH</p>

        

    </footer>

</body>

</html>

