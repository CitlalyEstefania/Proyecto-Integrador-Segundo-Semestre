<?php
require __DIR__ . '/../config/database.php';

if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate input
    if (!$title || !$description) {
        $_SESSION['edit-category'] = "Formato inválido";
    } else {
        $query = "UPDATE categories SET title='$title', description='$description' WHERE id=$id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if (mysqli_errno($connection)) {
            $_SESSION['edit-category'] = "No se pudo actualizar la categoría";
        } else {
            $_SESSION['edit-category-success'] = "Categoría $title actualizada éxitosamente";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
