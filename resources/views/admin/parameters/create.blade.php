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
                    <!--
                    <input type="hidden" name="device_id" value="$device_id }}">
                    -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" placeholder="name string value" class="form-control" id="name">
                    </div>
                    <div class="mb-3">
                        <label for="value" class="form-label">Value</label>
                        <input type="text" name="value" placeholder="float value ex. 50.01" class="form-control" id="value">
                    </div>
                    <div class="mb-3">
                        <label for="kpi" class="form-label">KPI</label>
                        <input type="text" name="kpi" placeholder="KPI string value" class="form-control" id="kpi">
                    </div>
                    <div class="mb-3">
                    <input type="hidden" name="device_id" value="">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

