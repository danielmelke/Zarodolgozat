<?php
/**
 * @var app\model\Offer $offers
 * @var app\model\User $user
 */

require_once("src/app/model/Offer.php");
require_once("src/app/model/User.php");
use app\model\Offer;
use app\model\User;

if (!isset($_POST['offer-search'])) 
{
    $offers = Offer::findAll("DESC");
}
else
{
    $offers = Offer::findAllByFilters($_POST['offer-search'], $_POST['offer']['city'], $_POST['offer']['order']);
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
<div class="alert alert-success">Sikeresen szerkesztetted a hírdetésed! :)</div>
<?php endif; ?>
<?php if (isset($_GET['create']) && $_GET['create'] == "success") : ?>
<div class="alert alert-success">Sikeresen létrehoztad a hírdetésed! :)</div>
<?php endif; ?>

<?php if (isset($_GET['delete'])) : ?>
    <?php if ($_GET['delete'] == "success") : ?>
        <div class="alert alert-success">Sikeresen törölted a hírdetésed! :)</div>
    <?php else : ?>
        <div class="alert alert-warning">Valami hiba történt a hírdetés törlése során! :(</div>
    <?php endif; ?>
<?php endif; ?>

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
            <div class="form-group col-md-6">
                <label for="offer-order">Rendezés:</label>
                <select class="form-control" name="offer[order]" id="offer-order">
                    <option value="DESC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "DESC")?"selected":"" ?> >Legfrissebb elől</option>
                    <option value="ASC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "ASC")?"selected":"" ?> >Legrégebbi elől</option>
                    <option value="priceDESC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "priceDESC")?"selected":"" ?> >Ár szerint csökkenő</option>
                    <option value="priceASC" <?= (isset( $_POST['offer']) && $_POST['offer']['order'] == "priceASC")?"selected":"" ?> >Ár szerint növekvő</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="offer-city">Városrész:</label>
                <select name="offer[city]" id="offer-city" class="form-control">
                    <option value="All">Összes</option>
                    <?php foreach($cities as $city) : ?>
                        <?php if (isset( $_POST['offer']) && $_POST['offer']['city'] == $city) : ?>
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
        <?php if (isset($_POST['offer-search']) && count($offers) < 1) : ?>
            <div class="col-12 my-3">
                <div class="alert alert-warning text-center">Nincs a keresésnek megfelelő poszt! :(</div>
            </div>
        <?php else : ?>
        <?php foreach($offers as $offer) : ?>
            <?php $user = User::findOneByUserId($offer->getAuthor_id()); ?>
            <div class="col-12 offer-container my-3 p-2">
                <div class="row offer-header-row">
                    <div class="col-md-6 offer-user" onclick=<?= "location.href='index.php?controller=user&action=profile&id=" . $user->getId() . "';" ?> style="cursor: pointer;">
                        <img src="img/general_profile_picture.jpg" alt="user-profile-img" title="Ugrás a profilra" class="img-fluid">
                        <p>
                        <?php
                        echo $user->getLast_name() . " " . $user->getFirst_name();
                        ?> </br> 
                        <?php
                        echo $user->getCity();
                        ?>
                        </p>
                    </div>
                    <div class="col-md-6 offer-header">
                        <p><?= $offer->getOffer_name() ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 offer-image" onclick=<?= "location.href='index.php?controller=offer&action=view&id=" . $offer->getId() . "';" ?> style="cursor: pointer;">
                    <?php if (!empty($offer->getOffer_images())) : ?>
                        <img src=<?= 'img/uploads/' . $offer->getOffer_images() ?> alt="offer-img" title="Ugrás a hírdetésre" class="img img-fluid">
                    <?php else : ?>
                        <img src="img/unknown_img.jpg" alt="offer-img" title="Ugrás a hírdetésre" class="img img-fluid">
                    <?php endif; ?>
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
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>