<!-- Modal -->
<div class="modal fade" id="show_parameter_{{$param->id}}_modal" tabindex="-1" aria-labelledby="show_parameter_{{$param->id}}_modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="show_parameter_{{$param->id}}_modal">Parameter Values</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                    @forelse($info['parameters'] as $parameter)
                        @if($parameter->id === $param->id)
                            @foreach(json_decode($param->value,true) as $value_key => $value)
                                <a>{{$value_key}} : {{$value}}</a><br>
                            @endforeach
                        @endif
                    @empty
                    @endforelse
                <div class="mb-3">
                    <input type="hidden" name="param_id" value="{{ $param->id }}">
                </div>
            </div>
        </div>
    </div>
</div>
