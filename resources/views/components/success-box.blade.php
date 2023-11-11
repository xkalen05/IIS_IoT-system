@if(session()->has('success'))
    <div class="success-box">
        <a>{{session('success')}}</a>
    </div>
@endif
