<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Laravel') }} - Login</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <style>
            body {
                font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;
                background: #f7f7f6;
                margin: 0;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1rem;
            }
            .card {
                width: min(460px, 100%);
                background: #ffffff;
                border-radius: 1rem;
                box-shadow: 0 20px 60px rgba(0,0,0,0.08);
                padding: 2rem;
            }
            .card h1 {
                margin: 0 0 1rem;
                font-size: 1.5rem;
            }
            .field {
                margin-bottom: 1rem;
            }
            .field label {
                display: block;
                font-weight: 600;
                margin-bottom: 0.35rem;
            }
            .field input {
                width: 100%;
                padding: 0.85rem 1rem;
                border-radius: 0.75rem;
                border: 1px solid #d1d5db;
                font-size: 1rem;
                box-sizing: border-box;
            }
            .field input:focus {
                outline: none;
                border-color: #f97316;
                box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.12);
            }
            .button {
                width: 100%;
                border: 0;
                border-radius: 0.75rem;
                padding: 0.95rem 1rem;
                font-size: 1rem;
                font-weight: 700;
                background: #f97316;
                color: white;
                cursor: pointer;
            }
            .button:hover {
                background: #ea580c;
            }
            .error {
                margin-top: 0.35rem;
                color: #b91c1c;
                font-size: 0.95rem;
            }
            .status {
                margin-bottom: 1rem;
                padding: 1rem;
                background: #fde68a;
                color: #92400e;
                border-radius: 0.75rem;
            }
            .footer {
                margin-top: 1.5rem;
                text-align: center;
                color: #6b7280;
                font-size: 0.95rem;
            }
        </style>
    </head>
    <body>
        <main class="card">
            <h1>Login</h1>

            @if ($errors->any())
                <div class="status">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
                    @error('email')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" />
                    @error('password')
                        <div class="error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field" style="display:flex; align-items:center; gap:0.5rem;">
                    <input id="remember" type="checkbox" name="remember" />
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="button">Log in</button>
            </form>

            <div class="footer">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">Reload login page</a>
                @endif
            </div>
        </main>
    </body>
</html>
