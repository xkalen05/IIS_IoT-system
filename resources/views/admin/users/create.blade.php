<!-- Modal -->
<div class="modal fade" id="create_user_modal" tabindex="-1" aria-labelledby="create_user_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_user_modal">Create new user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.user.create') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" placeholder="name" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" name="surname" placeholder="surname" class="form-control" id="surname">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" name="email" placeholder="example@mail.com" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example" name="role">
                            <option value="admin">Admin</option>
                            <option value="basic_user" selected>Basic user</option>
                            <option value="broker">Broker</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" placeholder="password" class="form-control" id="password" name="password">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
