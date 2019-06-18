<!-- --------- PAINTINGS --------- -->

<!-- Upload new picture -->

<div class="modal fade" id="upload-paint" tabindex="-1" role="dialog" aria-labelledby="upload-picture-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="upload-picture-title">Upload picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      @if($errors->hasBag('uploadError'))
            <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors
                                    ->getBag('uploadError')
                                    ->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
            </div>
      @endif

      <div class="message-status" message-status=true></div>

      <script>

      $(document).ready(function () {

        $('#upload-paint').on('hidden.bs.modal', function (e) {

          var messagesShown = $('.message-status').attr('message-status')

          if (messagesShown) {
            $('.alert.alert-danger').css('display', 'none')
          }

          $('.message-status').attr('message-status', false)
        })

      })

      </script>
        <form action="{{ route('paintings.upload') }}" method="post" enctype="multipart/form-data" id="upload-paint-form">
          @csrf
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title">
          </div>
                
              <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" name="date" placeholder="Date">
          </div>

              <div class="form-group">
            <label for="description">Description</label>
                  <textarea class="form-control" rows="5" name="description" id="description"></textarea>
          </div>

          <div class="input-group mb-3">
              <div class="custom-file">
                  <input type="file" class="custom-file-input" aria-describedby="uploadImage" id="uploadImage" accept="image/*" name="image" />
                  <label class="custom-file-label" for="uploadImage">Choose file</label>
              </div>
          </div>

          <div id="preview"></div>
          <div id="err"></div>
  
          <div class="btn-container d-flex justify-content-around">
            <button type="submit" class="btn btn-warning btn-submit">Upload</button>
            <button type="button" class="btn btn-success btn-prev" disabled>Preview</button>
            <button type="button" class="btn btn-danger btn-close-modal" data-dismiss="modal">Close</button>
          </div>
          
		    </form>
      
      </div>
    </div>
  </div>
</div>

<!-- Upload new picture -->

<div class="modal fade" id="update-paint" tabindex="-1" role="dialog" aria-labelledby="upload-paint-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="upload-paint-title">Update picture</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      @if($errors->hasBag('updateError'))
            <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors
                                    ->getBag('updateError')
                                    ->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
            </div>
      @endif

      <div class="message-status" message-status=true></div>

      <script>

      $(document).ready(function () {

        $('#update-paint').on('hidden.bs.modal', function (e) {

          var messagesShown = $('.message-status').attr('message-status')

          if (messagesShown) {
            $('.alert.alert-danger').css('display', 'none')
          }

          $('.message-status').attr('message-status', false)
        })

      })

      </script>
      
        <form action="{{ route('paintings.update') }}" method="post" enctype="multipart/form-data" id="update-paint-form">
          @csrf
          <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" placeholder="Title">
          </div>
                
              <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" name="date" placeholder="Date">
          </div>

              <div class="form-group">
            <label for="description">Description</label>
                  <textarea class="form-control" rows="5" name="description" id="description"></textarea>
          </div>

          <div class="input-group mb-3">
              <div class="custom-file">
                  <input type="file" class="custom-file-input" aria-describedby="uploadImageForUpdate" id="uploadImageForUpdate" accept="image/*" name="image" />
                  <label class="custom-file-label" for="uploadImageForUpdate">Choose file</label>
              </div>
          </div>

          <div id="preview"></div>
          <div id="err"></div>

          <div class="btn-container d-flex justify-content-around">
            <input type="hidden" name="paintId">
            <button type="submit" class="btn btn-warning btn-submit">Update</button>
            <button type="button" class="btn btn-success btn-prev" disabled>Preview</button>
            <button type="button" class="btn btn-danger btn-close-modal" data-dismiss="modal">Close</button>
          </div>

		    </form>
      
      </div>


    </div>
  </div>
</div>

<!-- Confirm delete modal -->

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="confirm-delete-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm-delete-title">Confirm delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>This paint will be permanently removed. Are you sure?</p>
      </div>
      <div class="modal-footer">
        
          <form action="{{ route('paintings.delete') }}" method="post" id="delete-form">
            @csrf
            <div class="btn-container d-flex justify-content-around">
                <input type="hidden" name="delete-paintId">
                <button type="submit" class="btn btn-danger confirm-dlt-btn">Delete</button>
                <button class="btn btn-warning close-dlt-btn" data-dismiss="modal">Back</button>
            </div>
          </form>
        
      </div>
    </div>
  </div>
</div>




