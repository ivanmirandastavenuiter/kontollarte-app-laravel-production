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

      @if ($errors->any())
            <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
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
      <!-- enctype="multipart/form-data"-->
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
  
          <button type="submit" class="btn btn-warning">Upload</button>
          <button type="button" class="btn btn-success" id="btn-prev">Preview</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		    </form>
      
      </div>


    </div>
  </div>
</div>

