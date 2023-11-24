<!-- Modal -->
<div class="modal fade" id="edit_kpis_{{$kpi->id}}_modal" tabindex="-1" aria-labelledby="edit_kpis_{{$kpi->id}}_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_kpis_{{$kpi->id}}_modal">Edit KPI</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.kpis.edit') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $kpi->id }}">
                    @forelse(json_decode($kpi->value,true) as $rec_key => $record)
                        <label>{{$rec_key}}:</label>
                        @foreach($record as $key => $val)
                            <div class="mb-3">
                                <label for="{{$key}}" class="form-label">{{$key}}</label>
                                <input type="text" value="{{$val}}" name="{{$key}}" placeholder="{{$key}}"
                                       class="form-control" id="description">
                            </div>
                        @endforeach
                    @empty
                        <div class="mb-3">
                            <label for="surname" class="form-label">Description</label>
                            <input type="text" value="None" name="description" placeholder="description"
                                   class="form-control" id="description">
                        </div>
                    @endforelse

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
