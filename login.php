<?php

require_once 'config.php';



// Inicie a sessão para armazenar as informações de login

session_start();


// Verificar se o usuário já está logado, se sim, redirecione para a página de destino

if (isset($_SESSION['user_id'])) {

    header('Location: index.php');

    exit;

}


// Verificar se o formulário de login foi enviado

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Verificar as credenciais de login

    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);


    // Consulta SQL para verificar o usuário no banco de dados

    $sql = "SELECT id, group_id FROM users WHERE login = '$username' AND senha = '$password'";

    $result = $conn->query($sql);



    if ($result->num_rows > 0) {

        // Autenticação bem-sucedida, defina as variáveis de sessão para indicar que o usuário está logado e seu group_id

        $row = $result->fetch_assoc();

        $_SESSION['user_id'] = $row['id'];

        $_SESSION['group_id'] = $row['group_id'];

        header('Location: index.php');

        exit;

    } else {

        $error_message = 'Credenciais inválidas. Tente novamente.';

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

  <title>MediaKore - Login</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link rel="icon" href="favicon.png" type="image/x-icon">

  <link href="https://fonts.googleapis.com/css2?family=Staatliches&display=swap" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">

</head>

<body>

<header>

   <div class="container"> 

      <nav class="navbar">

         <a href="index.php" class="nav-branding">MEDIAKORE</a>

      </nav>

   </div>

</header>

<body class="login-body">

    

	<main class="main-login">

    <div class="login-page">

    <h1>Login</h1>

    <br>

    <?php

    if (isset($error_message)) {

        echo '<p style="color: red;">' . $error_message . '</p>';

    }

    ?>

    <form class="login-form" action="login.php" method="post">

        <input class="login-input" type="text" id="username" name="username" placeholder="Usuário..." required>

        <input class="login-input" type="password" id="password" name="password"  placeholder="Senha..." required>

        <button type="submit">Entrar</button>

    </form>

</div>

		</main>

        <div class="push"></div>

  </div>

  <footer class="footer">

        <div class="footer-container">

            <p>© 2024 MiguelH</p>

        

    </footer>

</body>

</html>

