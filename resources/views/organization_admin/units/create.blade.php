@include('organization_admin.sidebar')

<style>
    .unit-page {
        margin-left: 260px;
        min-height: 100vh;
        padding: 30px;
        background: #f6f7fb;
        font-family: Arial, Helvetica, sans-serif;
    }

    .mobile-header {
        display: none;
    }

    .unit-container {
        max-width: 850px;
        margin: auto;
    }

    .page-header {
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin: 0;
        font-size: 30px;
        font-weight: 800;
        color: #1f2937;
    }

    .page-header p {
        margin: 7px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .form-card {
        background: #fff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 30px rgba(15,23,42,.06);
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 700;
        color: #374151;
    }

    .required {
        color: #dc2626;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        height: 48px;
        padding: 0 14px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 14px;
        outline: none;
        background: white;
        color: #1f2937;
    }

    textarea.form-control {
        height: 130px;
        padding: 13px 14px;
        resize: vertical;
    }

    .form-control:focus {
        border-color: #6d5dfc;
        box-shadow: 0 0 0 3px rgba(109,93,252,.10);
    }

    .help-text {
        margin-top: 7px;
        color: #9ca3af;
        font-size: 12px;
    }

    .error-message {
        margin-top: 7px;
        color: #dc2626;
        font-size: 13px;
    }

    .actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 10px;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 120px;
        height: 46px;
        padding: 0 18px;
        border-radius: 12px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        border: none;
        cursor: pointer;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-save {
        background: #6d5dfc;
        color: white;
        box-shadow: 0 8px 20px rgba(109,93,252,.20);
    }

    .btn-save:hover {
        transform: translateY(-1px);
    }

    @media(max-width:768px) {

        .unit-page {
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

        .form-card {
            padding: 20px;
        }

        .actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }
    }
</style>


<main class="unit-page">

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

        <div class="page-header">

            <h1>
                Add Organization Unit
            </h1>

            <p>
                Create a department, team, section or any other unit
                for {{ $organization->name }}.
            </p>

        </div>


        <div class="form-card">

            <form
                method="POST"
                action="{{ route('organization.admin.units.store') }}"
            >

                @csrf


                {{-- Unit Name --}}

                <div class="form-group">

                    <label for="name">
                        Unit Name
                        <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="e.g. Information Technology"
                        required
                    >

                    <div class="help-text">
                        Enter the name of the department, team, section or group.
                    </div>

                    @error('name')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Unit Type --}}

                <div class="form-group">

                    <label for="type">
                        Unit Type
                    </label>

                    <select
                        id="type"
                        name="type"
                        class="form-control"
                    >

                        <option value="">
                            Select Unit Type
                        </option>

                        <option
                            value="Department"
                            {{ old('type') === 'Department' ? 'selected' : '' }}
                        >
                            Department
                        </option>

                        <option
                            value="Team"
                            {{ old('type') === 'Team' ? 'selected' : '' }}
                        >
                            Team
                        </option>

                        <option
                            value="Section"
                            {{ old('type') === 'Section' ? 'selected' : '' }}
                        >
                            Section
                        </option>

                        <option
                            value="Division"
                            {{ old('type') === 'Division' ? 'selected' : '' }}
                        >
                            Division
                        </option>

                        <option
                            value="Faculty"
                            {{ old('type') === 'Faculty' ? 'selected' : '' }}
                        >
                            Faculty
                        </option>

                        <option
                            value="HR"
                            {{ old('type') === 'HR' ? 'selected' : '' }}
                        >
                            HR
                        </option>

                        <option
                            value="Group"
                            {{ old('type') === 'Group' ? 'selected' : '' }}
                        >
                            Group
                        </option>

                        <option
                            value="Other"
                            {{ old('type') === 'Other' ? 'selected' : '' }}
                        >
                            Other
                        </option>

                    </select>

                    <div class="help-text">
                        Select the type that best matches your organization unit.
                    </div>

                    @error('type')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Description --}}

                <div class="form-group">

                    <label for="description">
                        Description
                    </label>

                    <textarea
                        id="description"
                        name="description"
                        class="form-control"
                        placeholder="Enter a short description..."
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Status --}}

                <div class="form-group">

                    <label for="status">
                        Status
                        <span class="required">*</span>
                    </label>

                    <select
                        id="status"
                        name="status"
                        class="form-control"
                        required
                    >

                        <option
                            value="active"
                            {{ old('status', 'active') === 'active' ? 'selected' : '' }}
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            {{ old('status') === 'inactive' ? 'selected' : '' }}
                        >
                            Inactive
                        </option>

                    </select>

                    <div class="help-text">
                        Inactive units will not appear in the Event Create dropdown.
                    </div>

                    @error('status')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror

                </div>


                {{-- Actions --}}

                <div class="actions">

                    <a
                        href="{{ route('organization.admin.units.index') }}"
                        class="btn btn-cancel"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="btn btn-save"
                    >
                        Create Unit
                    </button>

                </div>

            </form>

        </div>

    </div>

</main>
