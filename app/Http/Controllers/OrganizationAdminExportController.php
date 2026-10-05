<?php

namespace App\Http\Controllers;

use App\Exports\SuperAdminTableExport;
use App\Models\Booking;
use App\Models\Event;
use App\Models\OrganizationStaff;
use App\Models\OrganizationUnit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as ExcelFacade;

class OrganizationAdminExportController extends Controller
{
    private const RESOURCES = ['events', 'staff', 'units', 'bookings', 'participants'];

    public function export(Request $request, string $resource, string $format)
    {
        abort_unless(in_array($resource, self::RESOURCES, true), 404);
        abort_unless(in_array($format, ['xlsx', 'csv', 'pdf'], true), 404);
        [$title, $headings, $rows] = $this->data($request, $resource);
        $filename = 'eventora-' . $resource . '-' . now()->format('Y-m-d-His');

        if ($format === 'pdf') {
            return Pdf::loadView('admin.exports.table', compact('title', 'headings', 'rows'))
                ->setPaper('a4', 'landscape')->download($filename . '.pdf');
        }

        return ExcelFacade::download(
            new SuperAdminTableExport($headings, $rows, $title),
            $filename . ($format === 'csv' ? '.csv' : '.xlsx'),
            $format === 'csv' ? Excel::CSV : Excel::XLSX
        );
    }

    public function print(Request $request, string $resource)
    {
        abort_unless(in_array($resource, self::RESOURCES, true), 404);
        [$title, $headings, $rows] = $this->data($request, $resource);
        return view('admin.print.table', [
            'title' => $title,
            'subtitle' => $request->user()->currentOrganization()?->name ?? 'Eventora',
            'columns' => $headings,
            'rows' => $rows,
        ]);
    }

    private function data(Request $request, string $resource): array
    {
        $user = $request->user();
        $organization = $user->currentOrganization();
        abort_unless($organization, 404, 'Organization not found.');
        $permissions = $user->currentOrganizationStaff()?->permissions ?? [];
        $required = match ($resource) {
            'events' => 'view_events', 'staff' => 'manage_staff', 'units' => null,
            'bookings' => 'view_bookings', 'participants' => 'view_participants',
        };
        abort_if($resource === 'units' && $user->role !== 'organization_admin', 403);
        abort_if($required && $user->role !== 'organization_admin' && !in_array($required, $permissions, true)
            && !in_array(match ($resource) { 'events' => 'manage_events', 'bookings' => 'manage_bookings', default => '' }, $permissions, true), 403);
        $term = trim((string) $request->query('q', $request->query('search', '')));

        if ($resource === 'events') {
            $items = $organization->events()->when($term !== '', fn ($q) => $q->where(fn ($sub) => $sub->where('title', 'like', "%{$term}%")->orWhere('venue', 'like', "%{$term}%")->orWhere('city', 'like', "%{$term}%")))->latest()->get();
            return ['Organization Events', ['Event', 'Date', 'Venue', 'City', 'Price', 'Status'], $items->map(fn ($i) => [$i->title, $i->event_date, $i->venue, $i->city, $i->ticket_price, $i->status])->all()];
        }
        if ($resource === 'staff') {
            $items = $organization->organizationStaff()
                ->when($term !== '', fn ($q) => $q->where(fn ($sub) => $sub->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%")->orWhere('mobile', 'like', "%{$term}%")))
                ->when($request->filled('status'), fn ($q) => $q->where('status', $request->query('status')))
                ->when($request->filled('unit'), fn ($q) => $q->whereHas('organizationUnits', fn ($units) => $units->where('organization_units.id', $request->query('unit'))))
                ->latest()->get();
            return ['Organization Staff', ['Name', 'Email', 'Mobile', 'Role', 'Status'], $items->map(fn ($i) => [$i->name, $i->email, $i->mobile, $i->role, $i->status])->all()];
        }
        if ($resource === 'units') {
            $items = $organization->organizationUnits()->when($term !== '', fn ($q) => $q->where(fn ($sub) => $sub->where('name', 'like', "%{$term}%")->orWhere('type', 'like', "%{$term}%")))->latest()->get();
            return ['Organization Units', ['Name', 'Type', 'Status', 'Description'], $items->map(fn ($i) => [$i->name, $i->type, $i->status, $i->description])->all()];
        }

        $query = Booking::with(['user', 'event'])->whereHas('event', fn ($q) => $q->where('organization_id', $organization->id))
            ->when($term !== '', fn ($q) => $q->where(fn ($sub) => $sub->where('booking_number', 'like', "%{$term}%")
                ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"))
                ->orWhereHas('event', fn ($e) => $e->where('title', 'like', "%{$term}%"))));
        if ($resource === 'participants') {
            $query->whereIn('booking_status', ['pending', 'confirmed']);
        }
        $items = $query->latest()->get();
        return [$resource === 'participants' ? 'Organization Participants' : 'Organization Bookings',
            ['Booking', 'Participant', 'Email', 'Event', 'Quantity', 'Amount', 'Payment', 'Booking Status'],
            $items->map(fn ($i) => [$i->booking_number, $i->user?->name, $i->user?->email, $i->event?->title, $i->quantity, $i->total_amount, $i->payment_status, $i->booking_status])->all()];
    }
}
