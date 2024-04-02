<?php
require_once 'config.php';

// Inicie a sessão
session_start();

// Verifique se o usuário está logado e tem permissão (group_id igual a 1) para acessar esta página
if (!isset($_SESSION['user_id']) || $_SESSION['group_id'] != 1) {
    // Redirecionar para o index.php se não tiver permissão
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newCategoryName'], $_POST['newCategoryIcon'])) {
        // Processar o formulário de criação
        $newCategoryName = $_POST['newCategoryName'];
        $newCategoryIcon = $_POST['newCategoryIcon'];

        // Inserir a nova categoria no banco de dados usando uma declaração preparada
        $insertSql = "INSERT INTO categories (name, category_icon) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);

        if ($stmt) {
            $stmt->bind_param("ss", $newCategoryName, $newCategoryIcon);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redirecionar após a criação
                header('Location: editar_categoria.php');
                exit;
            } else {
                echo "Erro ao criar a categoria: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da declaração: " . $conn->error;
        }
    }
}
?><?php
require_once 'config.php';

// Inicie a sessão
session_start();

// Verifique se o usuário está logado e tem permissão (group_id igual a 1) para acessar esta página
if (!isset($_SESSION['user_id']) || $_SESSION['group_id'] != 1) {
    // Redirecionar para o index.php se não tiver permissão
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newCategoryName'], $_POST['newCategoryIcon'])) {
        // Processar o formulário de criação
        $newCategoryName = $_POST['newCategoryName'];
        $newCategoryIcon = $_POST['newCategoryIcon'];

        // Inserir a nova categoria no banco de dados usando uma declaração preparada
        $insertSql = "INSERT INTO categories (name, category_icon) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);

        if ($stmt) {
            $stmt->bind_param("ss", $newCategoryName, $newCategoryIcon);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redirecionar após a criação
                header('Location: editar_categoria.php');
                exit;
            } else {
                echo "Erro ao criar a categoria: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da declaração: " . $conn->error;
        }
    }
}
?><?php
require_once 'config.php';

// Inicie a sessão
session_start();

// Verifique se o usuário está logado e tem permissão (group_id igual a 1) para acessar esta página
if (!isset($_SESSION['user_id']) || $_SESSION['group_id'] != 1) {
    // Redirecionar para o index.php se não tiver permissão
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newCategoryName'], $_POST['newCategoryIcon'])) {
        // Processar o formulário de criação
        $newCategoryName = $_POST['newCategoryName'];
        $newCategoryIcon = $_POST['newCategoryIcon'];

        // Inserir a nova categoria no banco de dados usando uma declaração preparada
        $insertSql = "INSERT INTO categories (name, category_icon) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);

        if ($stmt) {
            $stmt->bind_param("ss", $newCategoryName, $newCategoryIcon);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redirecionar após a criação
                header('Location: editar_categoria.php');
                exit;
            } else {
                echo "Erro ao criar a categoria: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da declaração: " . $conn->error;
        }
    }
}
?><?php
require_once 'config.php';

// Inicie a sessão
session_start();

// Verifique se o usuário está logado e tem permissão (group_id igual a 1) para acessar esta página
if (!isset($_SESSION['user_id']) || $_SESSION['group_id'] != 1) {
    // Redirecionar para o index.php se não tiver permissão
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['newCategoryName'], $_POST['newCategoryIcon'])) {
        // Processar o formulário de criação
        $newCategoryName = $_POST['newCategoryName'];
        $newCategoryIcon = $_POST['newCategoryIcon'];

        // Inserir a nova categoria no banco de dados usando uma declaração preparada
        $insertSql = "INSERT INTO categories (name, category_icon) VALUES (?, ?)";
        $stmt = $conn->prepare($insertSql);

        if ($stmt) {
            $stmt->bind_param("ss", $newCategoryName, $newCategoryIcon);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redirecionar após a criação
                header('Location: editar_categoria.php');
                exit;
            } else {
                echo "Erro ao criar a categoria: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro na preparação da declaração: " . $conn->error;
        }
    }
}
?>