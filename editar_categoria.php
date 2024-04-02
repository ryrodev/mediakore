<?php

require_once 'config.php';



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



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obter os dados do formulário

    $categoryId = $_POST['categoryId'];

    $newCategoryName = $_POST['editCategoryName'];

    $newCategoryIcon = $_POST['editCategoryIcon'];



    // Atualizar os dados no banco de dados

    $updateSql = "UPDATE categories SET name=?, category_icon=? WHERE id=?";

    $stmt = $conn->prepare($updateSql);



    if ($stmt) {

        $stmt->bind_param("ssi", $newCategoryName, $newCategoryIcon, $categoryId);

        $stmt->execute();



        if ($stmt->affected_rows > 0) {

            // Redirecionar após a atualização

            header('Location: editar_categoria.php');

            exit;

        } else {

            echo "Erro ao atualizar a categoria.";

        }



        $stmt->close();

    } else {

        echo "Erro na preparação da declaração: " . $conn->error;

    }

}







if (isset($_GET['delete_id'])) {

    // ID da categoria a ser excluída

    $categoryIdToDelete = $_GET['delete_id'];



    // Consulta para excluir a categoria do banco de dados

    $deleteSql = "DELETE FROM categories WHERE id=?";

    $stmt = $conn->prepare($deleteSql);



    if ($stmt) {

        $stmt->bind_param("i", $categoryIdToDelete);

        $stmt->execute();



        if ($stmt->affected_rows > 0) {

            // Redirecionar após a exclusão

            header('Location: editar_categoria.php');

            exit;

        } else {

            echo "Erro ao excluir a categoria.";

        }



        $stmt->close();

    } else {

        echo "Erro na preparação da declaração: " . $conn->error;

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

        <div class="index-categories">

    <?php

    $sql = "SELECT * FROM categories";

    $result = $conn->query($sql);



    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

    ?>

           <div class='post-outline'>

                <div class='title-categoria'>

                    <h2><?php echo $row["name"]; ?></h2>

                    <div class="category_icon">

                    <?php echo $row["category_icon"]; ?>

                    </div>

                    <div class='category_post'>

                    <hr>

                    <a href='#editModal<?php echo $row["id"]; ?>' data-toggle='modal' data-categoryid='<?php echo $row["id"]; ?>'><i style='padding: 10px;' class='fa-solid fa-pen-to-square'></i>Editar</a>

                    

                    <a href='#confirmDeleteModal<?php echo $row["id"]; ?>' data-toggle='modal'><i style='padding: 10px;' class='fa-solid fa-trash'></i>Deletar</a>

                    </div>

                </div>

            </div>

<!-- Modal de edição de categoria -->



<div class='modal fade' id='editModal<?php echo $row["id"]; ?>' tabindex='-1' aria-labelledby='editModalLabel<?php echo $row["id"]; ?>' aria-hidden='true'>

    <div class='modal-dialog'>

        <div class='modal-content'>

            <div class='modal-header'>

                <h5 class='modal-title' id='editModalLabel<?php echo $row["id"]; ?>'>Editar Categoria</h5>

                <button type="button" class="button-close" data-dismiss="modal" aria-label="Fechar">

                    <i class="fa-solid fa-xmark"></i>

                </button>



            </div>

            <div class='modal-body'>

                <!-- Formulário de edição de categoria -->

                <form action='editar_categoria.php' method='post'>

                    <!-- Campo de ID (não editável) -->

                    <input type='hidden' name='categoryId' value='<?php echo $row["id"]; ?>' />

                    <label for='editCategoryName'>Nome da Categoria:</label>

                    <input type='text' id='editCategoryName' name='editCategoryName' value='<?php echo $row["name"]; ?>' required>

					<br>

                    <label for='editCategoryIcon'>Ícone da Categoria:</label>

                    <input type='text' id='editCategoryIcon' name='editCategoryIcon' value='<?php echo $row["category_icon"]; ?>' required>

                    <button type="button" data-toggle="modal" data-target="#iconModal">

                            <i class="fa-solid fa-question"></i>

                        </button>

                    <button type='submit' class='btn btn-primary'>Salvar Alterações</button>

                </form>

            </div>

        </div>

    </div>

</div>



<!-- Modal de confirmação de exclusão -->

<div class="modal fade" id="confirmDeleteModal<?php echo $row["id"]; ?>" tabindex="-1" aria-labelledby="confirmDeleteModalLabel<?php echo $row["id"]; ?>" aria-hidden="true">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="confirmDeleteModalLabel<?php echo $row["id"]; ?>">Confirmar Exclusão</h5>

                <button type="button" class="button-close" data-dismiss="modal" aria-label="Fechar">

                    <i class="fa-solid fa-xmark"></i>

                </button>



            </div>

            <div class="modal-body">

                Tem certeza de que deseja excluir a categoria '<?php echo $row["name"]; ?>'?

            </div>

            <div class="modal-footer">

                <a href='editar_categoria.php?delete_id=<?php echo $row["id"]; ?>' class='btn btn-danger'>Confirmar Exclusão</a>

                <button type="button" class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>

            </div>

        </div>

    </div>

</div>

    <?php

        }

    } else {

        echo "Nenhuma categoria encontrada.";

    }

    ?>

</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createCategoryModal"><i class="fa-solid fa-plus"></i> Nova Categoria</button>





<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="createCategoryModalLabel">Nova Categoria</h5>

                    <button type="button" class="button-close" data-dismiss="modal" aria-label="Fechar">

                    <i class="fa-solid fa-xmark"></i>

                </button>

                </div>

                <div class="modal-body">

                    <!-- Formulário para criar uma nova categoria -->

                    <form action="criar_categoria.php" method="post">

                        <label for="newCategoryName">Nome da Categoria:</label>

                        <input type="text" id="newCategoryName" name="newCategoryName" autocomplete="off" required>

                        <label for="newCategoryIcon">Ícone da Categoria: </label>

                        <input type="text" id="newCategoryIcon" name="newCategoryIcon" autocomplete="off" required>

                        <button type="button" data-toggle="modal" data-target="#iconModal">

                            <i class="fa-solid fa-question"></i>

                        </button>

                        <button type="submit" class="btn btn-primary" id="createCategoryBtn">Criar Categoria</button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    

    

<div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="iconModal">Lista de icones</h5>

                    <button type="button" class="button-close" data-dismiss="modal" aria-label="Fechar">

                    <i class="fa-solid fa-xmark"></i>

                </button>

                </div>

                <div class="modal-body">

                    <a>Acesse a lista de icones disponiveis neste link: <a href="https://fontawesome.com/search?o=r&m=free">fontawesome.com/search?o=r&m=free</a></a><br><br>

                    <a>Como adicionar o icone:</a>

                    <img src="assets/category_icon.gif">

                </div>

            </div>

        </div>

    </div>    

    </main>

    <script>

        // Adicione um ouvinte de evento de clique ao botão de editar

        $('[data-toggle="modal"]').on('click', function() {

            // Obtenha o ID da categoria a partir dos dados de atributo (data-categoryid)

            var categoryId = $(this).data('categoryid');

            // Preencha o input hidden do formulário com o ID da categoria

            $('#categoryIdInput').val(categoryId);

        });



    </script>

    <script src="script.js"></script>

    <div class="push"></div>

    </div>

    <footer class="footer">

        <div class="footer-container">

            <p>© 2024 MiguelH</p>

        </div>

    </footer>

</body>

</html>