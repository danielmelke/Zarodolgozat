<?php
/**
 * @var app\model\User $user
 * @var app\model\Post $post
 */

require_once("src/app/model/Post.php");
require_once("src/app/model/User.php");
require_once("src/app/model/Cart.php");
require_once("src/app/model/Product.php");
require_once("src/app/model/Rating.php");
use app\model\Post;
use app\model\User;
use app\model\Cart;
use app\model\Product;
use app\model\Rating;

$valid = false;
$owner = false;
$shopping = false;
$rated = false;

if ($_GET['id']) 
{
    $post = Post::findOneById($_GET['id']);
    $valid = ($post)?true:false;
    $shopping = ($post->getCategory() == "Vásárlás")?true:false;
    if ($valid)
    {
        $postOwner = User::findOneByUserId($post->getAuthor_id());
        if ($shopping)
        {
            $items = Cart::findAllById($post->getCart_id());
        }
        if (isset($_SESSION['user_id']))
        {
            $owner = ($_SESSION['user_id'] == $postOwner->getUser_id())?true:false;
        }
        if (($rating = Rating::findOneByPostId($_GET['id'])) && isset($rating) && $rating != null)
        {
            $rated = true;
        }
    }
}

?>

<?php if (isset($_GET['helper']) && $_GET['helper'] == "success") : ?>
    <div class="alert alert-success">Sikeresen elvállaltad a segítségnyújtást! :)</div>
<?php elseif (isset($_GET['helper']) && $_GET['helper'] == "error") : ?>
    <div class="alert alert-warning">Valami hiba történt! :(</div>
<?php endif; ?>
<?php if (isset($_GET['end']) && $_GET['end'] == "success") : ?>
    <div class="alert alert-success">Sikeresen befejezted a segítségnyújtást! :)</div>
<?php elseif (isset($_GET['end']) && $_GET['end'] == "error") : ?>
    <div class="alert alert-warning">Valami hiba történt! :(</div>
<?php endif; ?>

<?php if ($valid) : ?>
<div class="container post-view">
    <h2 class="text-center"><?= $postOwner->getLast_name() . " " . $postOwner->getFirst_name() . " posztja" ?></h2>
    <div class="row my-3">
        <div class="col-12">
            <div class="row">
                <div class="col-12 post-subject">
                    <?= $post->getSubject(); ?>
                </div>
                <pre>
                <div class="col-12 text-justify" style="display: block; white-space: pre-line; font-size: 1.2em">
                    <?= $post->getPost_content(); ?>
                </div>
                </pre>
                <?php if ($shopping) : ?>
                    <div class="col-12 cart-diplay my-5">
                    <table class="table table-sm table-striped table-secondary">
                        <thead>
                            <tr>
                                <th scope="col" style="font-size: 18px">Megnevezés</th>
                                <th scope="col" style="font-size: 18px">Mennyiség</th>
                                <th scope="col" class="text-center" style="font-size: 18px">Megjegyzés</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item) : ?>
                            <?php $product = Product::findOneById($item->getProduct_id()); ?>
                            <tr>
                                <td style="font-size: 18px"><?= $product->getName() ?></td>
                                <td style="font-size: 18px"><?= $item->getAmount() ?> <?= $item->getMeasure() ?></td>
                                <td class="text-center" style="font-size: 18px"><?= $item->getContent() ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                <?php endif; ?>
                <?php if ($post->getHelper_id() != null) : ?>
                <div class="col-12 my-3 text-right">
                    <?php $helper = User::findOneByUserId($post->getHelper_id()); ?>
                    Segítő: <?= $helper->getLast_name() . " " . $helper->getFirst_name() ?><?= ($post->getStatus() == "Befejezett")?" | <b>Befejezve</b>":"" ?>
                </div>
                <?php endif; ?>
                <div class="col-12 post-time text-right">
                    <?= $post->getTimestamp(); ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ($owner) : ?>
    <div class="row my-3 justify-content-around">
        <a class="btn btn-lg btn-secondary" href="index.php?controller=post&action=index">Vissza</a>
        <?php if ($post->getStatus() == "Befejezett" && !$rated) : ?>
        <!-- Rating modal -->
        <button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#ratingModal">
        Segítő értékelése
        </button>
        <?php endif; ?>
        <button type="button" class="btn btn-secondary btn-lg" onclick=<?= "location.href='index.php?controller=post&action=update&id=" . $post->getId() . "';" ?>>Szerkesztés</button>
    </div>
    <?php else : ?>
    <div class="row my-3 justify-content-around">
        <a class="btn btn-lg btn-secondary" href="index.php?controller=post&action=index">Vissza</a>
        <?php if ($post->getStatus() == "Aktív" && isset($_SESSION['user_id']) && $post->getRole() == "lookingForHelp") : ?>
            <a class="btn btn-lg btn-secondary" href=<?='index.php?controller=post&action=helper&id=' . $post->getId() ?> >Szeretnék segíteni</a>
        <?php elseif ($post->getStatus() == "Folyamatban" && isset($_SESSION['user_id']) && $post->getHelper_id() == $_SESSION['user_id']) : ?>
            <a class="btn btn-lg btn-secondary" href=<?='index.php?controller=post&action=end&id=' . $post->getId() ?> >Befejezve</a>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
<?php else :?>
    <div class="alert alert-warning text-center">Valami hiba történt! :(</div>
<?php endif;?>

<?php if ($post->getStatus() == "Befejezett" && !$rated) : ?>
<?php require_once("_rating_modal.php") ?>
<?php endif; ?>