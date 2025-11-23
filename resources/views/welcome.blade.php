<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Permission Management System</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                min-height: 100vh;
                margin: 0;
                padding: 2rem 0;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 2rem;
            }
            .hero {
                text-align: center;
                color: white;
                margin-bottom: 4rem;
            }
            .hero h1 {
                font-size: 3.5rem;
                font-weight: 700;
                margin-bottom: 1rem;
            }
            .hero p {
                font-size: 1.25rem;
                margin-bottom: 2rem;
                opacity: 0.9;
            }
            .btn {
                display: inline-block;
                padding: 0.75rem 2rem;
                background: white;
                color: #667eea;
                text-decoration: none;
                border-radius: 0.5rem;
                font-weight: 600;
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            }
            .features {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                margin-bottom: 4rem;
            }
            .feature {
                background: white;
                padding: 2rem;
                border-radius: 1rem;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .feature:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 35px rgba(0,0,0,0.15);
            }
            .feature-icon {
                width: 60px;
                height: 60px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 1rem;
            }
            .feature-icon svg {
                width: 30px;
                height: 30px;
                stroke: white;
                fill: none;
                stroke-width: 2;
            }
            .feature h3 {
                color: #333;
                margin-bottom: 1rem;
            }
            .feature p {
                color: #666;
                line-height: 1.6;
            }
            .login-link {
                position: fixed;
                top: 1rem;
                right: 1rem;
                background: white;
                color: #667eea;
                padding: 0.5rem 1rem;
                border-radius: 0.5rem;
                text-decoration: none;
                font-weight: 600;
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .login-link:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            }
        </style>
    </head>
    <body>
        @if (Route::has('login'))
            @guest
            <a href="{{ route('login') }}" class="login-link">Log in</a>
            @else
            <a href="{{ url('/home') }}" class="login-link">Dashboard</a>
            @endguest
        @endif

        <div class="container">
            <div class="hero">
                <h1>Permission Management System</h1>
                <p>Secure role-based access control for your application</p>
                @guest
                <a href="{{ route('login') }}" class="btn">Get Started</a>
                @endguest
            </div>

            <div class="features">
                <div class="feature">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3>Secure Access Control</h3>
                    <p>Granular permissions ensure users only access what they're authorized to see.</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <h3>Role-Based Management</h3>
                    <p>Define user roles and permissions to streamline access management.</p>
                </div>

                <div class="feature">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3>Easy Administration</h3>
                    <p>Intuitive admin interface for managing users and their permissions.</p>
                </div>
            </div>
        </div>
    </body>
</html>
