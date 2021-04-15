<?php
/**
 * @var app\model\User $user
 * @var app\model\Post $post
 */
require_once("src/app/model/Post.php");
require_once("src/app/model/User.php");
use app\model\Post;
use app\model\User;

$valid = false;
if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $post = Post::findOneById($_GET['id']);
    if ($post != null) {
        $valid = $post->getAuthor_id() == $_SESSION['user_id'];
    }
}

?>


<?php if ($valid) : ?>
    <div class="create-form p-3 my-3">
    <h2>Poszt szerkesztése</h2>
    <form action=<?= "index.php?controller=post&action=update&id=" . $post->getId() ?> method="POST">
        <div class="from-group my-3">
            <label for="subject">Téma/Cím megadása:</label>
            <input type="text" name="post[subject]" id="subject" class="form-control" <?= "value=\"" . $post->getSubject() . "\""?> >
            <small id="subjectHelp" class="form-text text-muted">Egy rövid, tömör, lényegretörő leírás a posztról</small>
        </div>
        <div class="from-group my-3">
            <label for="post-content">Poszt szövege:</label>
            <textarea name="post[post_content]" id="post-content" class="form-control" cols="40" rows="10" placeholder="Ide írhatod a szöveget"> <?= $post->getPost_content()?> </textarea>
            <small id="subjectHelp" class="form-text text-muted">Itt kifejtheted a problémát, megadhatsz részleteket, amik szerinted fontosak lehetnek</small>
        </div>
        <button type="submit" class="btn btn-secondary register-submit my-3" id="post-submit">Mentés</button>
    </form>
        <div class="button-nav">
            <a class="btn btn-lg btn-secondary" href="index.php?controller=post&action=index">Vissza</a>
            <button type="button" class="btn btn-lg btn-danger" data-toggle="modal" data-target="#myModal">Törlés</button>
        </div>
    </div>
    <!--Modal-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Poszt törlése</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Biztosan törölni akarod a posztot?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-danger" onclick=<?= "location.href='index.php?controller=post&action=delete&id=" . $post->getId() . "';" ?> >Igen! Törlés</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Mégse</button>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
    <div class="create-form p-3 my-3">
        <div class="alert alert-warning">
            A poszt nem található vagy nincs hozzáférésed :(
        </div>
    </div>
<?php endif; ?>