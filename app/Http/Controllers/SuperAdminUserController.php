<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SuperAdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));
        $role = (string) $request->input('role', '');

        $users = User::query()
            ->withCount('bookings')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->when($role !== '', fn ($q) => $q->where('role', $role))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $view = $request->ajax()
            ? 'admin.partials.users-table'
            : 'admin.users.index';

        return view($view, compact('users'));
    }
}
