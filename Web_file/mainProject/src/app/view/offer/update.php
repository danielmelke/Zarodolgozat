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
if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $offer = Offer::findOneById($_GET['id']);
    if ($offer != null) {
        $valid = $offer->getAuthor_id() == $_SESSION['user_id'];
    }
}

?>

<?php if ($valid) : ?>
<div class="create-form p-3 my-3">
    <h2>Hírdetés létrehozása</h2>
    <form enctype="multipart/form-data" action=<?= "index.php?controller=offer&action=update&id=" . $offer->getId() ?> method="POST">
        <div class="from-group my-3">
            <label for="offer_name">Téma/Cím megadása:</label>
            <input type="text" name="offer[offer_name]" id="offer_name" class="form-control" <?= 'value="' . $offer->getOffer_name() . '"'?> >
        </div>
        <div class="from-group my-3">
            <label for="offer_description">Hírdetés szövege:</label>
            <textarea name="offer[offer_description]" id="offer_description" class="form-control" cols="40" rows="10" placeholder="Ide írhatod a szöveget"><?= $offer->getOffer_description()?></textarea>
            <small id="descriptionHelp" class="form-text text-muted">Itt adhatsz egy részletes leírást</small>
        </div>
        <div class="form-group my-3">
            <label for="offer-image">Kép kiválasztása:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="4000000">
            <input type="file" name="offer[offer_images]" id="offer-image" accept=".jpg, .jpeg, .png"></br>
            <small>Maximum 4Mb, elfogadott fájlkiterjesztések: 'jpg', 'jpeg', 'png'</small>
            <?php if (!empty($offer->getOffer_images())) : ?>
                <div class="col-12 offer-image">
                    <img src=<?= 'img/uploads/' . $offer->getOffer_images() ?> alt="offer-img" title="Ugrás a hírdetésre" class="img img-fluid">
                </div>
            <?php endif; ?>
        </div>
        <div class="from-group my-3">
            <label for="offer_price">Ár:  (Ft)</label>
            <input type="number" name="offer[offer_price]" id="offer_price" class="form-control" <?= 'value="' . $offer->getOffer_price() . '"'?> >
        </div>
        <button type="submit" class="btn btn-secondary register-submit my-3" id="post-submit">Mentés</button>
    </form>
    <div class="button-nav">
        <a class="btn btn-lg btn-secondary" href="index.php?controller=offer&action=index">Vissza</a>
        <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#myModal">Törlés</button>
    </div>
</div>
    <!--Modal-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hírdetés törlése</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Biztosan törölni akarod a hírdetést?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-danger" onclick=<?= "location.href='index.php?controller=offer&action=delete&id=" . $offer->getId() . "';" ?> >Igen! Törlés</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="create-form p-3 my-3">
        <div class="alert alert-warning">
            A hírdetés nem található vagy nincs hozzáférésed :(
        </div>
    </div>
<?php endif; ?>