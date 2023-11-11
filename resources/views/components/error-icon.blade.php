@if(session()->has('error'))
    <div class="error-box">
        <a>{{session('error')}}</a>
    </div>
@endif
