<?php

require_once("src/app/model/User.php");
use app\model\User;
if (isset($_SESSION['user_id'])) {
    $user = User::findOneByUserId($_SESSION['user_id']);
}
?>

<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" id="closebtn" onclick="moveNav()">&#10096;</a>
    <a href="index.php?controller=site&action=about">Az oldalról</a>
    <a href="index.php?controller=post&action=index">Posztok</a>
    <a href="index.php?controller=offer&action=index">Keres-kínál</a>
    <?php if (isset($_SESSION['user_id'])) : ?>
        <a href="index.php?controller=post&action=create">Poszt létrehozása</a>
        <a href="index.php?controller=user&action=posts&order=desc">Saját posztok</a>
        <a href="index.php?controller=offer&action=create&order=desc">Hírdetés létrehozása</a>
        <a href="index.php?controller=user&action=offers&order=desc">Saját hírdetések</a>
        <a href=<?= "index.php?controller=user&action=profile&id=" . $user->getId() ?> >Fiók beállítások</a>
        <a class="btn btn-secondary btn-logout" href="index.php?controller=user&action=logout">Kijelentkezés</a>
    <?php else : ?>
        <a class="sidebar-action-buttons" href="index.php?controller=user&action=login">Bejelentkezés</a>
        <a href="index.php?controller=user&action=register">Regisztráció</a>
    <?php endif; ?>
</div>