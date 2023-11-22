<!-- Modal -->
<div class="modal fade" id="edit_system_{{$system->id}}_modal" tabindex="-1" aria-labelledby="edit_system_{{$system->id}}_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_system_{{$system->id}}_modal">Edit user</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('user.system.edit') }}">
                    @csrf
                    <input type="hidden" name="system_id" value="{{ $system->id }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{$system->name}}" name="name" placeholder="name" class="form-control"
                               id="name">
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Description</label>
                        <input type="text" value="{{$system->description}}" name="description" placeholder="description"
                               class="form-control" id="description">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
