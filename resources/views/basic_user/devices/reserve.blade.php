<!-- Modal -->
<div class="modal fade" id="reserve_device_{{$system->id}}_modal" tabindex="-1"
     aria-labelledby="reserve_device_{{$system->id}}_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="reserve_device_{{$system->id}}_modal">Reserve device</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('user.device.reserve') }}">
                    @csrf
                    <input type="hidden" name="system_id" value="{{ $system->id }}">
                    <div class="mb-3">
                        <label for="user-checkbox">Select devices that you want to reserve:</label>
                        <div class="checkbox-dropdown">
                            <select multiple class="form-select" id="device_id" name="device_id">
                                @foreach($devices_free as $device)
                                    @if($device->system_id==NULL)
                                        <option value="{{ $device->id }}">
                                            {{ $device->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
