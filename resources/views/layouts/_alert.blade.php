@if(session('alert'))
    <div class="alert alert-{{ session('alert-type') }}">{{ session('alert') }}</div>
@endif
