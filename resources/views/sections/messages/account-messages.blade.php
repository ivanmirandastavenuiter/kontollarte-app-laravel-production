<!-- --------- ACCOUNT --------- -->

<!-- Update user modal form -->
<div class="modal fade" id="update-user" tabindex="-1" role="dialog" aria-labelledby="update-user-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="update-user-title">Update user</h5>
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

          $('#update-user').on('hidden.bs.modal', function (e) {

            var messagesShown = $('.message-status').attr('message-status')

            if (messagesShown) {
              $('.alert.alert-danger').css('display', 'none')
            }

            $('.message-status').attr('message-status', false)
          })

        })

        </script>

        <!-- Form body -->

        <form method="post" id="update-form" action="{{ url('account/validate') }}">
          @csrf
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="{{ $currentUser->username }}" placeholder="Username">
          </div>
              <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $currentUser->name }}" placeholder="Name">
          </div>
              <div class="form-group">
            <label for="surname">Surname</label>
            <input type="text" class="form-control" name="surname" value="{{ $currentUser->surname }}" placeholder="Surname">
          </div>
              <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $currentUser->email }}" placeholder="Email">
          </div>
              <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" class="form-control" pattern="[0-9]{9}" name="phone" value="{{ $currentUser->phone }}" placeholder="Phone">
          </div>
            <input type="submit" class="btn btn-warning" value="Update" />
            <button class="btn btn-danger" data-dismiss="modal">Close</button>
        </form>

          <!-- <script>

          function submitForm() {
              $("#update-form").submit();
          }
          
          </script> -->
        
      </div>
    </div>
  </div>
</div>

<!-- Delete success -->

<div class="modal" id="delete-success" data-keyboard="false" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Info</h5>
                <form action=" {{ route('logout') }}" method="post" id="cross-delete-form">
                  @csrf
                  <a onclick="$('#cross-delete-form').submit()" class="close" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </a>
                </form>
            </div>
            <div class="modal-body">
                <p>User deleted successfully</p>
            </div>
            <div class="modal-footer">
              <form action=" {{ route('logout') }}" method="post" id="close-delete-form">
                @csrf
                <input type="submit" class="btn btn-secondary" value="Close">
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
        User will be permanently removed. Are you sure?
      </div>
      <div class="modal-footer">
        <form action="{{ route('account.delete') }}" method="post" id="delete-form">
          @csrf
          <button class="btn btn-warning" data-dismiss="modal">No</button>
          <button type="submit"" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>
