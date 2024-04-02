<?php
if (isset($_FILES['upload']['name'])) {
    $target_dir = "uploads/";
    $file_name = $_FILES["upload"]["name"];
    $target_file = $target_dir . basename($file_name);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verificar se o arquivo é uma imagem
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["upload"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }

    // Verificar se o arquivo já existe e renomeá-lo, se necessário
    $counter = 1;
    while (file_exists($target_file)) {
        $file_name = pathinfo($_FILES["upload"]["name"], PATHINFO_FILENAME) . '_' . $counter;
        $target_file = $target_dir . $file_name . '.' . $imageFileType;
        $counter++;
    }

    // Verificar o tamanho do arquivo (opcional)
    if ($_FILES["upload"]["size"] > 500000) {
        $uploadOk = 0;
    }

    // Permitir apenas certos formatos de arquivo (opcional)
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Verificar se $uploadOk está definido como 0 por um erro
    if ($uploadOk == 0) {
        echo json_encode(array("error" => "Erro ao fazer upload do arquivo."));
    } else {
        // Tentar fazer o upload do arquivo
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $target_file)) {
            echo json_encode(array("url" => $target_file));
        } else {
            echo json_encode(array("error" => "Erro ao fazer upload do arquivo."));
        }
    }
} else {
    echo json_encode(array("error" => "Nenhum arquivo enviado."));
}
?>
