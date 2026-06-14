<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\MembershipUser;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index()
    {
        $memberships = Membership::orderBy('price', 'asc')->get();
        return view('admin.memberships.index', compact('memberships'));
    }

    public function subscribers()
    {
        $subscribers = MembershipUser::with(['user', 'membership'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.memberships.subscribers', compact('subscribers'));
    }

    public function edit(Membership $membership)
    {
        return view('admin.memberships.edit', compact('membership'));
    }

    public function update(Request $request, Membership $membership)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'benefits' => 'required|array|min:1',
            'benefits.*' => 'required|string',
            'duration_in_days' => 'required|integer|min:1',
        ]);

        $membership->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'discount_percentage' => $request->input('discount_percentage'),
            'benefits' => $request->input('benefits'),
            'duration_in_days' => $request->input('duration_in_days'),
        ]);

        return redirect()->route('admin.memberships.index')->with('success', 'Membership plan updated successfully.');
    }
}
