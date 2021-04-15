<?php
/**
 * @var app\model\Post $posts
 */

require_once("src/app/model/Post.php");
require_once("src/app/model/User.php");
use app\model\Post;
use app\model\User;

$user = User::findOneByUserId($_SESSION['user_id']);
if (!isset($_POST['post-search'])) 
{
    $posts = Post::findAllByAuthorId($_SESSION['user_id'], $_GET['order']);
}
else
{
    $posts = Post::findAllByAuthorIdAndFilter($_SESSION['user_id'], $_POST['sort_order'], $_POST['post-search'], $_POST['post']['category']);
}

?>

<?php if (isset($_GET['update']) && $_GET['update'] == "success") : ?>
<div class="alert alert-success">Sikeresen szerkesztetted a posztod! :)</div>
<?php endif; ?>

<?php if (isset($_GET['delete'])) : ?>
    <?php if ($_GET['delete'] == "success") : ?>
        <div class="alert alert-success">Sikeresen törölted a posztod! :)</div>
    <?php else : ?>
        <div class="alert alert-warning">Valami hiba történt a poszt törlése során! :(</div>
    <?php endif; ?>
<?php endif; ?>

<div class="container search-area pb-2">
    <div class="row">
        <div class="col-12 text-center my-3">
            <h2>Posztok</h2>
        </div>
    </div>
    <form action=<?= "index.php?controller=user&action=posts&order=" . $_GET['order'] ?> method="POST" class="my-3 text-center">
        <div class="form-row align-items-center col-12">
            <label for="post-search">Keresés a posztok között:</label>
            <input type="search" name="post-search" id="post-search" placeholder="Keresés..." <?php echo (isset($_POST['post-search']))?'value = ' . $_POST['post-search']:"" ?> >
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-6">
                <label for="post-sort">Rendezés:</label>
                <select class="form-control" name="sort_order">
                    <option value="DESC" <?= (isset( $_POST['post']) && $_POST['sort_order'] == "DESC")?"selected":"" ?> >Legfrissebb elől</option>
                    <option value="ASC" <?= (isset( $_POST['post']) && $_POST['sort_order'] == "ASC")?"selected":"" ?> >Legrégebbi elől</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="post-category">Kategória:</label>
                <select class="form-control" name="post[category]">
                    <option value="lookingForHelp" <?= (isset( $_POST['post']) && $_POST['post']['category'] == "lookingForHelp")?"selected":"" ?> >Segítséget kér</option>
                    <option value="lookingToHelp" <?= (isset( $_POST['post']) && $_POST['post']['category'] == "lookingToHelp")?"selected":"" ?> >Segítséget kínál</option>
                    <option value="both" <?= (isset( $_POST['post']) && $_POST['post']['category'] == "both")?"selected":"" ?> >Mindegyik</option>
                </select>
            </div>
        </div>
        <input type="submit" value="Szűrés" class="btn-search mt-2">
    </form>
</div>

<div class="container post-container pb-5 pt-2">
    <h2 class="text-center my-3"><?= $user->getLast_name() . " " . $user->getFirst_name() ?> posztjai</h2>
    <div class="row">
    <?php if (count($posts) > 0) : ?> 
        <?php foreach($posts as $post) : ?>
            <div class="col-12 post-box my-2">
                <div class="row" onclick=<?= "location.href='index.php?controller=post&action=view&id=" . $post->getId() . "';" ?> style="cursor: pointer;">
                <div class="col-12 post-subject">
                    <?= $post->getSubject(); ?>
                </div>
                <div class="col-12 post-content">
                    <?= $post->getPost_content(); ?>
                </div>
                </div>
                <p class="post-info">Státusz: <?= $post->getStatus() ?> | Kategória: <?= $post->getCategory() ?> | <?= $post->getTimestamp() ?></p>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="col-12 my-3">
            <div class="alert alert-warning text-center">Nincs a keresésnek megfelelő poszt! :(</div>
        </div>
    <?php endif; ?>
    </div>
</div>