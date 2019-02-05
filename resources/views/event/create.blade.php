@extends('layout.logined')

@php($user = Auth::user())

@section('title')
    title
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/events" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="text" name="title"> <br>
        <input type="text" name="description"> <br>
        <input type="date" name="from_date"> <br>
        <input type="date" name="till_date"> <br>

        <input type="submit">

    </form>

@endsection