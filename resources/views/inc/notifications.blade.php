
@if ($errors->any())
<div class="alert alert-danger" id="notification">
    There were some errors with your request
    <ul>
@foreach ($errors->all() as $error)

    <li>{{ $error }}</li>
   
@endforeach
    </ul>
</div> 

@endif

@if (session('error'))
<div class="alert alert-danger" id="notification">
{{ session('error') }}
</div>
@endif
@if (session('success'))
<div class="alert alert-success" id="notification">
    {{ session('success') }}
</div>
@endif
