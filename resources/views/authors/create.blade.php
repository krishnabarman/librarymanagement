@extends('layouts.app')

@section('content')
<div class=" row w-75 bg-secondary mx-auto p-5 flex-column align-items-center shadow" >
    <h1 class="text-white"> Add New Author </h1>
    @include('inc.notifications')
    <form action="/authors" method="POST">
        @csrf
    <div class=" col pt-4">
        <input type="text" name="name" placeholder="Full Name" class=" rounded px-4 py-2 w-100">
    </div>
    <div class=" col pt-4">
        <input type="text" name="dob" placeholder="Date Of Birth" class=" rounded px-4 py-2 w-100">
    </div>
    <div class="col pt-4">
        <button class="bg-primary text-white rounded py-2 px-4">Add New Author</button>
    </div>
    </form>
</div>
    
@endsection