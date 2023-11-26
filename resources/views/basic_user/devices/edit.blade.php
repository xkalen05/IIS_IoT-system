<!-- Modal -->
<div class="modal fade" id="edit_device_{{$device->id}}_modal" tabindex="-1" aria-labelledby="edit_device_{{$device->id}}_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_device_{{$device->id}}_modal">Edit device</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('user.device.edit') }}">
                    @csrf
                    <input type="hidden" name="device_id" value="{{ $device->id }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{$device->name}}" name="name" placeholder="name" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="alias" class="form-label">Alias</label>
                        <input type="text" value="{{$device->alias}}" name="alias" placeholder="alias" class="form-control" id="alias">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <input type="text" value="{{$device->description}}" class="form-control" id="description" name="description">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
