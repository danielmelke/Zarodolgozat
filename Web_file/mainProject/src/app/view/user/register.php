<?php

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

/**
 * @var \app\model\User $user
 */

use app\model\User;

?>

<?php if (isset($_GET['register']) && $_GET['register'] == "error") : ?>
    <div class="alert alert-warning">Valami hiba történt a regisztráció során! </br>Lehet, hogy az e-mail cím már foglalt! :(</br>Ügyelj, hogy minden mező ki legyen töltve</div>
<?php endif; ?>

<div class="register-form p-3 my-3">
    <h2>Regisztráció</h2>
    <form id="register" method="POST" action="index.php?controller=user&action=register">
        <div class="form-row">
            <div class="form-group col-md-6 my-3">
                <label for="first_name">Keresztnév</label>
                <input type="text" class="form-control" name="user[first_name]" id="first_name" required>
            </div>
            <div class="form-group col-md-6 my-3">
                <label for="last_name">Vezetéknév</label>
                <input type="text" class="form-control" name="user[last_name]" id="last_name" required>
            </div>
        </div>
        <div class="form-group my-3">
            <label for="email">E-mail cím</label>
            <input type="email" class="form-control" name="user[email]" id="email" aria-describedby="emailHelp" required>
            <small id="emailHelp" class="form-text text-muted">example@example.com</small>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6 my-3">
                <label for="password">Jelszó</label>
                <input type="password" class="form-control" name="user[password]" id="password" required>
                <small id="passwordHelp" class="form-text text-muted">Minimum 8 karakter</small>
            </div>
            <div class="form-group col-md-6 my-3">
                <label for="passwordConfirm">Jelszó megerősítés</label>
                <input type="password" class="form-control" name="user[passwordConfirm]" id="passwordConfirm" required>
                <small id="passwordHelp" class="form-text text-muted">A két jelszónak egyeznie kell</small>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4 my-3">
                <label for="date">Születési dátum</label>
                <input type="date" class="form-control" name="user[date_of_birth]" id="date">
            </div>
            <div class="form-group col-md-4 my-3">
                <label for="county">Válaszd ki a megyét:</label>
                <select class="form-control" name="user[county]" id="county">
                    <option value="">...</option>
                    <?php foreach($counties as $county) : ?>
                    <?= '<option value="' . $county . '">' . $county . '</option>' ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-md-4 my-3">
                <label for="city" style="font-size: 18px">Válaszd ki a várost/részt:</label>
                <select class="form-control" name="user[city]" id="city">
                    <option value="">...</option>
                    <?php foreach($cities as $city) : ?>
                    <?= '<option value="' . $city . '">' . $city . '</option>' ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-6">
                <label for="user-role">Válasz ki a szereped:</label>
                <select name="user[role]" id="user-role" class="form-control">
                    <option value="lookingForHelp">Segítséget kér</option>
                    <option value="lookingToHelp">Segíteni szeretne</option>
                    <option value="both">Segíteni is szeretne és segítséget is kér</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary register-submit my-3">Regisztrálok</button>
    </form>
    <p class="my-3">Van már fiókod? <b><a href="index.php?controller=user&action=login">Jelentkezz be itt!</a></b></p>
</div>