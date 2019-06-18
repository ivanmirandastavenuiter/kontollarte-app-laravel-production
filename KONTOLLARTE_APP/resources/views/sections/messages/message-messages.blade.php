<!-- --------- MESSAGES --------- -->

<!-- Confirm sending message modal -->

<div class="modal fade" id="confirm-message" tabindex="-1" role="dialog" aria-labelledby="confirm-send-message-title" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirm-send-message-title">Confirm sending</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form action="{{ route('messages.execute') }}" method="post" id="message-form">
            @csrf
            <p class="headers">The following message will be sent:</p>   

            <p class="headers"><strong>Message content: </strong></p>
            <p class="message-content"></p>

            <p class="headers"><strong>List of receivers: </strong></p>
            <div class="receivers-content">
              <ul>
              </ul>
            </div>

            @if(!$paintsUserList->isEmpty())

                <p><strong>Would you like to attach some of your jobs to the mail?</strong></p>

                <p class="headers">List of personal jobs:</p>
                <div class="jobs-content">

                </div>

            @endif

            <div class="confirm-message-btn-container d-flex justify-content-around">
                <input type="hidden" name="message-content" id="message-content">
                <input type="hidden" name="receivers[]" id="receivers">
                <input type="hidden" name="pictures[]" id="pictures">

                <button type="submit" class="btn btn-warning confirm-btn">Confirm</button>
                <button type="button" class="btn btn-danger confirm-close" data-dismiss="modal">Undo</button>
            </div>

        </form>

      </div>
    </div>
  </div>
</div>
