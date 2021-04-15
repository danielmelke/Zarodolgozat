<!-- Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1" role="dialog" aria-labelledby="ratingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ratingModalLabel">Felhasználó értékelése</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action=<?= 'index.php?controller=rating&action=create&post_id=' . $post->getId() ?> method="POST" id="createNewRatingForm">
            <div class="form-row my-3">
                <h4>Értékeld <?= $helper->getLast_name() . " " . $helper->getFirst_name() ?> segítségét:</h4>
                <div class="rate my-3 justify-content-center">
                    <input type="radio" id="star5" name="rating[value]" value="5" />
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" id="star4" name="rating[value]" value="4" />
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" name="rating[value]" value="3" />
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" name="rating[value]" value="2" />
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" name="rating[value]" value="1" />
                    <label for="star1" title="text">1 star</label>
                </div>
            </div>
            <button type="submit" class="btn btn-success" id="createNewRating" style="border-radius: 20px">Értékelés</button>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
      </div>
    </div>
  </div>
</div>