@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-header">
            <h1>
                {{$user->name}}
                <small>注册于 {{$user->created_at->diffForHumans()}}</small>
            </h1>
        </div>
        @foreach($activities as $date => $activity)
            <h3 class="page-header">{{ $date }}</h3>

            @foreach($activity as $record)
                @include("profiles.activities.{$record->type}",['activity'  => $record])
            @endforeach
        @empty($threads)
            <p>暂无动作</p>
        @endempty
        @endforeach
        <div class="page-header">
            <h1>
                <small>话题</small>
            </h1>
        </div>
        @foreach($threads as $thread)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="level">
                        <span class="flex">
                            <a href="{{route('threads.show',[$thread->channel,$thread->id])}}">{{$thread->title}}</a>
                        </span>
                        <span>{{ $thread->created_at->diffForHumans() }}</span>

                    </div>
                </div>
            </div>
        @empty($threads)
             <p>暂无话题</p>
        @endempty
        @endforeach
        {{$threads->links()}}
    </div>
@endsection