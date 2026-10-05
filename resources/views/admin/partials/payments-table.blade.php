<div class="table-card">
@if($payments->count())
<div class="table-wrap"><table>
<thead><tr><th>Booking</th><th>User</th><th>Event</th><th>Amount</th><th>Payment ID</th><th>Order ID</th><th>Status</th><th>Date</th></tr></thead>
<tbody>
@foreach($payments as $booking)
<tr>
<td>{{ $booking->booking_number }}</td>
<td><div class="name">{{ optional($booking->user)->name ?? 'N/A' }}</div><div class="sub">{{ optional($booking->user)->email ?? '' }}</div></td>
<td>{{ optional($booking->event)->title ?? 'N/A' }}</td>
<td>₹{{ number_format($booking->total_amount,2) }}</td>
<td>{{ $booking->payment_id ?? '—' }}</td>
<td>{{ $booking->order_id ?? '—' }}</td>
<td><span class="badge {{ in_array($booking->payment_status,['paid','pending','failed']) ? $booking->payment_status : ($booking->payment_status === 'refunded' ? 'approved' : 'other') }}">{{ $booking->payment_status }}</span></td>
<td>{{ $booking->created_at->format('d M Y h:i A') }}</td>
</tr>
@endforeach
</tbody></table></div>
<div class="pagination-wrap">{{ $payments->links() }}</div>
@else
<div class="empty"><strong>No payments found.</strong>Try changing the search or filter.</div>
@endif
</div>
