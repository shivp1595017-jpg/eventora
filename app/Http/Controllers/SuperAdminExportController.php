<?php

namespace App\Http\Controllers;

use App\Exports\SuperAdminTableExport;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Organization;
use App\Models\User;
use App\Models\OrganizationStaff;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;

class SuperAdminExportController extends Controller
{
    private const RESOURCES = [
        'organizations',
        'events',
        'users',
        'bookings',
        'payments',
        'staff',
        'admin_staff',
    ];

    public function export(Request $request, string $resource, string $format)
    {
        $resource = $request->route('resource', $resource);
        $format = $request->route('format', $format);

        abort_unless(in_array($resource, self::RESOURCES, true), 404);
        abort_unless(in_array($format, ['xlsx', 'csv', 'pdf'], true), 404);

        [$title, $headings, $rows] = match ($resource) {
            'organizations' => $this->organizations($request),
            'events' => $this->events($request),
            'users' => $this->users($request),
            'bookings' => $this->bookings($request),
            'payments' => $this->payments($request),
            'staff' => $this->staff($request),
            'admin_staff' => $this->adminStaff($request),
        };

        $filename = 'eventora-' . $resource . '-' . now()->format('Y-m-d-His');

        if ($format === 'pdf') {
            return Pdf::loadView('admin.exports.table', [
                'title' => $title,
                'headings' => $headings,
                'rows' => $rows,
            ])
                ->setPaper('a4', 'landscape')
                ->download($filename . '.pdf');
        }

        $writer = $format === 'csv'
            ? Excel::CSV
            : Excel::XLSX;

        return ExcelFacade::download(
            new SuperAdminTableExport($headings, $rows, $title),
            $filename . ($format === 'csv' ? '.csv' : '.xlsx'),
            $writer
        );
    }

    public function print(Request $request, string $resource)
    {
        abort_unless(in_array($resource, self::RESOURCES, true), 404);
        [$title, $headings, $rows] = match ($resource) {
            'organizations' => $this->organizations($request),
            'events' => $this->events($request),
            'users' => $this->users($request),
            'bookings' => $this->bookings($request),
            'payments' => $this->payments($request),
            'staff' => $this->staff($request),
            'admin_staff' => $this->adminStaff($request),
        };

        return view('admin.print.table', [
            'title' => $title,
            'subtitle' => 'Eventora Super Admin',
            'columns' => $headings,
            'rows' => $rows,
        ]);
    }

    private function staff(Request $request): array
    {
        $search = trim((string) $request->input('search', $request->input('q', '')));
        $items = OrganizationStaff::with('organization')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhereHas('organization', fn ($org) => $org->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->filled('organization'), fn ($q) => $q->where('organization_id', $request->input('organization')))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->latest()->get();
        return ['Organization Staff Export', ['Name', 'Email', 'Mobile', 'Organization', 'Role', 'Status'],
            $items->map(fn ($item) => [$item->name, $item->email, $item->mobile, $item->organization?->name, $item->role, $item->status])->all()];
    }

    private function adminStaff(Request $request): array
    {
        $search = trim((string) $request->input('q', ''));
        $items = User::where('role', 'super_admin_staff')
            ->when($search !== '', fn ($q) => $q->where(fn ($sub) => $sub->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%")))
            ->latest()->get();
        return ['Super Admin Staff Export', ['Name', 'Email', 'Permissions', 'Created At'],
            $items->map(fn ($item) => [$item->name, $item->email, implode(', ', $item->admin_permissions ?? []), optional($item->created_at)->format('Y-m-d H:i:s')])->all()];
    }

    private function organizations(Request $request): array
    {
        $query = trim((string) $request->input('q', ''));
        $status = (string) $request->input('status', '');
        $type = (string) $request->input('type', '');

        $items = Organization::query()
            ->with('user')
            ->withCount('events')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%")
                        ->orWhere('phone', 'like', "%{$query}%")
                        ->orWhere('city', 'like', "%{$query}%")
                        ->orWhere('state', 'like', "%{$query}%");
                });
            })
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->when($type !== '', fn ($q) => $q->where('type', $type))
            ->latest()
            ->get();

        $rows = $items->map(fn (Organization $item) => [
            $item->name,
            $item->type,
            $item->email,
            $item->phone,
            $item->city,
            $item->state,
            $item->status,
            optional($item->user)->email,
            $item->events_count,
            optional($item->created_at)->format('Y-m-d H:i:s'),
        ])->all();

        return [
            'Organizations Export',
            ['Organization', 'Type', 'Email', 'Phone', 'City', 'State', 'Status', 'Admin Email', 'Events', 'Registered At'],
            $rows,
        ];
    }

    private function events(Request $request): array
    {
        $query = trim((string) $request->input('q', ''));
        $status = (string) $request->input('status', '');
        $category = (string) $request->input('category', '');
        $city = trim((string) $request->input('city', ''));
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $items = Event::query()
            ->with('organization')
            ->withCount('bookings')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('title', 'like', "%{$query}%")
                        ->orWhere('slug', 'like', "%{$query}%")
                        ->orWhere('category', 'like', "%{$query}%")
                        ->orWhere('city', 'like', "%{$query}%")
                        ->orWhere('venue', 'like', "%{$query}%")
                        ->orWhereHas('organization', fn ($org) => $org->where('name', 'like', "%{$query}%"));
                });
            })
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->when($category !== '', fn ($q) => $q->where('category', $category))
            ->when($city !== '', fn ($q) => $q->where('city', 'like', "%{$city}%"))
            ->when($dateFrom, fn ($q) => $q->whereDate('event_date', '>=', $dateFrom))
            ->when($dateTo, fn ($q) => $q->whereDate('event_date', '<=', $dateTo))
            ->latest('event_date')
            ->latest('id')
            ->get();

        $rows = $items->map(fn (Event $item) => [
            $item->title,
            optional($item->organization)->name,
            $item->category,
            $item->event_date,
            $item->event_time,
            $item->venue,
            $item->city,
            $item->ticket_price,
            $item->total_seats,
            $item->available_seats,
            $item->bookings_count,
            $item->status,
        ])->all();

        return [
            'Events Export',
            ['Event', 'Organization', 'Category', 'Date', 'Time', 'Venue', 'City', 'Ticket Price', 'Total Seats', 'Available Seats', 'Bookings', 'Status'],
            $rows,
        ];
    }

    private function users(Request $request): array
    {
        $query = trim((string) $request->input('q', ''));
        $role = (string) $request->input('role', '');

        $items = User::query()
            ->withCount('bookings')
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('name', 'like', "%{$query}%")
                        ->orWhere('email', 'like', "%{$query}%");
                });
            })
            ->when($role !== '', fn ($q) => $q->where('role', $role))
            ->latest()
            ->get();

        $rows = $items->map(fn (User $item) => [
            $item->name,
            $item->email,
            $item->role,
            $item->bookings_count,
            optional($item->email_verified_at)->format('Y-m-d H:i:s'),
            optional($item->created_at)->format('Y-m-d H:i:s'),
        ])->all();

        return [
            'Users Export',
            ['Name', 'Email', 'Role', 'Bookings', 'Email Verified At', 'Created At'],
            $rows,
        ];
    }

    private function bookings(Request $request): array
    {
        $data = $this->bookingQuery($request)->get();

        $rows = $data->map(fn (Booking $item) => [
            $item->booking_number,
            optional($item->user)->name,
            optional($item->user)->email,
            optional($item->event)->title,
            optional(optional($item->event)->organization)->name,
            $item->quantity,
            $item->ticket_price,
            $item->total_amount,
            $item->payment_id,
            $item->order_id,
            $item->payment_status,
            $item->booking_status,
            optional($item->created_at)->format('Y-m-d H:i:s'),
        ])->all();

        return [
            'Bookings Export',
            ['Booking Number', 'User', 'User Email', 'Event', 'Organization', 'Quantity', 'Ticket Price', 'Total Amount', 'Payment ID', 'Order ID', 'Payment Status', 'Booking Status', 'Created At'],
            $rows,
        ];
    }

    private function payments(Request $request): array
    {
        $request->merge(['q' => $request->input('search', $request->input('q', ''))]);
        $data = $this->bookingQuery($request, true)->get();

        $rows = $data->map(fn (Booking $item) => [
            $item->booking_number,
            optional($item->user)->name,
            optional($item->user)->email,
            optional($item->event)->title,
            $item->total_amount,
            $item->payment_id,
            $item->order_id,
            $item->payment_status,
            optional($item->created_at)->format('Y-m-d H:i:s'),
        ])->all();

        return [
            'Payments Export',
            ['Booking Number', 'User', 'User Email', 'Event', 'Amount', 'Payment ID', 'Order ID', 'Payment Status', 'Created At'],
            $rows,
        ];
    }

    private function bookingQuery(Request $request, bool $filterByPaymentDate = false)
    {
        $query = trim((string) $request->input('search', $request->input('q', '')));
        $paymentStatus = (string) $request->input('payment_status', '');
        $bookingStatus = (string) $request->input('booking_status', '');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        return Booking::query()
            ->with(['user', 'event.organization'])
            ->when($query !== '', function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('booking_number', 'like', "%{$query}%")
                        ->orWhere('payment_id', 'like', "%{$query}%")
                        ->orWhere('order_id', 'like', "%{$query}%")
                        ->orWhereHas('user', function ($user) use ($query) {
                            $user->where('name', 'like', "%{$query}%")
                                ->orWhere('email', 'like', "%{$query}%");
                        })
                        ->orWhereHas('event', function ($event) use ($query) {
                            $event->where('title', 'like', "%{$query}%")
                                ->orWhereHas('organization', fn ($org) => $org->where('name', 'like', "%{$query}%"));
                        });
                });
            })
            ->when($paymentStatus !== '', fn ($q) => $q->where('payment_status', $paymentStatus))
            ->when($bookingStatus !== '', fn ($q) => $q->where('booking_status', $bookingStatus))
            ->when($dateFrom, fn ($q) => $filterByPaymentDate
                ? $q->whereDate('created_at', '>=', $dateFrom)
                : $q->whereHas('event', fn ($event) => $event->whereDate('event_date', '>=', $dateFrom)))
            ->when($dateTo, fn ($q) => $filterByPaymentDate
                ? $q->whereDate('created_at', '<=', $dateTo)
                : $q->whereHas('event', fn ($event) => $event->whereDate('event_date', '<=', $dateTo)))
            ->latest();
    }
}
