<!-- Modal -->
<div class="modal fade" id="create_system_modal" tabindex="-1" aria-labelledby="create_system_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_system_modal">Create new user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.system.create') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{old('name')}}" name="name" placeholder="name" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Description</label>
                        <input type="text" value="{{old('description')}}" name="description" placeholder="Description" class="form-control" id="description">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
