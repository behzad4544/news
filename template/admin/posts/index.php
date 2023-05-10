<?php

use database\Database;

require_once(BASE_PATH . '/template/admin/layouts/header.php');
?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h5"><i class="fas fa-newspaper"></i> Articles</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a role="button" href="<?= url('admin/post/create') ?>" class="btn btn-sm btn-success">create</a>
    </div>
</div>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <caption>List of posts</caption>
        <thead>
            <tr>
                <th>#</th>
                <th>title</th>
                <th>summary</th>
                <th>view</th>
                <th>status</th>
                <th>user ID</th>
                <th>cat ID</th>
                <th>image</th>
                <th>setting</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($posts as $post) : ?>
                <tr>
                    <td>
                        <a class="text-primary" href="">
                            <?= $post['id'] ?>
                        </a>
                    </td>
                    <td>
                        <?= $post['title'] ?>
                    <td>
                        <?= $post['summary'] ?> </td>
                    <td>
                        <?= $post['view'] ?>
                    </td>
                    <td>
                        <?php if ($post['selected'] == 1) : ?>
                            <span class="badge badge-success">#breaking_news</span>
                        <?php endif; ?>
                        <?php if ($post['breaking_news'] == 1) : ?>
                            <span class="badge badge-dark">#editor_selected</span>
                        <?php endif; ?>

                    </td>
                    <td>
                        <?php
                        $db = new Database();
                        $sql = "select users.username as username from users inner join posts on users.id =?";
                        $stmt = $db->select($sql, [$post['user_id']]);
                        $res = $stmt->fetch();
                        echo $res['username']
                        ?>
                    </td>
                    <td>
                        <?php
                        $db = new Database();
                        $sql = "select categories.name as catName from categories inner join posts on categories.id =?";
                        $stmt = $db->select($sql, [$post['cat_id']]);
                        $res = $stmt->fetch();
                        echo $res['catName']
                        ?>
                    </td>
                    <td><img style="width: 80px;" src="" alt=""></td>
                    <td style="width: 25rem;">
                        <a role="button" class="btn btn-sm btn-warning  text-white" href="">
                            <?= ($post['breaking_news'] == 1) ? 'remove breaking news' : 'add breaking news' ?>

                        </a>
                        <a role="button" class="btn btn-sm btn-warning  text-white" href="">
                            <?= ($post['selected'] == 1) ? 'remove selcted' : 'add selected' ?>
                        </a>
                        <hr class="my-1" />
                        <a role="button" class="btn btn-sm btn-primary text-white" href="">edit</a>
                        <a role="button" class="btn btn-sm btn-danger text-white" href="">delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>




<?php

require_once(BASE_PATH . '/template/admin/layouts/footer.php');


?>