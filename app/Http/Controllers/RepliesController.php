<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReplyRequest;
use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ReplyRequest $request, Thread $thread)
    {
        $thread->addReply([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect(route('threads.show',[$thread->channel,$thread->id]))
            ->with('flash', '创建成功');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update( Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request(['body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update',$reply);
        $reply->delete();
        if (request()->expectsJson()){
            return response(['status' => 'Reply deleted']);
        }

        return back();
    }
}
