@extends('layout.logined')

@section('title')
    {{ __('event.index.title') }}
@endsection

@section('content')
    <div class="container container-points">
        <h2>{{ __('event.index.title') }}</h2>
        @can('create', App\Event::class)
            <a href="/events/create" class="add-event">+</a>
        @endcan

        @forelse ($events as $event)
            <div class="one-event">
                <button class="event-delete" event-id="{{ $event->id }}">&times;</button>
                <h2><strong>{{ $event->title }}</strong></h2>
                <div class="event-description">
                    {{ $event->description }}
                </div>
                <div class="banner-label">{{ __('event.about.author') }}: @user(["user" => $event->author])</div>
                <div class="banner-label">{{ __('event.about.from_date') }}: <span>{{ $event->from_date }}</span></div>
                <div class="banner-label">{{ __('event.about.till_date') }}: <span>{{ $event->till_date }}</span></div>

                <div>{{ __('event.about.partisipants') }}:</div>
                <ol class="event-partisipants">
                    @foreach ($event->users as $user)
                        <li>
                            @user(["user"=>$user])
                        </li>
                    @endforeach
                </ol>
            </div>
        @empty
            <div class="not-found">
                {{ __('event.index.not-found') }}
            </div>
        @endforelse
    </div>
    @push('scripts')
        <script>
            $(".event-delete").click(function() {
                let that = this;
                let id = $(that).attr("event-id");
                $.ajax({
                    "method": "DELETE",
                    "url": "/events/" + id
                }).done(function() {
                    $(that).parent().remove();
                })
            })
        </script>
    @endpush

@endsection
