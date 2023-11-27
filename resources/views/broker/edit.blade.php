<!-- Modal -->
<div class="modal fade" id="edit_value_{{$param->id}}_modal" tabindex="-1" aria-labelledby="edit_value_{{$param->id}}_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_value_{{$param->id}}_modal">Edit Values</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ Auth::user()['role'] === 'admin' ? route('admin.broker.edit') : route('broker.edit')}}">
                    @csrf
                @foreach(json_decode($param->value, true) as $value_key => $value)
                    <div class="mb-3">
                        <label for="{{$value_key}}" class="form-label">{{$value_key}}*</label>
                        <input type="text" value="{{$value}}" name="{{$value_key}}" placeholder="{{$value_key }} - number" class="form-control" id="name">
                    </div>
                @endforeach
                    <div class="mb-3">
                        <input type="hidden" name="param_id" value="{{ $param->id }}">
                    </div>
                    <div class="mb-3">
                        <a>*required field</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
