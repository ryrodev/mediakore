<?php
ob_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mediakore";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Função para exibir as categorias
function exibirCategorias()
{
    global $conn;
    $sql = "SELECT * FROM categories";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["id"] . "'>" . $row["name"] . "</option>";
        }
    }
}

// Fun��o para exibir os posts
function exibirPosts()
{
    global $conn;
    $sql = "SELECT * FROM posts ORDER BY created_at DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<h2>" . $row["title"] . "</h2>";
            echo "<div>" . $row["content"] . "</div>";
            echo "<p>Categoria: " . $row["category"] . "</p>";
        }
    } else {
        echo "Nenhum post encontrado.";
    }
}

function getCategoryName($categoryId)
{
    global $conn;
    $sql = "SELECT name FROM categories WHERE id = $categoryId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row["name"];
    } else {
        return "Categoria não encontrada";
    }
}

ob_end_flush();
?>
