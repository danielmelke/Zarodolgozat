<?php

/**
 * @var \app\model\Post $post
 */
require_once("src/app/model/Post.php");
require_once("src/app/model/Product.php");
use app\model\Post;
use app\model\Product;

$products = Product::findAll();

?>

<div class="create-form p-3 my-3">
    <h2>Poszt létrehozása</h2>
    <form action="index.php?controller=post&action=create" method="POST">
        <div class="from-group my-3">
            <label for="subject">Téma/Cím megadása:</label>
            <input type="text" name="post[subject]" id="subject" class="form-control">
            <small id="subjectHelp" class="form-text text-muted">Egy rövid, tömör, lényegretörő leírás a posztról</small>
        </div>
        <div class="from-group my-3">
            <label for="post-content">Poszt szövege:</label>
            <textarea name="post[post_content]" id="post-content" class="form-control" cols="40" rows="10" placeholder="Ide írhatod a szöveget"></textarea>
            <small id="subjectHelp" class="form-text text-muted">Itt kifejtheted a problémát, megadhatsz részleteket, amik szerinted fontosak lehetnek</small>
        </div>
        <div class="form-row my-3">
            <div class="form-group col-md-6">
                <label for="post-category">Kategória:</label>
                <select name="post[category]" id="post-category" class="form-control">
                    <option value="other">Egyéb</option>
                    <option value="shopping">Vásárlás</option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="post-role">Szerep:</label>
                <select name="post[role]" id="post-role" class="form-control">
                    <option value="lookingForHelp">Segítséget kér</option>
                    <option value="lookingToHelp">Segítő</option>
                    <option value="both">Mindegyik</option>
                </select>
            </div>
        </div>
        <div class="form-row shop-div" id="shop-div">
            <h4 class="text-center">Vásárlás paraméterei</h4>
            <div id="productRow">
            <div class="row product-row my-2 py-2" id="product-row">
                <div class="form-group col-md-4">
                    <label for="product-name">Elem kiválasztása</label>
                    <select name="row[1][product_name]" id="product-name" class="form-control">
                        <?php foreach ($products as $product) : ?>
                            <option value=<?= $product->getId() ?> ><?= $product->getName() ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="cart-amount">Mennyiség (szám)</label>
                    <input type="number" name="row[1][cart_amount]" id="cart-amount" class="form-control">
                </div>
                <div class="form-group col-md-4">
                    <label for="cart-measure">Mértékegység</label>
                    <select name="row[1][cart_measure]" id="cart-measure" class="form-control">
                        <option value="Darab">Darab</option>
                        <option value="Kilogram">Kilogram</option>
                        <option value="Dekagram">Dekagram</option>
                        <option value="Gram">Gram</option>
                        <option value="liter">Liter</option>
                        <option value="Doboz">Doboz</option>
                        <option value="Üveg">Üveg</option>
                        <option value="Zacskó">Zacskó</option>
                        <option value="Csomag">Csomag</option>
                    </select>
                </div>
                <div class="form-group col-md-6 offset-md-3">
                    <label for="cart-content">Megjegyzések:</label>
                    <textarea name="row[1][cart_content]" id="cart-content" cols="30" rows="3" class="form-control"></textarea>
                </div>
            </div>
            </div>
            <div class="row button-nav">
                <!-- Shopping modal -->
                <button type="button" class="btn btn-secondary my-2" data-toggle="modal" data-target="#shoppingModal">
                Új elem hozzáadása
                </button>
                <button type="button" class="btn btn-secondary my-2" id="new-product-row">Új sor hozzáadása (max 10)</button>
            </div>
        </div>
        <button type="submit" class="btn btn-secondary register-submit my-3" id="post-submit">Posztolás</button>
    </form>
</div>

<?php include("_shopping_modal.php") ?>