<?php

namespace App\Http\Controllers;

use App\Http\Controllers\SuperAdminBookingController;
use App\Models\Booking;
use App\Models\Organization;
use App\Services\SuperAdminTableExportService;
use Illuminate\Http\Request;

class SuperAdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = $this->query($request)
            ->with(['user', 'event.organization'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $organizations = Organization::orderBy('name')->get(['id', 'name']);
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];

        return view('admin.payments.index', compact(
            'payments',
            'organizations',
            'paymentStatuses'
        ) + ['resultCount' => $payments->total()]);
    }

    public function export(Request $request, string $format, SuperAdminTableExportService $exporter)
    {
        $format = strtolower($format);
        abort_unless(in_array($format, ['csv', 'xls', 'pdf'], true), 404);

        $payments = $this->query($request)
            ->with(['user', 'event.organization'])
            ->latest()
            ->get();

        $columns = [
            ['key' => 'id', 'label' => 'ID', 'width' => 30],
            ['key' => 'booking_number', 'label' => 'Booking Number', 'width' => 90],
            ['key' => 'user', 'label' => 'User', 'width' => 90],
            ['key' => 'event', 'label' => 'Event', 'width' => 110],
            ['key' => 'organization', 'label' => 'Organization', 'width' => 90],
            ['key' => 'amount', 'label' => 'Amount', 'width' => 60],
            ['key' => 'payment_id', 'label' => 'Payment ID', 'width' => 100],
            ['key' => 'order_id', 'label' => 'Order ID', 'width' => 100],
            ['key' => 'status', 'label' => 'Payment Status', 'width' => 70],
            ['key' => 'created_at', 'label' => 'Date', 'width' => 85],
        ];

        $rows = $payments->map(fn (Booking $booking) => $this->row($booking))->all();

        return $this->exportRows($format, $exporter, 'payments', 'Eventora Payments Report', $columns, $rows);
    }

    public function print(Request $request)
    {
        $payments = $this->query($request)
            ->with(['user', 'event.organization'])
            ->latest()
            ->get();

        return view('admin.print.table', [
            'title' => 'Eventora Payments',
            'subtitle' => 'Filtered Super Admin payment report',
            'columns' => ['ID', 'Booking Number', 'User', 'Event', 'Organization', 'Amount', 'Payment ID', 'Order ID', 'Payment Status', 'Date'],
            'rows' => $payments->map(fn (Booking $booking) => array_values($this->row($booking)))->all(),
        ]);
    }

    private function query(Request $request)
    {
        return Booking::query()
            ->whereNotNull('payment_status')
            ->when($request->filled('search') || $request->filled('q'), function ($query) use ($request) {
                $search = trim((string) $request->input('search', $request->input('q', '')));
                $query->where(function ($q) use ($search) {
                    $q->where('booking_number', 'like', "%{$search}%")
                        ->orWhere('payment_id', 'like', "%{$search}%")
                        ->orWhere('order_id', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($user) use ($search) {
                            $user->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('event', function ($event) use ($search) {
                            $event->where('title', 'like', "%{$search}%")
                                ->orWhereHas('organization', fn ($org) => $org->where('name', 'like', "%{$search}%"));
                        });
                });
            })
            ->when($request->filled('payment_status'), fn ($q) => $q->where('payment_status', $request->string('payment_status')->toString()))
            ->when($request->filled('organization_id'), fn ($q) => $q->whereHas('event', fn ($event) => $event->where('organization_id', $request->integer('organization_id'))))
            ->when($request->filled('date_from'), fn ($q) => $q->whereDate('created_at', '>=', $request->string('date_from')->toString()))
            ->when($request->filled('date_to'), fn ($q) => $q->whereDate('created_at', '<=', $request->string('date_to')->toString()));
    }

    private function row(Booking $booking): array
    {
        return [
            'id' => $booking->id,
            'booking_number' => $booking->booking_number,
            'user' => optional($booking->user)->name ?? 'N/A',
            'event' => optional($booking->event)->title ?? 'N/A',
            'organization' => optional(optional($booking->event)->organization)->name ?? 'N/A',
            'amount' => 'Rs ' . number_format((float) $booking->total_amount, 2),
            'payment_id' => $booking->payment_id ?: 'N/A',
            'order_id' => $booking->order_id ?: 'N/A',
            'status' => ucfirst($booking->payment_status),
            'created_at' => optional($booking->created_at)->format('d M Y h:i A'),
        ];
    }

    private function exportRows(string $format, SuperAdminTableExportService $exporter, string $prefix, string $title, array $columns, array $rows)
    {
        $stamp = now()->format('Ymd_His');

        if ($format === 'csv') {
            return $exporter->csv($prefix . '_' . $stamp . '.csv', $columns, $rows);
        }

        if ($format === 'xls') {
            return $exporter->excel($prefix . '_' . $stamp . '.xls', $columns, $rows);
        }

        return $exporter->pdf($prefix . '_' . $stamp . '.pdf', $title, $columns, $rows);
    }
}
