@extends('layout.logined')

@section('title')
    Профиль
@endsection

@section('content')

    <form action="/email/send" method="POST">
        @csrf

        <textarea name="text"></textarea> <br>
        Кому: @access(["attr"=>"name=\"access\""]) <br>

        <input type="submit">
    </form>

@endsection
