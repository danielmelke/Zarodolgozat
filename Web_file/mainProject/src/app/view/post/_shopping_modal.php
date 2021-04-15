<!-- Modal -->
<div class="modal fade" id="shoppingModal" tabindex="-1" role="dialog" aria-labelledby="shoppingModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shoppingModalLabel">Új elem hozzáadása</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="index.php?controller=product&action=create" method="POST" id="createNewProductForm">
            <div class="form-row my-3">
                <div class="form-group">
                    <label for="product-name">Megnevezés:</label>
                    <input type="text" name="product[name]" id="product-name" class="form-control">
                </div>
            </div>
        </form>
        <div class="col-12 alert alert-warning text-center">
          Figyelem! Az újonnan hozzáadott elemek nem kerülnek be egyből az összes listába!
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Mégse</button>
        <button type="button" class="btn btn-success" id="createNewProduct" style="border-radius: 20px">Hozzáadás</button>
      </div>
    </div>
  </div>
</div>