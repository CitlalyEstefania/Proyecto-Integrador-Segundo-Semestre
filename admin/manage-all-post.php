<?php
include 'partials/header.php';

// fetch current user's posts from database
$current_user_id = $_SESSION['user-id'];
$query = "SELECT * FROM posts ORDER BY id DESC";
$posts = mysqli_query($connection, $query);
?>




<section class="dashboard">
    <?php if (isset($_SESSION['add-post-success'])) : // shows if add post was successful
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['add-post-success'];
                unset($_SESSION['add-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post-success'])) : // shows if edit post was successful
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['edit-post-success'];
                unset($_SESSION['edit-post-success']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['edit-post'])) : // shows if edit post was NOT successful
    ?>
        <div class="alert__message error container">
            <p>
                <?= $_SESSION['edit-post'];
                unset($_SESSION['edit-post']);
                ?>
            </p>
        </div>
    <?php elseif (isset($_SESSION['delete-post-success'])) : // shows if delete post was successful
    ?>
        <div class="alert__message success container">
            <p>
                <?= $_SESSION['delete-post-success'];
                unset($_SESSION['delete-post-success']);
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
                        <a href="manage-all-post.php" class="active"><i class="uil uil-comment-alt-edit"></i>
                            <h5>Administrar todos los Posts</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-post-checked.php"><i class="uil uil-comment-alt-check"></i>
                            <h5>Verificar Post</h5>
                        </a>
                    </li>
                    <li>
                        <a href="manage-comment-checked.php"><i class="uil uil-user-plus"></i>
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
        <main>
            <h2>Administrar Posts</h2>
            <?php if (mysqli_num_rows($posts) > 0) : ?>
                <table>                                                                                             
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Categoría</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
                            <!-- get category title of each post from categories table -->
                            <?php
                            $category_id = $post['category_id'];
                            $category_query = "SELECT title FROM categories WHERE id=$category_id";
                            $category_result = mysqli_query($connection, $category_query);
                            $category = mysqli_fetch_assoc($category_result);
                            ?>
                            <tr>
                                <td><?= $post['title'] ?></td>
                                <td><?= $category['title'] ?></td>
                                <td><a href="<?= ROOT_URL ?>admin/edit-post.php?id=<?= $post['id'] ?>" class="btn sm">Editar</a></td>
                                <td><a href="<?= ROOT_URL ?>admin/delete-post.php?id=<?= $post['id'] ?>" class="btn sm danger">Eliminar</a></td>
                            </tr>
                        <?php endwhile ?>
                    </tbody>
                </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No se encontraron posts" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>


<?php
include '../partials/footer.php';
?>