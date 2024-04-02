
<header>
    <div class="container">
        <nav class="navbar">
            <a href="index.php" class="nav-branding">MEDIAKORE</a>
            <div class="search-nav">
            <form action="search.php" method="GET" style="display: flex">
                <input type="text" name="search_query" class="input-search" placeholder="Pesquise algo...">
                <button type="submit" class="btn-search"><i class="fas fa-search"></i></button>
            </form>
            </div>
            <ul class="nav-menu">
            <?php
                // Display each category as a navigation link
                while ($row_category = $result_categories->fetch_assoc()) {
                    echo '<li class="nav-item" onclick="navigateToCategory(' . $row_category["id"] . ')" style="cursor: pointer;">';
                    echo '<i style="font-size: 20px; padding-right: 5px;"'.$row_category["category_icon"]. '<a href="categoria.php?id=' . $row_category["id"] . '" class="nav-link">' . $row_category["name"] . '</a>';
                    echo '</li>';
                }
                ?>

                
                <?php
                    // Verificar se o usuário está logado e se o group_id é igual a 1
                    if (isset($_SESSION['user_id']) && $_SESSION['group_id'] == 1) { // Ajuste aqui para 'group_id'
                        echo '<a href="postar.php" class="item-a"><i class="fa-solid fa-square-pen"> Fazer um post</i></i></a>';
                    }
                    // Verificar se o usuário está logado e se o group_id é igual a 1
                    if (isset($_SESSION['user_id']) && $_SESSION['group_id'] == 1) { // Ajuste aqui para 'group_id'
                        echo '<a href="editar_categoria.php" class="btn item-a"><i class="fa-solid fa-pen-nib"> Editar categorias</i></i></a>';
                    }
                    ?>
                    <li class="Sair">
                    <a href="logout.php" class="nav-link" id="logout">Sair</a>
                </li>
            </ul>
            
            <a for="active" class="search-button">
            <i class="fas fa-search" id="searchIcon"></i>
            </a>
            <div class="hamburger">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </nav>
    </div>
</header>