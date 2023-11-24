<!-- Modal -->
<div class="modal fade" id="edit_parameter_{{$param->id}}_modal" tabindex="-1" aria-labelledby="edit_parameter_{{$param->id}}_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="edit_parameter_{{$param->id}}_modal">Edit parameter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('user.parameters.edit') }}">
                    @csrf
                    <label for="kpi_id">KPI</label>
                    <select name="kpi_id" id="kpi_id">
                        @forelse($info['parameters'] as $parameter)
                            @if($parameter->id == $param->id)
                                @foreach($info['kpis'] as $kpi)
                                    @if($kpi->tid === $parameter->tid)
                                        <option value="{{$kpi->id}}">{{$kpi->name}}</option>
                                        @break
                                    @endif
                                @endforeach
                            @endif
                        @empty
                        @endforelse
                    </select>
                    <div class="mb-3">
                        <input type="hidden" name="param_id" value="{{ $param->id }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>
