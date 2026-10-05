<div style="display:flex;flex-wrap:wrap;justify-content:flex-end;gap:8px;margin:12px 0">
    @foreach(['xlsx' => 'Excel', 'csv' => 'CSV', 'pdf' => 'PDF'] as $format => $label)
        <a href="{{ route('organization.admin.export', array_merge(request()->query(), ['resource' => $exportResource, 'format' => $format])) }}" style="display:inline-flex;align-items:center;padding:8px 11px;border:1px solid #dce2ec;border-radius:9px;background:#fff;color:#334155;font-size:12px;font-weight:700;text-decoration:none">{{ $label }}</a>
    @endforeach
    <a href="{{ route('organization.admin.print', array_merge(request()->query(), ['resource' => $exportResource])) }}" style="display:inline-flex;align-items:center;padding:8px 11px;border:1px solid #dce2ec;border-radius:9px;background:#fff;color:#334155;font-size:12px;font-weight:700;text-decoration:none">Print</a>
</div>
