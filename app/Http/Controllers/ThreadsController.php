<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThreadRequtest;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']); // 白名单，意味着仅 store 方法需要登录
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, Request $request)
    {
        if ($channel->exists)
        {
            $threads = $channel->threads()->get();
        }
        else
        {
            $threads = Thread::with('channel')->latest()->get();
        }


        if ($username = $request->by)
        {
            $threads = Thread::Username($username)->get();
//            $user = User::where('name',$username)->firstOrfail();
//            $threads = $user->threads;
        }
        if($popular = $request->popularity){
            $threads = Thread::Popular()->get();
        }
        return view('threads.index',compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = Channel::all();
        return view('threads.create', compact('channels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequtest $request, Thread $thread)
    {

        $thread->user_id = auth()->id();
        $thread->title = $request->title;
        $thread->body = $request->body;
        $thread->channel_id = $request->channel_id;
        $thread->save();
        return redirect()->to(route('threads.show',[$thread->channel->slug,$thread->id]))
            ->with('flash','创建成功！');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelId,Thread $thread)
    {
        $replies = $thread->replies()->paginate(5);

        return view('threads.show',compact(['thread', 'replies']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
//        $thread->replies()->delete(); //利用 Eloquent 监控器 的 deleting 事件来删除相关回复

        $this->authorize('update', $thread);
        $thread->delete();
        if(request()->wantsJson()){
            return response([],204);
        }
        return redirect('/threads');
    }
}
