<!-- Modal -->
<div class="modal fade" id="create_parameter_modal" tabindex="-1" aria-labelledby="create_parameter_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_parameter_modal">Create new parameter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.parameters.create') }}">
                    @csrf
                    <label for="type">Type:</label>
                    <select class="form-select" name="type" id="type">
                        @forelse($info['types'] as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @empty
                            <option name="none"></option>
                        @endforelse
                    </select>
                    <div class="mb-3">
                        @foreach($info['device'] as $device)
                            <input type="hidden" name="device_id" value="{{$device->id}}">
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

