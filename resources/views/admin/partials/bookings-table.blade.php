<div class="table-card">
@if($bookings->count())
<div class="table-wrap"><table>
<thead><tr><th>Booking</th><th>User</th><th>Event</th><th>Amount</th><th>Payment</th><th>Booking Status</th><th>Created</th></tr></thead>
<tbody>
@foreach($bookings as $booking)
<tr>
<td><div class="name">{{ $booking->booking_number }}</div><div class="sub">1 ticket</div></td>
<td><div class="booking-user-cell"><div class="booking-user-avatar"><span>{{ strtoupper(substr(optional($booking->user)->name ?? 'N', 0, 1)) }}</span>@if($booking->user?->profilePhotoUrl())<img src="{{ $booking->user->profilePhotoUrl() }}" alt="" aria-hidden="true" referrerpolicy="no-referrer" onerror="this.remove()">@endif</div><div><div class="name">{{ optional($booking->user)->name ?? 'N/A' }}</div><div class="sub">{{ optional($booking->user)->email ?? '' }}</div></div></div></td>
<td><div class="name">{{ optional($booking->event)->title ?? 'N/A' }}</div><div class="sub">{{ optional(optional($booking->event)->organization)->name ?? '' }}</div></td>
<td>₹{{ number_format($booking->total_amount,2) }}</td>
<td><div><span class="badge {{ in_array($booking->payment_status,['paid','pending','failed','refunded']) ? ($booking->payment_status === 'refunded' ? 'approved' : $booking->payment_status) : 'other' }}">{{ $booking->payment_status }}</span></div><div class="sub">{{ $booking->payment_id ?? 'No payment ID' }}</div></td>
<td><span class="badge {{ in_array($booking->booking_status,['confirmed','pending','cancelled']) ? $booking->booking_status : 'other' }}">{{ $booking->booking_status }}</span></td>
<td>{{ $booking->created_at->format('d M Y h:i A') }}</td>
</tr>
@endforeach
</tbody></table></div>
<div class="pagination-wrap">{{ $bookings->links() }}</div>
@else
<div class="empty"><strong>No bookings found.</strong>Try changing the search or filters.</div>
@endif
</div>
<style>
    .booking-user-cell{display:flex;align-items:center;gap:10px;min-width:190px}
    .booking-user-avatar{position:relative;display:grid;width:40px;height:40px;flex:0 0 40px;place-items:center;overflow:hidden;border-radius:50%;background:linear-gradient(135deg,#6c63ff,#8b5cf6);color:#fff;font-size:15px;font-weight:800}
    .booking-user-avatar img{position:absolute;inset:0;width:100%;height:100%;border-radius:inherit;object-fit:cover}
</style>
