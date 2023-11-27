<!-- Modal -->
<div class="modal fade" id="edit_user-password_{{$user->id}}_modal" tabindex="-1"
     aria-labelledby="edit_user-password_{{$user->id}}_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_user-password_{{$user->id}}_modal">Change password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('password.edit') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password: *</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password: *</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <a>*required field</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>


