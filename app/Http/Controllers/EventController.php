<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display all upcoming/live approved events.
     *
     * Supported filters:
     * - search
     * - category
     * - city
     * - date
     * - date_from
     * - date_to
     */
    public function index(
        Request $request
    ): View {

        $today = now()->toDateString();

        $currentTime = now()->format('H:i:s');


        /*
        |--------------------------------------------------------------------------
        | Base Query
        |--------------------------------------------------------------------------
        |
        | Only approved events that have not started yet.
        |
        */

        $query = Event::with(
                'organization'
            )
            ->where(
                'status',
                'approved'
            )
            ->where(function ($q) use (
                $today,
                $currentTime
            ) {

                $q->whereDate(
                    'event_date',
                    '>',
                    $today
                )

                ->orWhere(function ($q) use (
                    $today,
                    $currentTime
                ) {

                    $q->whereDate(
                        'event_date',
                        $today
                    )
                    ->whereTime(
                        'event_time',
                        '>=',
                        $currentTime
                    );

                });

            });


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        |
        | Search by:
        | - Event title
        | - Category
        | - City
        | - Venue
        |
        */

        if (
            $request->filled('search')
        ) {

            $search =
                trim(
                    $request->input(
                        'search'
                    )
                );


            if (
                $search !== ''
            ) {

                $query->where(
                    function ($q) use (
                        $search
                    ) {

                        $q->where(
                            'title',
                            'like',
                            '%' .
                            $search .
                            '%'
                        )

                        ->orWhere(
                            'category',
                            'like',
                            '%' .
                            $search .
                            '%'
                        )

                        ->orWhere(
                            'city',
                            'like',
                            '%' .
                            $search .
                            '%'
                        )

                        ->orWhere(
                            'venue',
                            'like',
                            '%' .
                            $search .
                            '%'
                        );

                    }
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'category'
            )
        ) {

            $query->where(
                'category',
                $request->input(
                    'category'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | City Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'city'
            )
        ) {

            $query->where(
                'city',
                $request->input(
                    'city'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Exact Date Filter
        |--------------------------------------------------------------------------
        |
        | Example:
        | ?date=2026-10-15
        |
        */

        if (
            $request->filled(
                'date'
            )
        ) {

            $query->whereDate(
                'event_date',
                $request->input(
                    'date'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Date From Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'date_from'
            )
        ) {

            $query->whereDate(
                'event_date',
                '>=',
                $request->input(
                    'date_from'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Date To Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled(
                'date_to'
            )
        ) {

            $query->whereDate(
                'event_date',
                '<=',
                $request->input(
                    'date_to'
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Events
        |--------------------------------------------------------------------------
        */

        $events = $query
            ->orderBy(
                'event_date',
                'asc'
            )
            ->orderBy(
                'event_time',
                'asc'
            )
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Available Categories
        |--------------------------------------------------------------------------
        |
        | Show only categories having upcoming approved events.
        |
        */

        $categories = Event::where(
                'status',
                'approved'
            )
            ->where(function ($q) use (
                $today,
                $currentTime
            ) {

                $q->whereDate(
                    'event_date',
                    '>',
                    $today
                )

                ->orWhere(function ($q) use (
                    $today,
                    $currentTime
                ) {

                    $q->whereDate(
                        'event_date',
                        $today
                    )
                    ->whereTime(
                        'event_time',
                        '>=',
                        $currentTime
                    );

                });

            })
            ->whereNotNull(
                'category'
            )
            ->where(
                'category',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy(
                'category'
            )
            ->pluck(
                'category'
            );


        /*
        |--------------------------------------------------------------------------
        | Available Cities
        |--------------------------------------------------------------------------
        |
        | Show only cities having upcoming approved events.
        |
        */

        $cities = Event::where(
                'status',
                'approved'
            )
            ->where(function ($q) use (
                $today,
                $currentTime
            ) {

                $q->whereDate(
                    'event_date',
                    '>',
                    $today
                )

                ->orWhere(function ($q) use (
                    $today,
                    $currentTime
                ) {

                    $q->whereDate(
                        'event_date',
                        $today
                    )
                    ->whereTime(
                        'event_time',
                        '>=',
                        $currentTime
                    );

                });

            })
            ->whereNotNull(
                'city'
            )
            ->where(
                'city',
                '!=',
                ''
            )
            ->distinct()
            ->orderBy(
                'city'
            )
            ->pluck(
                'city'
            );


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'events.index',
            compact(
                'events',
                'categories',
                'cities'
            )
        );
    }


    /**
     * Display event details.
     */
    public function show(
        string $slug
    ): View {

        $event = Event::with([
                'organization',
            ])
            ->where(
                'slug',
                $slug
            )
            ->where(
                'status',
                'approved'
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Related Events
        |--------------------------------------------------------------------------
        |
        | Same category + same city where possible.
        | Exclude current event.
        |
        */

        $relatedEvents = Event::with([
                'organization',
            ])
            ->where(
                'status',
                'approved'
            )
            ->where(
                'id',
                '!=',
                $event->id
            )
            ->where(function ($q) {

                $today =
                    now()->toDateString();

                $currentTime =
                    now()->format(
                        'H:i:s'
                    );


                $q->whereDate(
                    'event_date',
                    '>',
                    $today
                )

                ->orWhere(function ($q) use (
                    $today,
                    $currentTime
                ) {

                    $q->whereDate(
                        'event_date',
                        $today
                    )
                    ->whereTime(
                        'event_time',
                        '>=',
                        $currentTime
                    );

                });

            })
            ->where(function ($q) use (
                $event
            ) {

                $q->where(
                    'category',
                    $event->category
                )
                ->orWhere(
                    'city',
                    $event->city
                );

            })
            ->orderBy(
                'event_date'
            )
            ->orderBy(
                'event_time'
            )
            ->take(4)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return Event Details
        |--------------------------------------------------------------------------
        */

        return view(
            'events.show',
            compact(
                'event',
                'relatedEvents'
            )
        );
    }
}