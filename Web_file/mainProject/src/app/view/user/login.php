<?php
/**
 * @var \app\model\User $user
 */

use app\model\User;
require_once('src/app/model/User.php');

// if (isset($_SESSION['user_id'])) {
//     $user = User::findOneByUserId($_SESSION['user_id']);
// }
// else {
//     $user = new User();
// }


?>

<?php if (isset($_GET['register'])) : ?>
    <?php if ($_GET['register'] == "success") : ?>
          <div class="row">
            <div class="col-12">
                <div class="alert alert-success my-3">
                    Sikeres regisztráció! Most már be tud jelentkezni!
                </div>
            </div>
          </div>  
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($_GET['login'])) : ?>
    <?php if ($_GET['login'] == "error") : ?>
          <div class="row">
            <div class="col-12">
                <div class="alert alert-warning my-3">
                    Valami hiba történt a bejelentkezés során! :(
                </div>
            </div>
          </div>  
    <?php endif; ?>
<?php endif; ?>
<div class="login-form p-3 my-3">
    <h2>Bejelentkezés</h2>
    <form id="login" method="POST" action="index.php?controller=user&action=login">
        <div class="form-group my-3">
            <label for="email">E-mail cím</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="E-mail *" required>
        </div>
        <div class="form-group my-3">
            <label for="password">Jelszó</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Jelszó *" required>
        </div>
        
        <button type="submit" class="btn btn-secondary login-submit my-3">Bejelentkezés</button>

        <p class="my-3">Nincs még fiókod? <b><a href="index.php?controller=user&action=register">Regisztrálj itt!</a></b></p>
    </form>
</div>
