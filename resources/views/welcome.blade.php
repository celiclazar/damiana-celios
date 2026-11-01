<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ function_exists('setting') ? setting('site_name', 'Celios CMS') : 'Celios CMS' }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background: #f8fafc;
                color: #0f172a;
                margin: 0;
                display: flex;
                min-height: 100vh;
                align-items: center;
                justify-content: center;
            }
            .card {
                background: white;
                border-radius: 1rem;
                padding: 2.5rem;
                max-width: 28rem;
                width: 90%;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03);
                border: 1px solid #e2e8f0;
                text-align: center;
            }
            h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; color: #1e293b; }
            p { color: #64748b; font-size: 0.95rem; line-height: 1.5; margin-bottom: 1.5rem; }
            .btn {
                display: inline-block;
                background: #4474bf;
                color: white;
                font-weight: 600;
                font-size: 0.875rem;
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem;
                text-decoration: none;
                transition: background 0.15s ease;
            }
            .btn:hover { background: #275ba5; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1>{{ function_exists('setting') ? setting('site_name', 'Celios CMS') : 'Celios CMS' }}</h1>
            <p>Your client website powered by Celios CMS is ready. Manage content, blog posts, pages, and forms in the administration panel.</p>
            <a href="{{ url('/admin') }}" class="btn">Go to Admin Panel &rarr;</a>
        </div>
    </body>
</html>
