@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">话题列表</div>

                    <div class="panel-body">
                        @forelse($threads as $thread)
                            <article>
                                <div class="level">
                                    <h4 class="flex">
                                        <a href="{{route('threads.show',[$thread->channel->slug,$thread->id])}}">
                                            {{ $thread->title }}
                                        </a>
                                    </h4>
                                    <a href="{{route('threads.show',[$thread->channel->slug,$thread->id])}}">
                                        {{ $thread->replies_count}}个回复
                                    </a>
                                </div>



                                <div class="body">{{ $thread->body }}</div>
                            </article>

                            <hr>
                        @empty
                            <p>暂无话题</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection