<?php 
/**
 * @var string $content
 * @var string $title
 */

require_once("src/app/controller/UserController.php");
require_once("src/app/model/User.php");

use app\controller\UserController;
use app\model\User;

if (isset($_SESSION['user_id'])) {
  $user = User::findOneByUserId($_SESSION['user_id']);
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <script src="js/sidebar.js" defer></script>
</head>
<body>
    <!-- SIDEBAR -->
    <?php include_once("src/app/view/templates/sidebar.php") ?>
    <!-- MAIN SECTION -->
    <div id="main">
    <!-- NAVBAR -->
    <?php include_once("src/app/view/templates/navbar.php") ?>
    <!-- CONTENT -->
    <?php if (isset($_GET['login']) && $_GET['login'] == "success") : ?>
      <div class="row">
        <div class="col-12">
          <div class="alert alert-success my-3" style="text-align: center;">
              Üdvözlünk <?= $user->getLast_name() ?> <?= $user->getFirst_name() ?>!
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?= $content ?>
    <!-- END OF MAIN SECTION -->
    </div>
    <!-- FOOTER -->
    <footer>
      Melke Daniel 2021
    </footer>
    <!-- SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
    <?= ($title == "Új poszt létrehozása")?'<script src="js/create-shopping.js"></script>':"" ?>
    <script src="js/img.js"></script>
</body>
</html>