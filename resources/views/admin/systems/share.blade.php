<!-- Modal -->
<div class="modal fade" id="share_system_{{$system->id}}_modal" tabindex="-1"
     aria-labelledby="share_system_{{$system->id}}_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="share_system_{{$system->id}}_modal">Share system</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.system.share') }}">
                    @csrf
                    <input type="hidden" name="system_id" value="{{ $system->id }}">
                    <div class="mb-3">
                        <label for="user-checkbox">Select users to share system with:</label>
                        <div class="checkbox-dropdown">
                            <select multiple class="form-select" id="user_id" name="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
