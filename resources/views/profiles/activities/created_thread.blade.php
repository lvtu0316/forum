<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <span class="flex">
                {{ $user->name }} 发表了话题

            </span>
        </div>
    </div>

    <div class="panel-body">
        <a href="{{ route('threads.show',[$activity->subject->channel,$activity->subject->id]) }}">
            {{ $activity->subject->title }}</a>
    </div>
</div>