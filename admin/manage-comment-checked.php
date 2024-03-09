<?php
include '../partials/header.php';

// fetch users from database but not current user
$current_admin_id = $_SESSION['user-id'];

$query = "SELECT * FROM comments WHERE checked=0";
$comments = mysqli_query($connection, $query);
?>

<section class="dashboard">
    <?php if (isset($_SESSION['checked-comment-succcess'])) : // shows if add user was successful
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['checked-comment-succcess'];
                unset($_SESSION['checked-comment-succcess']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['checked-comment'])) : // shows if delete user was NOT successful
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['checked-comment'];
                unset($_SESSION['checked-comment']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user'])) : // shows if delete user was NOT successful
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['delete-user'];
                unset($_SESSION['delete-user']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-user-success'])) : // shows if delete user was successful
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-user-success'];
                unset($_SESSION['delete-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['checked-user-success'])) : // shows if edit user was successful
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['checked-user-success'];
                unset($_SESSION['checked-user-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['checked-user'])) : // shows if edit user was NOT successful
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['checked-user'];
                unset($_SESSION['checked-user']);
                ?>
            </p>
        </div>
    <?php endif ?>

    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
        <ul>
                <li>
                    <a href="add-post.php"><i class="uil uil-comment-add"></i>
                        <h5>Añadir Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php"><i class="uil uil-comment-alt-edit"></i>
                        <h5>Administrar Posts</h5>
                    </a>
                </li>
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                    <li>
                        <a href="manage-all-post.php"><i class="uil uil-comment-alt-edit"></i>
                            <h5>Administrar todos Posts</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-post-checked.php"><i class="uil uil-comment-alt-check"></i>
                            <h5>Verificar Post</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-comment-checked.php" class="active"><i class="uil uil-user-plus"></i>
                            <h5>Verificar Comentarios</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-user-checked.php"><i class="uil uil-user-check"></i>
                            <h5>Verificar Usuario</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-users.php"><i class="uil uil-users-alt"></i>
                            <h5>Administrar Usuarios</h5>
                        </a>
                    </li>
                    <li>
                        <a href="add-category.php"><i class="uil uil-create-dashboard"></i>
                            <h5>Añadir Categoría</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-categories.php"><i class="uil uil-apps"></i>
                            <h5>Administrar Categorías</h5>
                        </a>
                    </li>
                <?php endif ?>
            </ul>
        </aside>
<!--  -->
        <main>
            <h2>Verificar comentarios</h2>
            <?php if (mysqli_num_rows($comments) > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre de Usuario</th>
                            <th>Titulo de post</th>
                            <th>Contenido</th>
                            <th>Verificado</th>
                            <th>Eliminar</th>
                            <th>Verificar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($comment = mysqli_fetch_assoc($comments)) : ?>
                            <?php
                                $user = "SELECT * FROM users WHERE id={$comment['author_id']}";
                                $user = mysqli_query($connection, $user);
                                $user = mysqli_fetch_assoc($user);

                                $post = "SELECT * FROM posts WHERE id={$comment['post_id']}";
                                $post = mysqli_query($connection, $post);
                                $post = mysqli_fetch_assoc($post);
                            ?>
                            <tr>
                                <td><?= "{$user['firstname']} {$user['lastname']}" ?></td>
                                <td><?= $post['title'] ?></td>
                                <td><?= $comment['body'] ?></td>
                                <td><?= $comment['checked'] ? 'Yes' : 'No' ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-comment.php?id=<?= $comment['id'] ?>" class="btn sm danger">Eliminar</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/check-comment.php?id=<?= $comment['id'] ?>" class="btn sm">✓</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No se encontraron usuarios" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>


<?php
include '../partials/footer.php';
?>
