<!-- Modal -->
<div class="modal fade" id="create_kpis_modal" tabindex="-1" aria-labelledby="create_kpis_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_kpis_modal">Create new KPI</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('user.kpis.create') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" placeholder="name string value" class="form-control" id="name">
                    </div>
                    <label for="type">Type:</label>
                    <select name="type" id="type">
                        @forelse($types as $type)
                            <option value="{{$type->id}}">{{$type->name}}</option>
                        @empty
                            <option name="none">-- none --</option>
                        @endforelse
                    </select>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
