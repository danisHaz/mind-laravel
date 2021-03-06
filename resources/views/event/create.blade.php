@extends('layout.logined')

@section('title')
    {{ __('event.create.title') }}
@endsection

@section('content')
    <div class="container container-points">
        <h2>Создать мероприятие</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/events" method="POST" enctype="multipart/form-data" class="form-50">
            @csrf
            <label for="title">{{ __('event.about.name') }}:</label>
            <input type="text" name="title" class="form-control" placeholder="{{ __('event.placeholder.name') }}">
            <label for="description">{{ __('event.about.description') }}:</label>
            <input type="text" name="description" class="form-control" placeholder="{{ __('event.placeholder.description') }}">
            <label for="from_date">{{ __('event.about.from_date') }}:</label>
            <label for="is_one_day">
                <input type="checkbox" id="is_one_day" class="l-10 r-5">{{ __('event.about.one_day') }}
            </label>
            <input type="date" name="from_date" class="form-control">
            <label for="till_date" id="for_is">{{ __('event.about.till_date') }}:</label>
            <input type="date" id="till_date" name="till_date" class="form-control">

            <div class="users-block">
                <label for="title">{{ __('event.about.partisipants') }}:</label>
                <div class="add-user">+</div>
                <div class="variant">
                    <input type="text" name="users[]" class="variants" placeholder="{{ __('event.placeholder.partisipant') }}">
                    <div class="removalArea"><div class="removeX"></div></div>
                </div>
            </div>


            <input type="submit" class="submit" value="{{ __('main.submit.send') }}">

        </form>
    </div>
    @push('scripts')
        <script>
            $(".add-user").click(function() {
                $(".users-block").append(
                    `<div class="variant">
                        <input type="text" name="users[]" class="variants" placeholder="Введите участника мероприятия">
                        <div class="removalArea"><div class="removeX"></div></div>
                    </div>`
                );
                $(".removalArea").click(function() {
                    $(this).parent().remove();
                });
            });
            $(".removalArea").click(function() {
                $(this).parent().remove();
            });
        </script>
        <script>
            $("#is_one_day").click(function() {
                if($(this).is(":checked")) {
                    $("#till_date").hide(100);
                    $("#for_is").hide(100);
                    $('[name="till_date"]').val() = $('[name="from_date"]').val();
                }
                else {
                    $("#till_date").show(100);
                    $("#for_is").show(100);
                }
            }).click();
        </script>
    @endpush

@endsection
