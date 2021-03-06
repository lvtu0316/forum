<?php

namespace App\Models;

use App\Common\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use RecordsActivity;
    protected $guarded = [];

    public function favorited()
    {
        return $this->morphTo();
    }
}
