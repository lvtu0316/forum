<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/3/9
 * Time: 16:39
 */

namespace App\Common;
use App\Models\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if(auth()->guest()) return ;

        foreach (static::getActivitiesToRecord() as $event){
            static::$event(function ($model) use ($event){
                $model->recordActivity($event);
            });
        }
        static::deleting(function ($model){
            $model->activity()->delete();
        });
    }

    protected static function getActivitiesToRecord()
    {
        return ['created'];
    }


    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),

        ]);
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType($event)
    {
        return $event . '_' . strtolower((new \ReflectionClass($this))->getShortName());
    }

}