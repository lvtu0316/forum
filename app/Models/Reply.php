<?php

namespace App\Models;

use App\Common\Favoritable;
use App\Common\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use RecordsActivity,Favoritable;
    protected $guarded = [];

    protected $fillable = ['body', 'user_id', 'thread_id'];
    protected $with = ['owner', 'favorites'];
    protected $appends = ['favoritesCount', 'isFavorited'];

    public function thread()
    {
        return $this->belongsTo(Thread::class, 'thread_id');
    }


    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited' );
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];
        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];

        $this->favorites()->where($attributes)->get()->each->delete();
    }

    public function isFavorited()
    {
//        return $this->favorites()->where('user_id', auth()->id())->exists();
        return !! $this->favorites->where('user_id',auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function path()
    {
        return route('threads.show',[$this->thread->channel,
            $this->thread->id]). "#reply-{$this->id}";
    }


}
