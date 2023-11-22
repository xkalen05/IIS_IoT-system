<!-- Modal -->
<div class="modal fade" id="edit_user_password_{{$user->id}}_modal" tabindex="-1" aria-labelledby="edit_user_password_{{$user->id}}_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_user_password_{{$user->id}}_modal">Change password</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('user.password.edit') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" placeholder="password" class="form-control" id="password"
                               name="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
