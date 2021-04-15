<?php
/**
 * @var app\model\Offer $offer
 * @var app\model\User $user
 */

require_once("src/app/model/Offer.php");
require_once("src/app/model/User.php");
use app\model\Offer;
use app\model\User;

$valid = false;
$owner = false;

if ($_GET['id']) 
{
    $offer = Offer::findOneById($_GET['id']);
    $valid = ($offer)?true:false;
    if ($valid)
    {
        $offerOwner = User::findOneByUserId($offer->getAuthor_id());
        if (isset($_SESSION['user_id']))
        {
            $owner = ($_SESSION['user_id'] == $offerOwner->getUser_id())?true:false;
        }
    }
}

?>

<?php if ($valid) : ?>
<div class="container offer-view">
    <h2 class="text-center mb-3"><?= $offerOwner->getLast_name() . " " . $offerOwner->getFirst_name() . " posztja" ?></h2>
    <div class="row my-3">
        <div class="col-12 offer-image">
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
    <?php if ($owner) : ?>
    <div class="row my-3 justify-content-between">
        <a class="btn btn-lg btn-secondary" href="index.php?controller=offer&action=index">Vissza</a>
        <button type="button" class="btn btn-secondary btn-lg" onclick=<?= "location.href='index.php?controller=offer&action=update&id=" . $offer->getId() . "';" ?>>Szerkesztés</button>
    </div>
    <?php else : ?>
    <div class="row my-3">
        <a class="btn btn-lg btn-secondary" href="index.php?controller=offer&action=index">Vissza</a>
    </div>
    <?php endif; ?>
</div>
<?php else : ?>
    <div class="alert alert-warning text-center">Valami hiba történt! :(</div>
<?php endif; ?>