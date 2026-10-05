<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\View\View;

class PublicPageController extends Controller
{
    public function categories(): View
    {
        $today = now()->toDateString();
        $currentTime = now()->format('H:i:s');

        $categories = Event::query()
            ->where('status', 'approved')
            ->where(function ($query) use ($today, $currentTime) {
                $query->whereDate('event_date', '>', $today)
                    ->orWhere(function ($query) use ($today, $currentTime) {
                        $query->whereDate('event_date', $today)
                            ->whereTime('event_time', '>=', $currentTime);
                    });
            })
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->selectRaw('category, COUNT(*) as events_count')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('pages.public', [
            'page' => 'categories',
            'categories' => $categories,
        ]);
    }

    public function howItWorks(): View
    {
        return view('pages.public', ['page' => 'how-it-works']);
    }

    public function about(): View
    {
        return view('pages.public', ['page' => 'about']);
    }

    public function contact(): View
    {
        return view('pages.public', ['page' => 'contact']);
    }
}
