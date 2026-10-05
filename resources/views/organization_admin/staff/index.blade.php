@include('organization_admin.sidebar')

<style>
    .staff-page {
        margin-left: 260px;
        min-height: 100vh;
        padding: 30px;
        background: #f6f7fb;
        font-family: Arial, Helvetica, sans-serif;
    }

    .mobile-header {
        display: none;
    }

    .staff-container {
        max-width: 1250px;
        margin: 0 auto;
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
        color: #111827;
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
        font-size: 14px;
        font-weight: 700;

        box-shadow: 0 8px 20px rgba(109,93,252,.20);

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
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .filter-card {
        background: white;
        border-radius: 18px;
        padding: 18px;

        box-shadow: 0 8px 30px rgba(15,23,42,.06);

        margin-bottom: 20px;
    }

    .filter-form {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr auto;
        gap: 12px;
        align-items: center;
    }

    .form-control {
        width: 100%;
        height: 46px;

        box-sizing: border-box;

        border: 1px solid #e5e7eb;
        border-radius: 12px;

        padding: 0 14px;

        background: white;
        color: #1f2937;

        font-size: 14px;
        outline: none;
    }

    .form-control:focus {
        border-color: #6d5dfc;
        box-shadow: 0 0 0 3px rgba(109,93,252,.10);
    }

    .filter-btn {
        height: 46px;

        padding: 0 20px;

        border: none;
        border-radius: 12px;

        background: #111827;
        color: white;

        font-weight: 700;

        cursor: pointer;
    }

    .clear-btn {
        height: 46px;

        padding: 0 17px;

        border-radius: 12px;

        background: #f3f4f6;
        color: #374151;

        text-decoration: none;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        font-size: 13px;
        font-weight: 700;
    }

    .staff-card {
        background: white;
        border-radius: 18px;

        box-shadow: 0 8px 30px rgba(15,23,42,.06);

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
        padding: 16px;

        text-align: left;

        background: #f9fafb;

        color: #6b7280;

        font-size: 12px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .05em;

        white-space: nowrap;
    }

    td {
        padding: 16px;

        border-top: 1px solid #f0f2f5;

        color: #374151;

        font-size: 14px;

        vertical-align: middle;
    }

    .staff-name {
        font-weight: 800;
        color: #111827;
    }

    .staff-email {
        margin-top: 4px;
        color: #6b7280;
        font-size: 12px;
    }

    .unit-name {
        font-weight: 700;
        color: #374151;
    }

    .unit-type {
        margin-top: 3px;
        color: #9ca3af;
        font-size: 11px;
    }

    .role-badge {
        display: inline-flex;

        padding: 6px 10px;

        border-radius: 999px;

        background: #eef2ff;
        color: #4338ca;

        font-size: 12px;
        font-weight: 700;
    }

    .status-badge {
        display: inline-flex;

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
        flex-wrap: wrap;
        gap: 7px;
    }

    .action-btn {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 8px 11px;

        border-radius: 9px;

        border: none;

        text-decoration: none;

        font-size: 12px;
        font-weight: 700;

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
        text-align: center;
        padding: 60px 25px;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 12px;
    }

    .empty-state h3 {
        margin: 0 0 8px;
        color: #111827;
        font-size: 20px;
    }

    .empty-state p {
        margin: 0 0 20px;
        color: #6b7280;
        font-size: 14px;
    }

    .pagination-wrap {
        padding: 18px;

        border-top: 1px solid #f0f2f5;
    }

    @media (max-width: 1000px) {

        .filter-form {
            grid-template-columns: 1fr 1fr;
        }

        .filter-search {
            grid-column: 1 / -1;
        }

    }

    @media (max-width: 768px) {

        .staff-page {
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
            color: #111827;
            font-size: 18px;
        }

        .page-header {
            flex-direction: column;
            align-items: stretch;
        }

        .add-btn {
            width: 100%;
        }

        .filter-form {
            grid-template-columns: 1fr;
        }

        .filter-search {
            grid-column: auto;
        }

        .filter-btn,
        .clear-btn {
            width: 100%;
        }

    }
</style>


<main class="staff-page">

    <!-- Mobile Header -->

    <div class="mobile-header">

        <button
            type="button"
            onclick="openAdminSidebar()"
            aria-label="Open Menu"
        >
            ☰
        </button>

        <strong>
            Eventora
        </strong>

    </div>


    <div class="staff-container">


        <!-- Header -->

        <div class="page-header">

            <div class="page-title">

                <h1>
                    HOD / Faculty / Staff
                </h1>

                <p>
                    Manage people, roles, units and access
                    for {{ $organization->name }}.
                </p>

            </div>


            <a
                href="{{ route('organization.admin.staff.create') }}"
                class="add-btn"
            >
                ➕ Add Staff
            </a>

        </div>


        <!-- Success -->

        @if(session('success'))

            <div class="alert alert-success">
                {{ session('success') }}
            </div>

        @endif


        <!-- Filters -->

        <div class="filter-card">

            <form
                method="GET"
                action="{{ route('organization.admin.staff.index') }}"
                class="filter-form"
                data-live-search
            >

                <!-- Search -->

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control filter-search"
                    placeholder="Search name, email, mobile or role..."
                    autocomplete="off"
                >


                <!-- Unit -->

                <select
                    name="unit"
                    class="form-control"
                >

                    <option value="">
                        All Units
                    </option>

                    @foreach($units as $unit)

                        <option
                            value="{{ $unit->id }}"
                            {{ request('unit') == $unit->id ? 'selected' : '' }}
                        >
                            {{ $unit->name }}
                        </option>

                    @endforeach

                </select>


                <!-- Status -->

                <select
                    name="status"
                    class="form-control"
                >

                    <option value="">
                        All Status
                    </option>

                    <option
                        value="active"
                        {{ request('status') === 'active' ? 'selected' : '' }}
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        {{ request('status') === 'inactive' ? 'selected' : '' }}
                    >
                        Inactive
                    </option>

                </select>


                <!-- Search -->

                <button
                    type="submit"
                    class="filter-btn"
                >
                    🔍 Filter
                </button>

            </form>


            @if(request()->hasAny(['search', 'unit', 'status']))

                <div style="margin-top:12px;">

                    <a
                        href="{{ route('organization.admin.staff.index') }}"
                        class="clear-btn"
                    >
                        ✕ Clear Filters
                    </a>

                </div>

            @endif

        </div>

        @include('organization_admin.partials.export-toolbar', ['exportResource' => 'staff'])

        <!-- Staff Table -->

        <div class="staff-card">

            <div class="table-wrap">

                @if($staff->count() > 0)

                    <table>

                        <thead>

                            <tr>

                                <th>
                                    #
                                </th>

                                <th>
                                    Staff Member
                                </th>

                                <th>
                                    Unit
                                </th>

                                <th>
                                    Role
                                </th>

                                <th>
                                    Mobile
                                </th>

                                <th>
                                    Status
                                </th>

                                <th>
                                    Actions
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($staff as $member)

                                <tr>

                                    <!-- Number -->

                                    <td>
                                        {{ $staff->firstItem() + $loop->index }}
                                    </td>


                                    <!-- Staff -->

                                    <td>

                                        <div class="staff-name">
                                            {{ $member->name }}
                                        </div>

                                        <div class="staff-email">
                                            {{ $member->email }}
                                        </div>

                                    </td>


                                    <!-- Unit -->

                                    <td>

                                        @if($member->organizationUnit)

                                            <div class="unit-name">
                                                {{ $member->organizationUnit->name }}
                                            </div>

                                            @if($member->organizationUnit->type)

                                                <div class="unit-type">
                                                    {{ $member->organizationUnit->type }}
                                                </div>

                                            @endif

                                        @else

                                            <span style="color:#9ca3af;">
                                                Organization-wide
                                            </span>

                                        @endif

                                    </td>


                                    <!-- Role -->

                                    <td>

                                        <span class="role-badge">
                                            {{ ucwords(str_replace('_', ' ', $member->role)) }}
                                        </span>

                                    </td>


                                    <!-- Mobile -->

                                    <td>
                                        {{ $member->mobile ?: '—' }}
                                    </td>


                                    <!-- Status -->

                                    <td>

                                        <span class="status-badge
                                            {{ $member->status === 'active'
                                                ? 'status-active'
                                                : 'status-inactive' }}"
                                        >

                                            {{ ucfirst($member->status) }}

                                        </span>

                                    </td>


                                    <!-- Actions -->

                                    <td>

                                        <div class="actions">

                                            <a
                                                href="{{ route('organization.admin.staff.show', $member->id) }}"
                                                class="action-btn view-btn"
                                            >
                                                View
                                            </a>


                                            <a
                                                href="{{ route('organization.admin.staff.edit', $member->id) }}"
                                                class="action-btn edit-btn"
                                            >
                                                Edit
                                            </a>


                                            @if(auth()->user()->role === 'organization_admin')
                                                <form
                                                    action="{{ route('organization.admin.staff.destroy', $member->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Delete this staff member? This action cannot be undone.');"
                                                    style="display:inline;"
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
                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="empty-state">

                        <div class="empty-icon">
                            👥
                        </div>

                        <h3>
                            No Staff Members Found
                        </h3>

                        <p>
                            Add HOD, Faculty, Staff, Manager,
                            Team Lead or other organization members.
                        </p>

                        <a
                            href="{{ route('organization.admin.staff.create') }}"
                            class="add-btn"
                        >
                            ➕ Add First Staff Member
                        </a>

                    </div>

                @endif

            </div>


            <!-- Pagination -->

            @if($staff->hasPages())

                <div class="pagination-wrap">

                    {{ $staff->links() }}

                </div>

            @endif

        </div>

    </div>

</main>
@include('organization_admin.partials.live-search')

