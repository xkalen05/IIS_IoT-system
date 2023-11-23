<!-- Modal -->
<div class="modal fade" id="edit_parameter_{{$param->id}}_modal" tabindex="-1" aria-labelledby="edit_parameter_{{$param->id}}_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_parameter_{{$param->id}}_modal">Edit parameter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.parameters.edit') }}">
                    @csrf
                    <input type="hidden" name="param_id" value="{{ $param->id }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" value="{{$param->name}}" name="name" placeholder="name" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label">Value</label>
                        <input type="text" value="{{$param->value}}" name="value" placeholder="value" class="form-control" id="value">
                    </div>
                    <div class="mb-3">
                        <label for="kpi" class="form-label">KPI</label>
                        <input type="text" value="{{$param->kpi}}" name="kpi" placeholder="kpi" class="form-control" id="kpi">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
