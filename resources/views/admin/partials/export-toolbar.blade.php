<div class="filter-actions">
    <div class="result-count">
        Showing filtered result set: <strong>{{ number_format($resultCount ?? 0) }}</strong>
    </div>
    <div class="export-buttons">
        <a href="#" class="export-btn csv" data-export-base="{{ route('admin.' . $resource . '.export', ['format' => 'csv']) }}">CSV</a>
        <a href="#" class="export-btn excel" data-export-base="{{ route('admin.' . $resource . '.export', ['format' => 'xls']) }}">Excel</a>
        <a href="#" class="export-btn pdf" data-export-base="{{ route('admin.' . $resource . '.export', ['format' => 'pdf']) }}">PDF</a>
        <a href="#" class="export-btn print" data-export-base="{{ route('admin.' . $resource . '.print') }}" data-export-action="print">Print</a>
    </div>
</div>
