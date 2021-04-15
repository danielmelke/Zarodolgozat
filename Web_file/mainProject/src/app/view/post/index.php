<?php
/**
 * @var app\model\Post $posts
 */

require_once("src/app/model/Post.php");
require_once("src/app/model/User.php");
use app\model\Post;
use app\model\User;

if (!isset($_POST['post-search'])) 
{
    $posts = Post::findAll("DESC");
}
else
{
    $posts = Post::findAllByFilters($_POST['post-search'], $_POST['post']['city'], $_POST['post']['order'], $_POST['post']['category'], $_POST['post']['role']);
}

$cities = [
    "Budapest I. kerület", "Budapest II. kerület", "Budapest III. kerület", "Budapest IV. kerület", "Budapest V. kerület",
    "Budapest VI. kerület", "Budapest VII. kerület", "Budapest VIII. kerület", "Budapest IX. kerület", "Budapest X. kerület",
    "Budapest XI. kerület", "Budapest XII. kerület", "Budapest XIII. kerület", "Budapest XIV. kerület", "Budapest XV. kerület",
    "Budapest XVI. kerület", "Budapest XVII. kerület", "Budapest XVIII. kerület", "Budapest XIX. kerület", "Budapest XX. kerület",
    "Budapest XXI. kerület", "Budapest XXII. kerület", "Budapest XXIII. kerület"
];

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
    <form action="index.php?controller=post&action=index" method="POST" class="my-3 text-center">
        <div class="form-row">
            <div class="form-group col-md-6 offset-md-3">
                <label for="post-search">Keresés a posztok között:</label>
                <input type="search" name="post-search" id="post-search" placeholder="Keresés..." <?php echo (isset($_POST['post-search']))?'value = ' . $_POST['post-search']:"" ?> >
            </div>
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-6">
                <label for="post-order">Rendezés:</label>
                <select class="form-control" name="post[order]" id="post-order">
                    <option value="DESC" <?= (isset( $_POST['post']) && $_POST['post']['order'] == "DESC")?"selected":"" ?> >Legfrissebb elől</option>
                    <option value="ASC" <?= (isset( $_POST['post']) && $_POST['post']['order'] == "ASC")?"selected":"" ?> >Legrégebbi elől</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="post-role">Szerep:</label>
                <select class="form-control" name="post[role]">
                    <option value="lookingForHelp" <?= (isset( $_POST['post']) && $_POST['post']['role'] == "lookingForHelp")?"selected":"" ?> >Segítséget kér</option>
                    <option value="lookingToHelp" <?= (isset( $_POST['post']) && $_POST['post']['role'] == "lookingToHelp")?"selected":"" ?> >Segítő</option>
                    <option value="both" <?= (isset( $_POST['post']) && $_POST['post']['role'] == "both")?"selected":"" ?> >Mindegyik</option>
                </select>
            </div>
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-6">
                <label for="post-category">Kategória</label>
                <select class="form-control" name="post[category]" id="post-category">
                    <option value="shopping" <?= (isset( $_POST['post']) && $_POST['post']['category'] == "shopping")?"selected":"" ?>>Vásárlás</option>
                    <option value="other" <?= (isset( $_POST['post']) && $_POST['post']['category'] == "other")?"selected":"" ?>>Egyéb</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="post-city">Városrész:</label>
                <select name="post[city]" id="post-city" class="form-control">
                    <option value="All">Összes</option>
                    <?php foreach($cities as $city) : ?>
                        <?php if (isset( $_POST['post']) && $_POST['post']['city'] == $city) : ?>
                        <?= '<option value="' . $city . '" selected>' . $city . '</option>' ?>
                        <?php else : ?>
                        <?= '<option value="' . $city . '">' . $city . '</option>' ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <input type="submit" value="Szűrés" class="btn-search mt-2">
    </form>
</div>

<div class="container post-container my-3">
    <div class="row">
        <?php if (isset($_POST['post-search']) && count($posts) < 1) : ?>
            <div class="col-12 my-3">
                <div class="alert alert-warning text-center">Nincs a keresésnek megfelelő poszt! :(</div>
            </div>
        <?php else : ?>
        <?php foreach($posts as $post) : ?>
            <?php $user = User::findOneByUserId($post->getAuthor_id()); ?>
            <div class="col-12 post-box my-2">
            <div class="row">
                <div class="col-3 post-img" onclick=<?= "location.href='index.php?controller=user&action=profile&id=" . $user->getId() . "';" ?> style="cursor: pointer;">
                    <img src="img/general_profile_picture.jpg" alt="user-profile-img" title="Ugrás a profilra" class="img-fluid post-img">
                    <p class="author-label text-center">
                        <?php
                            echo $user->getLast_name() . " " . $user->getFirst_name();
                        ?>
                    </p>
                    <p class="author-location text-center">
                        <?php
                            echo $user->getCity();
                        ?>
                    </p>
                </div>
                <div class="col-9 post-content-box" onclick=<?= "location.href='index.php?controller=post&action=view&id=" . $post->getId() . "';" ?> style="cursor: pointer;" >
                    <div class="row">
                    <div class="col-12 post-subject">
                        <?= $post->getSubject(); ?>
                    </div>
                    <div class="col-12 post-content">
                        <?= $post->getPost_content(); ?>
                    </div>
                    </div>
                </div>
            </div>
            <p class="post-info">Státusz: <?= $post->getStatus() ?> | Kategória: <?= $post->getCategory() ?> | <?= $post->getTimestamp() ?></p>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>