<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Set Password - Eventora</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: #0f172a;
            color: #ffffff;
        }

        .card {
            width: 100%;
            max-width: 460px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 18px;
            padding: 35px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo h1 {
            font-size: 30px;
            color: #38bdf8;
        }

        .logo p {
            margin-top: 8px;
            color: #94a3b8;
            font-size: 14px;
        }

        h2 {
            text-align: center;
            margin-bottom: 10px;
        }

        .description {
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            color: #e2e8f0;
        }

        input {
            width: 100%;
            padding: 13px 14px;
            border-radius: 10px;
            border: 1px solid #475569;
            background: #0f172a;
            color: #ffffff;
            outline: none;
            font-size: 15px;
        }

        input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.12);
        }

        .button {
            width: 100%;
            border: none;
            padding: 14px;
            border-radius: 10px;
            background: #38bdf8;
            color: #082f49;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 8px;
        }

        .button:hover {
            background: #0ea5e9;
            color: #ffffff;
        }

        .error {
            background: #450a0a;
            color: #fecaca;
            border: 1px solid #7f1d1d;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .error ul {
            padding-left: 18px;
        }

        .email-info {
            background: #0f172a;
            border: 1px solid #334155;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            color: #cbd5e1;
            font-size: 14px;
            word-break: break-word;
        }

        @media (max-width: 500px) {
            .card {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>

<div class="card">

    <div class="logo">
        <h1>Eventora</h1>
        <p>Organization Admin Portal</p>
    </div>

    <h2>Set Your Password</h2>

    <p class="description">
        Your organization has been approved.
        Create a secure password to access your Organization Admin account.
    </p>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="email-info">
        <strong>Email:</strong>
        {{ $email }}
    </div>

    <form method="POST" action="{{ route('organization.admin.password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="form-group">
            <label for="password">New Password</label>

            <input
                type="password"
                id="password"
                name="password"
                required
                minlength="8"
                placeholder="Enter your new password"
            >
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>

            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
                minlength="8"
                placeholder="Confirm your new password"
            >
        </div>

        <button type="submit" class="button">
            Set Password
        </button>
    </form>

</div>

</body>
</html>