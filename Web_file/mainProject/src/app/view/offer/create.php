<?php
/**
 * @var app\model\Offer $offer
 * @var app\model\User $user
 */

require_once("src/app/model/Offer.php");
require_once("src/app/model/User.php");
use app\model\Offer;
use app\model\User;

?>
<?php if (isset($_GET['create']) && $_GET['create'] == "error") : ?>
    <div class="alert alert-warning">Valami hiba történt a hirdetés létrehozása során! :(</br>Ügyelj, hogy minden mező ki legyen töltve</div>
<?php endif; ?>
<div class="create-form p-3 my-3">
    <h2>Hírdetés létrehozása</h2>
    <form enctype="multipart/form-data" action="index.php?controller=offer&action=create" method="POST">
        <div class="from-group my-3">
            <label for="offer_name">Téma/Cím megadása:</label>
            <input type="text" name="offer[offer_name]" id="offer_name" class="form-control">
        </div>
        <div class="from-group my-3">
            <label for="offer_description">Hírdetés szövege:</label>
            <textarea name="offer[offer_description]" id="offer_description" class="form-control" cols="40" rows="10" placeholder="Ide írhatod a szöveget"></textarea>
            <small id="descriptionHelp" class="form-text text-muted">Itt adhatsz egy részletes leírást</small>
        </div>
        <div class="form-group my-3">
            <label for="offer-image">Kép kiválasztása:</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="4000000">
            <input type="file" name="offer[offer_images]" id="offer-image" accept=".jpg, .jpeg, .png"></br>
            <small>Maximum 4Mb, elfogadott fájlkiterjesztések: 'jpg', 'jpeg', 'png'</small>
        </div>
        <div class="from-group my-3">
            <label for="offer_price">Ár:  (Ft)</label>
            <input type="number" name="offer[offer_price]" id="offer_price" class="form-control">
        </div>
        <button type="submit" class="btn btn-secondary register-submit my-3" id="post-submit">Posztolás</button>
    </form>
</div>