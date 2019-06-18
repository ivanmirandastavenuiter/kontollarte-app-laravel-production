<!-- --------- GALLERIES --------- -->

<!-- Confirm delete gallery modal -->

<div class="modal fade" id="confirm-delete-gallery-id" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-gallery-id-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm-delete-gallery-id-title">Confirm delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        
        <p>The following gallery will be removed:</p>
        
            <ul>
                <li class="name"><p></p></li>
                <li class="region"><p></p></li>
                <li class="site"><p></p></li>
                <li class="email"><p></p></li>
            </ul>

            <p>Are you sure?</p>     

      </div>
      <div class="modal-footer">
         <form action="" method="post" id="confirm-gallery-id-delete-form">
            @csrf
            <div class="btn-container d-flex justify-content-around">
                <button type="submit" class="btn btn-danger dlt-gallery-btn">Agree and delete</button>
                <button type="button" class="btn btn-warning close-gallery-btn" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Gallery confirming -->

<div class="modal fade" id="confirm-add-gallery" tabindex="-1" role="dialog" aria-labelledby="confirm-add-gallery-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm-add-gallery-title">Confirm adding</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <p>This gallery will be added to your personal list. Agree?</p>
      </div>
      <div class="modal-footer">
        <form action="" method="post" id="confirm-gallery-id-add-form">
            @csrf
            <div class="btn-container d-flex justify-content-around">
                <button type="submit" class="btn btn-danger add-gallery-btn">Agree and add</button>
                <button type="button" class="btn btn-warning add-close-gallery-btn" data-dismiss="modal">Close</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
