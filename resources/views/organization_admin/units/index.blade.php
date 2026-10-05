@include('organization_admin.sidebar')

<style>
    .units-page {
        margin-left: 260px;
        min-height: 100vh;
        padding: 30px;
        background: #f6f7fb;
        font-family: Arial, Helvetica, sans-serif;
    }

    .mobile-header {
        display: none;
    }

    .units-container {
        max-width: 1200px;
        margin: auto;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .page-title h1 {
        margin: 0;
        font-size: 30px;
        font-weight: 800;
        color: #1f2937;
    }

    .page-title p {
        margin: 7px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 12px;
        background: #6d5dfc;
        color: white;
        text-decoration: none;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: .2s;
    }

    .add-btn:hover {
        transform: translateY(-2px);
        color: white;
    }

    .alert {
        padding: 14px 16px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    .alert-success {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .search-card {
        background: #fff;
        padding: 18px;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
        margin-bottom: 20px;
    }

    .search-form {
        display: flex;
        gap: 12px;
    }

    .search-input {
        flex: 1;
        height: 46px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 0 15px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    .search-input:focus {
        border-color: #6d5dfc;
        box-shadow: 0 0 0 3px rgba(109, 93, 252, .10);
    }

    .search-btn {
        height: 46px;
        border: none;
        border-radius: 12px;
        padding: 0 20px;
        background: #111827;
        color: white;
        font-weight: 700;
        cursor: pointer;
    }

    .units-card {
        background: white;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, .06);
        overflow: hidden;
    }

    .table-wrap {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        text-align: left;
        padding: 16px;
        background: #f9fafb;
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .05em;
        white-space: nowrap;
    }

    td {
        padding: 17px 16px;
        border-top: 1px solid #f0f2f5;
        color: #374151;
        font-size: 14px;
        vertical-align: middle;
    }

    .unit-name {
        font-weight: 800;
        color: #111827;
    }

    .unit-description {
        color: #6b7280;
        margin-top: 4px;
        font-size: 12px;
    }

    .status {
        display: inline-flex;
        align-items: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-active {
        background: #dcfce7;
        color: #166534;
    }

    .status-inactive {
        background: #fee2e2;
        color: #991b1b;
    }

    .actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 11px;
        border-radius: 9px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
    }

    .view-btn {
        background: #eef2ff;
        color: #4338ca;
    }

    .edit-btn {
        background: #fff7ed;
        color: #c2410c;
    }

    .delete-btn {
        background: #fee2e2;
        color: #b91c1c;
    }

    .empty-state {
        padding: 55px 25px;
        text-align: center;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: #111827;
    }

    .empty-state p {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .pagination-wrap {
        padding: 18px;
        border-top: 1px solid #f0f2f5;
    }

    @media (max-width: 768px) {
        .units-page {
            margin-left: 0;
            padding: 20px 14px;
        }

        .mobile-header {
            display: flex;
            align-items: center;
            gap: 13px;
            height: 58px;
            background: white;
            padding: 0 15px;
            margin: -20px -14px 22px;
            box-shadow: 0 3px 15px rgba(0,0,0,.05);
        }

        .mobile-header button {
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 10px;
            background: #6366f1;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .mobile-header strong {
            font-size: 18px;
            color: #111827;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .add-btn {
            width: 100%;
        }

        .search-form {
            flex-direction: column;
        }

        .search-btn {
            width: 100%;
        }
    }
</style>

<main class="units-page">

    <div class="mobile-header">
        <button
            type="button"
            onclick="openAdminSidebar()"
            aria-label="Open Menu"
        >
            ☰
        </button>

        <strong>Eventora</strong>
    </div>

    <div class="units-container">

        <div class="page-header">

            <div class="page-title">
                <h1>Organization Units</h1>

                <p>
                    Manage departments, teams, sections and other organization units
                    for {{ $organization->name }}.
                </p>
            </div>

            <a
                href="{{ route('organization.admin.units.create') }}"
                class="add-btn"
            >
                ➕ Add Unit
            </a>

        </div>


        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <div class="search-card">

            <form
                method="GET"
                action="{{ route('organization.admin.units.index') }}"
                class="search-form"
                id="unitSearchForm"
            >

                <input
                    type="text"
                    name="search"
                    id="unitSearchInput"
                    value="{{ request('search') }}"
                    class="search-input"
                    placeholder="Search unit name, type or description..."
                    autocomplete="off"
                >

                <button
                    type="submit"
                    class="search-btn"
                >
                    🔍 Search
                </button>

            </form>

        </div>

        @include('organization_admin.partials.export-toolbar', ['exportResource' => 'units'])


        <div class="units-card">

            <div class="table-wrap">

                @if($units->count() > 0)

                    <table>

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Unit</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($units as $unit)

                                <tr>

                                    <td>
                                        {{ $units->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        <div class="unit-name">
                                            {{ $unit->name }}
                                        </div>

                                        @if($unit->description)

                                            <div class="unit-description">
                                                {{ \Illuminate\Support\Str::limit($unit->description, 70) }}
                                            </div>

                                        @endif

                                    </td>

                                    <td>
                                        {{ $unit->type ?: '—' }}
                                    </td>

                                    <td>

                                        <span class="status
                                            {{ $unit->status === 'active'
                                                ? 'status-active'
                                                : 'status-inactive' }}"
                                        >
                                            {{ ucfirst($unit->status) }}
                                        </span>

                                    </td>

                                    <td>

                                        <div class="actions">

                                            <a
                                                href="{{ route('organization.admin.units.show', $unit->id) }}"
                                                class="action-btn view-btn"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('organization.admin.units.edit', $unit->id) }}"
                                                class="action-btn edit-btn"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('organization.admin.units.destroy', $unit->id) }}"
                                                onsubmit="return confirm('Are you sure you want to delete this organization unit?');"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="action-btn delete-btn"
                                                >
                                                    Delete
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            🏢
                        </div>

                        <h3>
                            No Organization Units Found
                        </h3>

                        <p>
                            Create your first department, team, section or group.
                        </p>

                        <a
                            href="{{ route('organization.admin.units.create') }}"
                            class="add-btn"
                        >
                            ➕ Add Unit
                        </a>

                    </div>

                @endif

            </div>


            @if($units->hasPages())

                <div class="pagination-wrap">
                    {{ $units->links() }}
                </div>

            @endif

        </div>

    </div>

</main>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('unitSearchInput');
    const form = document.getElementById('unitSearchForm');
    const tableWrap = document.querySelector('.table-wrap');

    if (!input || !form || !tableWrap) {
        return;
    }

    let timer = null;

    function searchUnits() {

        const query = input.value.trim();

        fetch(
            "{{ route('organization.admin.units.search') }}?q=" +
            encodeURIComponent(query),
            {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        )
        .then(response => {

            if (!response.ok) {
                throw new Error('Search request failed.');
            }

            return response.json();
        })
        .then(units => {

            if (!units.length) {

                tableWrap.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">🔍</div>

                        <h3>No Organization Units Found</h3>

                        <p>No unit matches your search.</p>

                        <a
                            href="{{ route('organization.admin.units.create') }}"
                            class="add-btn"
                        >
                            ➕ Add Unit
                        </a>
                    </div>
                `;

                return;
            }

            let rows = '';

            units.forEach((unit, index) => {

                const description = unit.description
                    ? unit.description.substring(0, 70)
                    : '';

                const statusClass =
                    unit.status === 'active'
                        ? 'status-active'
                        : 'status-inactive';

                rows += `
                    <tr>

                        <td>${index + 1}</td>

                        <td>

                            <div class="unit-name">
                                ${escapeHtml(unit.name)}
                            </div>

                            ${
                                description
                                    ? `
                                        <div class="unit-description">
                                            ${escapeHtml(description)}
                                        </div>
                                    `
                                    : ''
                            }

                        </td>

                        <td>
                            ${
                                unit.type
                                    ? escapeHtml(unit.type)
                                    : '—'
                            }
                        </td>

                        <td>

                            <span class="status ${statusClass}">
                                ${capitalize(unit.status)}
                            </span>

                        </td>

                        <td>

                            <div class="actions">

                                <a
                                    href="/organization-admin/units/${unit.id}"
                                    class="action-btn view-btn"
                                >
                                    View
                                </a>

                                <a
                                    href="/organization-admin/units/${unit.id}/edit"
                                    class="action-btn edit-btn"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="/organization-admin/units/${unit.id}"
                                    onsubmit="return confirm('Are you sure you want to delete this organization unit?');"
                                >

                                    <input
                                        type="hidden"
                                        name="_token"
                                        value="{{ csrf_token() }}"
                                    >

                                    <input
                                        type="hidden"
                                        name="_method"
                                        value="DELETE"
                                    >

                                    <button
                                        type="submit"
                                        class="action-btn delete-btn"
                                    >
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>
                `;
            });

            tableWrap.innerHTML = `
                <table>

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Unit</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        ${rows}
                    </tbody>

                </table>
            `;
        })
        .catch(error => {
            console.error('Live search error:', error);
        });
    }

    input.addEventListener('input', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            searchUnits();
        }, 300);

    });

    form.addEventListener('submit', function (event) {

        event.preventDefault();

        clearTimeout(timer);

        searchUnits();

    });

    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;
    }

    function capitalize(value) {

        if (!value) {
            return '';
        }

        return value.charAt(0).toUpperCase() + value.slice(1);
    }

});
</script>

