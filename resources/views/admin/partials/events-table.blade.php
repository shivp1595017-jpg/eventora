<div class="table-card">
@if($events->count())
<div class="table-wrap"><table>
<thead><tr><th>Event</th><th>Organization</th><th>Date / Time</th><th>Location</th><th>Price</th><th>Bookings</th><th>Seats</th><th>Status</th><th>Actions</th></tr></thead>
<tbody>
@foreach($events as $event)
<tr>
<td><div class="name">{{ $event->title }}</div><div class="sub">{{ $event->category ?? 'Uncategorized' }}</div></td>
<td>{{ optional($event->organization)->name ?? 'N/A' }}</td>
<td><div>{{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}</div><div class="sub">{{ $event->event_time ? \Carbon\Carbon::parse($event->event_time)->format('h:i A') : 'Time not set' }}</div></td>
<td><div>{{ $event->venue ?? 'N/A' }}</div><div class="sub">{{ $event->city ?? '' }}</div></td>
<td>{{ $event->ticket_price > 0 ? '₹'.number_format($event->ticket_price,2) : 'FREE' }}</td>
<td>{{ $event->bookings_count }}</td>
<td>{{ $event->available_seats === null ? 'Unlimited' : $event->available_seats }}</td>
<td><span class="badge {{ in_array($event->status,['approved','pending','rejected','cancelled']) ? $event->status : 'other' }}">{{ $event->status }}</span></td>
<td><div class="actions"><a class="action view" href="{{ route('admin.events.show', $event) }}">View</a><a class="action view" href="{{ route('admin.events.edit', $event) }}">Edit</a>@if($event->bookings_count === 0)<form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Delete this event?');">@csrf @method('DELETE')<button class="action danger" type="submit">Delete</button></form>@endif</div></td>
</tr>
@endforeach
</tbody></table></div>
<div class="pagination-wrap">{{ $events->links() }}</div>
@else
<div class="empty"><strong>No events found.</strong>Try changing the search or filters.</div>
@endif
</div>
