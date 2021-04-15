<?php
/**
 * @var app\model\Offer $offers
 */

require_once("src/app/model/Offer.php");
require_once("src/app/model/User.php");
use app\model\Offer;
use app\model\User;

$user = User::findOneByUserId($_SESSION['user_id']);
if (!isset($_POST['post-search'])) 
{
    $offers = Offer::findAllByAuthorId($_SESSION['user_id'], $_GET['order']);
}
else
{
    $offers = Offer::findAllByAuthorId($_SESSION['user_id'], $_POST['sort_order'], $_POST['post-search'], $_POST['post']['category']);
}

?>

<div class="container search-area pb-2">
    <div class="row">
        <div class="col-12 text-center my-3">
            <h2>Keres-kínál hírdetések</h2>
        </div>
    </div>
    <form action="index.php?controller=offer&action=index" method="POST" class="my-3 text-center">
        <div class="form-row my-3">
            <div class="form-group col-md-6 offset-md-3">
                <label for="offer-search">Keresés a hírdetések között:</label>
                <input type="search" name="offer-search" id="offer-search" placeholder="Keresés..." <?php echo (isset($_POST['offer-search']))?'value = ' . $_POST['offer-search']:"" ?> >
            </div>
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-6 offset-md-3">
                <label for="offer-order">Rendezés:</label>
                <select class="form-control" name="offer[order]" id="offer-order">
                    <option value="DESC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "DESC")?"selected":"" ?> >Legfrissebb elől</option>
                    <option value="ASC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "ASC")?"selected":"" ?> >Legrégebbi elől</option>
                    <option value="priceDESC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "priceDESC")?"selected":"" ?> >Ár szerint csökkenő</option>
                    <option value="priceASC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "priceASC")?"selected":"" ?> >Ár szerint növekvő</option>
                </select>
            </div>
        </div>
        <input type="submit" value="Szűrés" class="btn-search mt-2">
    </form>
</div>

<div class="container offer-view">
    <h2 class="text-center mb-3"><?= $user->getLast_name() . " " . $user->getFirst_name() . " hírdetései" ?></h2>
    <?php foreach ($offers as $offer) : ?>
    <div class="row my-3">
        <div class="col-12 offer-view">
            <div class="row my-3">
                <div class="col-12 offer-image" onclick=<?= "location.href='index.php?controller=offer&action=view&id=" . $offer->getId() . "';" ?> style="cursor: pointer;" >
                    <?php if (!empty($offer->getOffer_images())) : ?>
                        <img src=<?= 'img/uploads/' . $offer->getOffer_images() ?> alt="offer-img" title="Ugrás a hírdetésre" class="img img-fluid">
                    <?php else : ?>
                        <img src="img/unknown_img.jpg" alt="offer-img" title="Ugrás a hírdetésre" class="img img-fluid">
                    <?php endif; ?>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-12 offer-header">
                    <h3><?= $offer->getOffer_name() ?><h3>
                </div>
            </div>
            <div class="row my-3">
                <div class="col-8 offer-info">
                    <p><?= $offer->getOffer_description() ?></p>
                </div>
                <div class="col-4 offer-price">
                    <p><?= $offer->getOffer_price() ?> Ft</p>
                </div>
            </div>
            <div class="col-12 post-time">
                <?= $offer->getOffer_timestamp() ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>