<!-- Modal -->
<div class="modal modal-lg fade" id="sharing_requests_modal" tabindex="-1" aria-labelledby="sharing_requests_modal"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sharing_requests_modal">Sharing requests</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    @if($sharingRequests->isEmpty())
                        <p>No sharing requests found.</p>
                    @else
                        <table class="table">
                            <thead>
                            <tr>
                                {{--                            <th>Request ID</th>--}}
                                <th>System Name</th>
                                <th>Request From</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sharingRequests as $request)
                                <tr>
                                    {{--                                <td>{{ $request->id }}</td>--}}
                                    <td>{{ $request->system->name }}</td>
                                    <td>{{ $request->requestUser->name }} {{ $request->requestUser->surname }} - {{ $request->requestUser->email }}</td>
                                    <td>
                                        <div class="row w-75">
                                            <div class="col">
                                                <form method="post" action="{{ route('sharing.request.accept') }}">
                                                    @csrf
                                                    <input type="hidden" name="system_id"
                                                           value="{{ $request->system->id }}">
                                                    <input type="hidden" name="user_id"
                                                           value="{{ $request->requestUser->id }}">
                                                    <input type="hidden" name="request_id" value="{{ $request->id }}">
                                                    <button type="submit" class="btn btn-primary">Accept</button>
                                                </form>
                                            </div>
                                            <div class="col">
                                                <a href="{{route('sharing.request.deny', $request->id)}}"
                                                   class="btn btn-danger">Deny</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

