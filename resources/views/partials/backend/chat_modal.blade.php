<div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="chatModalLabel">New message</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="send_message_form">
            <div class="form-group">
              <label for="recipient-name" class="col-form-label">Recipient:</label>
              {{-- <select class="form-control" id="recipient-name" name="reciepient_name">
                <option value="">Select Reciepient</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>

                @endforeach
              </select> --}}
            </div>
            <div class="form-group">
              <label for="message-text" class="col-form-label">Message:</label>
              <textarea class="form-control" id="message-text" name="message_text"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="send_message_btn">Send message</button>
        </div>
      </div>
    </div>
  </div>
