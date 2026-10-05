<div style="min-height:100vh; background:#f4f6fb; font-family:Arial,Helvetica,sans-serif;">

    <style>
        .unit-main {
            margin-left: 260px;
            padding: 30px;
        }

        .mobile-header {
            display: none;
        }

        .unit-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            color: #4f46e5;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .unit-card {
            background: #fff;
            border-radius: 22px;
            padding: 30px;
            box-shadow: 0 8px 30px rgba(15,23,42,.06);
            margin-bottom: 25px;
        }

        .unit-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
        }

        .unit-title {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .unit-icon {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
        }

        .unit-title h1 {
            margin: 0;
            color: #111827;
            font-size: 28px;
        }

        .unit-type {
            margin-top: 5px;
            color: #6b7280;
            font-size: 14px;
        }

        .status {
            display: inline-flex;
            padding: 7px 12px;
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

        .unit-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
            margin-top: 28px;
        }

        .info-box {
            padding: 18px;
            background: #f9fafb;
            border: 1px solid #eef0f4;
            border-radius: 14px;
        }

        .info-label {
            color: #9ca3af;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 7px;
        }

        .info-value {
            color: #1f2937;
            font-size: 14px;
            line-height: 1.6;
        }

        .description-box {
            margin-top: 18px;
        }

        .action-row {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 120px;
            height: 44px;
            padding: 0 16px;
            border-radius: 11px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        .btn-edit {
            background: #fff7ed;
            color: #c2410c;
        }

        .btn-back {
            background: #eef2ff;
            color: #4338ca;
        }

        .events-card {
            background: #fff;
            border-radius: 22px;
            box-shadow: 0 8px 30px rgba(15,23,42,.06);
            overflow: hidden;
        }

        .events-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 24px 26px;
            border-bottom: 1px solid #eef0f4;
        }

        .events-header h2 {
            margin: 0;
            font-size: 21px;
            color: #111827;
        }

        .event-count {
            background: #eef2ff;
            color: #4338ca;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
        }

        .event-list {
            padding: 20px;
        }

        .event-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            padding: 18px;
            border: 1px solid #eef0f4;
            border-radius: 15px;
            margin-bottom: 12px;
            transition: .2s;
        }

        .event-item:last-child {
            margin-bottom: 0;
        }

        .event-item:hover {
            border-color: #c7d2fe;
            transform: translateY(-1px);
        }

        .event-info h3 {
            margin: 0 0 6px;
            font-size: 16px;
            color: #111827;
        }

        .event-meta {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            color: #6b7280;
            font-size: 12px;
        }

        .event-status {
            padding: 6px 9px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 11px;
            font-weight: 700;
        }

        .empty-events {
            text-align: center;
            padding: 45px 20px;
            color: #6b7280;
        }

        .empty-events .icon {
            font-size: 44px;
            margin-bottom: 10px;
        }

        @media (max-width: 900px) {
            .unit-main {
                margin-left: 0;
                padding: 20px;
            }

            .mobile-header {
                display: flex;
                align-items: center;
                gap: 13px;
                background: #fff;
                padding: 14px 16px;
                margin: -20px -20px 22px;
                box-shadow: 0 3px 15px rgba(0,0,0,.05);
            }

            .mobile-header button {
                width: 40px;
                height: 40px;
                border: none;
                border-radius: 10px;
                background: #6366f1;
                color: #fff;
                font-size: 20px;
                cursor: pointer;
            }

            .mobile-header strong {
                font-size: 18px;
                color: #111827;
            }
        }

        @media (max-width: 650px) {
            .unit-card {
                padding: 20px;
            }

            .unit-top {
                flex-direction: column;
            }

            .unit-title h1 {
                font-size: 23px;
            }

            .unit-info-grid {
                grid-template-columns: 1fr;
            }

            .events-header {
                padding: 20px;
            }

            .event-list {
                padding: 14px;
            }

            .event-item {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>


    @include('organization_admin.sidebar')


    <main class="unit-main">

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


        <div class="unit-container">

            <a
                href="{{ route('organization.admin.units.index') }}"
                class="back-link"
            >
                ← Back to Organization Units
            </a>


            {{-- UNIT DETAILS --}}

            <div class="unit-card">

                <div class="unit-top">

                    <div class="unit-title">

                        <div class="unit-icon">
                            🏢
                        </div>

                        <div>

                            <h1>
                                {{ $unit->name }}
                            </h1>

                            <div class="unit-type">
                                {{ $unit->type ?: 'Organization Unit' }}
                            </div>

                        </div>

                    </div>


                    <span class="status
                        {{ $unit->status === 'active'
                            ? 'status-active'
                            : 'status-inactive' }}">

                        {{ ucfirst($unit->status) }}

                    </span>

                </div>


                <div class="unit-info-grid">

                    <div class="info-box">

                        <div class="info-label">
                            Organization
                        </div>

                        <div class="info-value">
                            {{ $unit->organization->name ?? 'N/A' }}
                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Unit Type
                        </div>

                        <div class="info-value">
                            {{ $unit->type ?: 'Not specified' }}
                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Status
                        </div>

                        <div class="info-value">
                            {{ ucfirst($unit->status) }}
                        </div>

                    </div>


                    <div class="info-box">

                        <div class="info-label">
                            Created
                        </div>

                        <div class="info-value">
                            {{ $unit->created_at?->format('d M Y, h:i A') }}
                        </div>

                    </div>

                </div>


                <div class="info-box description-box">

                    <div class="info-label">
                        Description
                    </div>

                    <div class="info-value">
                        {{ $unit->description ?: 'No description provided.' }}
                    </div>

                </div>


                <div class="action-row">

                    <a
                        href="{{ route('organization.admin.units.edit', $unit->id) }}"
                        class="btn btn-edit"
                    >
                        ✏️ Edit Unit
                    </a>

                    <a
                        href="{{ route('organization.admin.units.index') }}"
                        class="btn btn-back"
                    >
                        ← Back
                    </a>

                </div>

            </div>


            {{-- EVENTS --}}

            <div class="events-card">

                <div class="events-header">

                    <h2>
                        🎫 Events in this Unit
                    </h2>

                    <span class="event-count">
                        {{ $unit->events->count() }} Events
                    </span>

                </div>


                <div class="event-list">

                    @if($unit->events->count() > 0)

                        @foreach($unit->events as $event)

                            <div class="event-item">

                                <div class="event-info">

                                    <h3>
                                        {{ $event->title }}
                                    </h3>

                                    <div class="event-meta">

                                        <span>
                                            📅
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y') }}
                                        </span>

                                        <span>
                                            🕐
                                            {{ $event->event_time }}
                                        </span>

                                        <span>
                                            📍
                                            {{ $event->venue }}
                                        </span>

                                    </div>

                                </div>


                                <span class="event-status">
                                    {{ ucfirst($event->status) }}
                                </span>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-events">

                            <div class="icon">
                                🎫
                            </div>

                            <h3>
                                No Events in This Unit
                            </h3>

                            <p>
                                Events assigned to
                                <strong>{{ $unit->name }}</strong>
                                will appear here.
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </main>

</div>

