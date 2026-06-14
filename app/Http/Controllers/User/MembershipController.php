<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MembershipController extends Controller
{
    public function purchase(Request $request, Membership $membership)
    {
        $user = Auth::user();

        // 1. Cancel/deactivate any existing active memberships
        MembershipUser::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // 2. Create the new active membership subscription
        MembershipUser::create([
            'user_id' => $user->id,
            'membership_id' => $membership->id,
            'start_date' => Carbon::today()->toDateString(),
            'end_date' => Carbon::today()->addDays($membership->duration_in_days)->toDateString(),
            'status' => 'active',
        ]);

        return redirect()->route('user.dashboard')
            ->with('success', "Welcome to the elite tier! Successfully upgraded to {$membership->name}.");
    }
}
