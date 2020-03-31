@component('profiles.activities.activity')
    @slot('heading')
        {{ $user->name }} 回复了
        <a href="{{ route('threads.show',[$activity->subject->thread->channel,$activity->subject->id]) }}">
            {{ $activity->subject->thread->title }}</a>
    @endslot



    @slot('body')

        {{ str_limit($activity->subject->body, 200, '...') }}
    @endslot
@endcomponent