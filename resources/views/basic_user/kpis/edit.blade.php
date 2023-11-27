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
                <form method="post" action="{{ route('user.kpis.edit') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $kpi->id }}">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" value="{{$kpi->name}}" placeholder="name string value" class="form-control" id="name">
                    </div>
                    @forelse(json_decode($kpi->value,true) as $rec_key => $record)
                        <h4>{{$rec_key}}:</h4>
                        @foreach($record as $key => $val)
                            <div class="mb-3">
                                <label for="{{$key}}" class="form-label">{{$key}}*</label>
                                <input type="number" value="{{$val}}" name="{{$key}}" placeholder="{{$key}} - number"
                                       class="form-control" id="description">
                            </div>
                        @endforeach
                    @empty
                    @endforelse
                    <div class="mb-3">
                        <a>*required field</a>
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
