<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activities =  Activity::feed($user);
        $threads = $user->threads()->paginate(10);
        return view('profiles.show', compact(['user', 'threads', 'activities']));
    }
}
