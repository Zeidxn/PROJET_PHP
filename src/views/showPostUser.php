<?php

use controllers\PostController;

$db = include('../config.php');
$postControllerPost = new PostController($db);
$postsPerPage = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$posts = $postControllerPost->getPostsByUser($_SESSION['userId'],$page, $postsPerPage);
?>

<?php foreach ($posts as $post): ?>
    <?php $user = $postControllerPost->getUserName($post['owner']); ?>
    <?php if ($user == $_SESSION['user']['pseudo']): ?>
        <div class="post-container">
            <h3><?= $user ?>
                <?php if ($post['owner'] == $_SESSION['userId']): ?>
                    <form action="editPost.php" method="post">
                        <input type="hidden" name="postId" value="<?= $post['id'] ?>">
                        <button type="submit" name="edit" value="edit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg>
                        </button>
                    </form>
                <?php endif; ?>
            </h3>
            <h2><?= $post['title'] ?></h2>
            <p><?= $post['content'] ?></p>
            <?php if ($post['imageData'] != null && $post['imageData'] != " "): ?>
                <?php
                $imageData = base64_encode($post['imageData']);
                $imageType = pathinfo($post['imageData'], PATHINFO_EXTENSION);
                $imageSrc = 'data:image/' . $imageType . ';base64,' . $imageData;
                ?>
                <img src="<?= $imageSrc ?>" alt="Post Image">
            <?php endif; ?>

            <div id="boutons-post">
                <form id="bouton-like" action="../controllers/LikeController.php" method="post">
                    <input type="hidden" name="postId" value="<?=$post['id']?>">
                    <button type="submit" name="like" value="like">
                        <?php
                        if($postControllerPost->userInLike($_SESSION['userId'],$post['id'])){?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="green" stroke="green" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                            </svg>
                        <?php } else {?>
                            <svg id="like" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                            </svg>
                        <?php } ?>
                        <p><?=$postControllerPost->getLikesCount($post['id'])?></p>
                    </button>
                </form>

                <form id="bouton-dislike" action="../controllers/DisLikeController.php" method="post">
                    <input type="hidden" name="postId" value="<?=$post['id']?>">
                    <button type="submit" name="dislike" value="dislike">
                        <?php
                        if($postControllerPost->userInDisLike($_SESSION['userId'],$post['id'])){?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="red" stroke="red" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                        <?php } else {?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                        <?php } ?>
                        <p><?=$postControllerPost->getDislikesCount($post['id'])?></p>
                    </button>
                </form>


                <form id="bouton-comment" action="comment.php">
                    <input type="hidden" name="postId" value="<?=$post['id']?>">
                    <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg></button>
                </form>


                <?php
                if($post['owner']==$_SESSION['userId']){
                    ?>
                    <form id="delete-bouton" action="../controllers/DeleteController.php" method="post">
                        <input type="hidden" name="postId" value="<?=$post['id']?>">
                        <button type="submit" name="delete" value="delete"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button>
                    </form>
                    <?php
                }
                ?>
            </div>

            <?php
            $comments = $postControllerPost->getComments($post['id']);
            if ($comments != null) {
                foreach ($comments as $comment) {
                    $commentUser = $postControllerPost->getUserName($comment['userId']);
                    echo '<div class="comment-container">';
                    echo '<h1>' . $commentUser . '</h1>';
                    echo '<p>' . $comment['content'] . '</p>';
                    echo '<p>' . $comment['date'] . '</p>';
                    echo '</div>';
                }
            }
            ?>
        </div>
    <?php endif; ?>
<?php endforeach; ?>
