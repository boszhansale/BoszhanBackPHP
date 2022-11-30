<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('status', 1)->get();

        return view('supervisor.user.index', compact('users'));
    }

    public function show(User $user)
    {
        $driverOrders = $user->driverOrders()->paginate(20);
        $salesrepOrders = $user->salesrepOrders()->paginate(20);

        return view('supervisor.user.show', compact('user', 'driverOrders', 'salesrepOrders'));
    }

    public function position(Request $request, User $user): View
    {
        $positions = $user->userPositions()
            ->when($request->has('date'), function ($q) {
                return $q->whereDate('created_at', \request('date'));
            }, function ($q) {
                return $q->whereDate('created_at', now());
            })
            ->selectRaw('user_positions.*, TIME(created_at) as time')
            ->get();

        return view('supervisor.user.position', compact('user', 'positions'));
    }

    public function order(Request $request, User $user, $role)
    {
        return view('supervisor.user.order', compact('user', 'role'));
    }

    public function statusChange(User $user, $status)
    {
        $user->status = $status;
        $user->save();
    }

    public function drivers()
    {
        return response()->view('supervisor.user.drivers');
    }

    public function salesreps()
    {
        return response()->view('supervisor.user.salesreps');
    }

}
