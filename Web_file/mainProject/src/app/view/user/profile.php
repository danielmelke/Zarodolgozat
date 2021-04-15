<?php

/**
 * @var app\model\User $user
 * @var app\model\Post $posts
 */

require_once("src/app/model/Post.php");
require_once("src/app/model/User.php");
require_once("src/app/model/Offer.php");
require_once("src/app/model/Rating.php");
use app\model\Post;
use app\model\User;
use app\model\Offer;
use app\model\Rating;

$owner = false;

if (isset($_GET['id'])) {
    $user = User::findOneById($_GET['id']);
    if ($user) {
        $posts = Post::findAllByAuthorId($user->getUser_id(), "DESC");
        $offers = Offer::findAllByAuthorId($user->getUser_id(), "DESC");
        $ratings = Rating::findAllGivenTo($user->getUser_id());
        if (isset($_SESSION['user_id'])) {
            $owner = $user->getUser_id() == $_SESSION['user_id'];
        }    
    }
}

$counties = [
    "Pest"
];

$cities = [
    "Budapest I. kerület", "Budapest II. kerület", "Budapest III. kerület", "Budapest IV. kerület", "Budapest V. kerület",
    "Budapest VI. kerület", "Budapest VII. kerület", "Budapest VIII. kerület", "Budapest IX. kerület", "Budapest X. kerület",
    "Budapest XI. kerület", "Budapest XII. kerület", "Budapest XIII. kerület", "Budapest XIV. kerület", "Budapest XV. kerület",
    "Budapest XVI. kerület", "Budapest XVII. kerület", "Budapest XVIII. kerület", "Budapest XIX. kerület", "Budapest XX. kerület",
    "Budapest XXI. kerület", "Budapest XXII. kerület", "Budapest XXIII. kerület"
];

?>

<?php if ($owner) : ?>
    <div class="register-form p-3 my-3">
    <?php if (isset($_GET['update']) && $_GET['update'] == "success") : ?>
        <div class="alert alert-success">Sikeresen frissítetted az adataidat!</div>
    <?php endif;?>
    <h2>Felhasználói adatok</h2>
    <form id="update" method="POST" action=<?= "index.php?controller=user&action=update&id=" . $user->getId() ?> >
        <div class="form-row">
            <div class="form-group col-md-6 my-3">
                <label for="first_name">Keresztnév</label>
                <input type="text" class="form-control" name="user[first_name]" id="first_name" <?= "value=\"" . $user->getFirst_name() . "\""?> required>
            </div>
            <div class="form-group col-md-6 my-3">
                <label for="last_name">Vezetéknév</label>
                <input type="text" class="form-control" name="user[last_name]" id="last_name" <?= "value=\"" . $user->getLast_name() . "\""?> required>
            </div>
        </div>
        <div class="form-group my-3">
            <label for="email">E-mail cím</label>
            <input type="email" class="form-control" name="user[email]" id="email" aria-describedby="emailHelp" <?= "value=\"" . $user->getEmail() . "\""?> required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 my-3">
                <label for="date">Születési dátum</label>
                <input type="date" class="form-control" name="user[date_of_birth]" id="date" <?= "value=\"" . $user->getDate_of_birth() . "\""?>>
            </div>
            <div class="form-group col-md-4 my-3">
                <label for="county">Megye</label>
                <select class="form-control" name="user[county]" id="county">
                    <?php foreach($counties as $county) : ?>
                        <?php if ($user->getCounty() == $county) : ?>
                            <?= '<option value="' . $county . '" selected>' . $county . '</option>' ?>
                        <?php else : ?>
                            <?= '<option value="' . $county . '">' . $county . '</option>' ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-4 my-3">
                <label for="city" style="font-size: 18px">Város/városrész</label>
                <select class="form-control" name="user[city]" id="city">
                    <?php foreach($cities as $city) : ?>
                        <?php if ($user->getCity() == $city) : ?>
                            <?= '<option value="' . $city . '" selected>' . $city . '</option>' ?>
                        <?php else : ?>
                            <?= '<option value="' . $city . '">' . $city . '</option>' ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-6">
                <label for="user-role">Szereped:</label>
                <select name="user[role]" id="user-role" class="form-control">
                    <option value="lookingForHelp">Segítséget kér</option>
                    <option value="lookingToHelp">Segíteni szeretne</option>
                    <option value="both">Segíteni is szeretne és segítséget is kér</option>
                </select>
            </div>
        </div>
        <div class="form-row my-3">
            <label>Leírás</label>
            <textarea name="user[about]" class="form-control" id="about" cols="30" rows="10" placeholder="Itt rövid bemutatkozót írhatsz magadról"><?php echo ($user->getAbout() !== null)?$user->getAbout():"" ?></textarea>
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-4">
                <label for="phone">Telefonszám:</label>
                <input class="form-control" type="text" name="user[phone]" id="phone" <?= 'value="' . $user->getPhone() . '"' ?> >
                <small>Formátum: maximum 11 karakter, csak számok</small>
            </div>
            <div class="form-check ml-3">
                <input class="form-check-input" type="checkbox" id="phone_visible" name="user[phone_visible]" <?= ($user->getPhone_visible())?"checked":"" ?> >
                <label class="form-check-label" for="phone_validate">
                Beleegyezem, hogy a többi felhasználó láthassa a telefonszámom!
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary register-submit my-3">Mentés</button>
    </form>
    <div class="row justify-content-center my-5 py-2" style="background: rgba(0, 0, 0, 0.5); width: 300px; border-radius: 20px">
        <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#myModal">Profil törlése</button>
    </div>
    <!--Modal-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Profil törlése</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Biztosan törölni akarod a profilod?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-danger" onclick=<?= "location.href='index.php?controller=user&action=delete&id=" . $user->getId() . "';" ?> >Igen! Törlés</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    
<?php else : ?>
    <?php if ($user) : ?>
    <div class="profile-container my-3">
        <div class="profile-about my-3">
            <h2 class="text-center my-3"><?= $user->getLast_name() . " " . $user->getFirst_name() ?> profilja</h2>
            <h5>Született: </h5><p><?= $user->getDate_of_birth() ?></p>
            <h5>Lakhely: </h5><p><?= $user->getCounty() ?> megye, <?= $user->getCity() ?></p>
            <h5>Szerep: </h5>
            <?php if ($user->getRole() == "lookingForHelp") : ?>
            <p>Segítséget kér</p>
            <?php elseif ($user->getRole() == "lookingToHelp") : ?>
            <p>Segíteni szeretne</p>
            <?php elseif ($user->getRole() == "both") : ?>
            <p>Segíteni is szeretne és segítséget is kér</p>
            <?php endif; ?>
            <h5>Leírás</h5>
            <?php if ($user->getAbout() != null) : ?>
                <p><?= $user->getAbout() ?></p>
            <?php else : ?>
                <p>A felhasználó még nem töltötte ki a róla szóló részt :(</p>
            <?php endif; ?>
            <h5>Telefonszám:</h5>
            <?php if ($user->getPhone_visible()) : ?>
                <p><?= $user->getPhone() ?></p>
            <?php else : ?>
                <p>A felhasználó telefonszáma nem publikus vagy nincs megadva</p>
            <?php endif; ?>
        </div>

        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-posts-tab" data-toggle="pill" href="#pills-posts" role="tab" aria-controls="pills-home" aria-selected="true">Posztok</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-offers-tab" data-toggle="pill" href="#pills-offers" role="tab" aria-controls="pills-profile" aria-selected="false">Hírdetések</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Értékelések</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-posts" role="tabpanel" aria-labelledby="pills-posts-tab">
                <div class="container post-container pb-5 pt-2">
                    <h3 class="text-center my-3"><?= $user->getLast_name() . " " . $user->getFirst_name() ?> posztjai</h3>
                    <div class="row">
                        <?php foreach($posts as $post) : ?>
                            <div class="col-12 post-box my-2">
                                <div class="row" onclick=<?= "location.href='index.php?controller=post&action=view&id=" . $post->getId() . "';" ?> style="cursor: pointer;">
                                    <div class="col-12 post-subject">
                                        <?= $post->getSubject(); ?>
                                    </div>
                                    <div class="col-12 post-content">
                                        <?= $post->getPost_content(); ?>
                                    </div>
                                    <p class="post-info mt-2 pl-2">Státusz: <?= $post->getStatus() ?> | Kategória: <?= $post->getCategory() ?> | <?= $post->getTimestamp() ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-offers" role="tabpanel" aria-labelledby="pills-offers-tab">
                <div class="container offer-view">
                    <h2 class="text-center mb-3"><?= $user->getLast_name() . " " . $user->getFirst_name() . " hírdetései" ?></h2>
                    <?php if (count($offers) > 0) : ?>
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
                    <?php else : ?>
                        <div class="alert alert-warning">A felhasználónak nincsenek hírdetései!</div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                <div class="container rating-view">
                    <h2 class="text-center mb-3"><?= $user->getLast_name() . " " . $user->getFirst_name() . " értékelései" ?></h2>
                    <?php if (count($ratings) > 0) : ?>
                        <div class="row my-3">
                        <?php foreach ($ratings as $rating) : ?>
                            <?php $from_user = User::findOneByUserId($rating->getFrom_user()) ?>
                            <div class="col-md-6 rating-view">
                                <h5><?= $from_user->getLast_name() . " " . $from_user->getFirst_name() ?></h5>
                                <p class="rating-value"><?= $rating->getRating_value() ?>/5</p>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="alert alert-warning">A felhasználónak nincsenek értékelései!</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php else : ?>
        <div class="profile-container my-3">
            <h3 class="alert alert-warning text-center my-3">A felhasználó nem található vagy nem létezik! :(</h2>
        </div>
    <?php endif; ?>
<?php endif; ?>