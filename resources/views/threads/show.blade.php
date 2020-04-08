@extends('layouts.app')

@section('content')
    <thread-view inline-template :thread="{{ $thread }} " >
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{route('profile.show', $thread->creator->name)}}">{{ $thread->creator->name }}</a>
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                    @can('update', $thread)
                    <form action="{{ route('threads.delete',$thread->id)}}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}

                        <button type="submit" class="btn btn-link">删除</button>
                    </form>
                    @endcan

                </div>


                <replies  :thread_id="{{$thread->id}}" @removed="repliesCount--" @added="repliesCount++"></replies>


            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <p>
                            <a href="#">{{ $thread->creator->name }}</a> 发布于 {{ $thread->created_at->diffForHumans() }},
                            当前共有 <span v-text="repliesCount"></span> 个回复。
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </thread-view>
@endsection
