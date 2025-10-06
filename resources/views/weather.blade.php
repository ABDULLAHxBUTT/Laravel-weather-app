<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weather App</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #74ABE2, #5563DE, #F5B041);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes gradientShift {
            0% {background-position: 0% 50%;}
            50% {background-position: 100% 50%;}
            100% {background-position: 0% 50%;}
        }

        .weather-container {
            max-width: 520px;
            width: 100%;
            padding: 35px;
            background: rgba(255, 255, 255, 0.18);
            border-radius: 24px;
            backdrop-filter: blur(14px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .weather-container h1 {
            font-weight: 600;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .input-group input {
            border-radius: 35px 0 0 35px !important;
            border: none;
            padding: 12px 18px;
            font-size: 1rem;
        }

        .input-group button {
            border-radius: 0 35px 35px 0 !important;
            background: #ffb703;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 12px 25px;
            transition: 0.3s ease;
        }

        .input-group button:hover {
            background: #ffa41b;
        }

        .card {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            border-radius: 18px;
            color: #fff;
            margin-top: 25px;
            box-shadow: 0 4px 25px rgba(0,0,0,0.1);
            padding: 28px;
        }

        .temp {
            font-size: 2.6rem;
            font-weight: 600;
            margin: 5px 0;
        }

        .description {
            text-transform: capitalize;
            font-size: 1.1rem;
            color: #f1f1f1;
            margin-bottom: 10px;
        }

        .extra-info {
            font-size: 1rem;
            color: #e8e8e8;
        }

        footer {
            text-align: center;
            margin-top: 22px;
            font-size: 0.85rem;
            color: #eee;
        }

        @media (max-width: 768px) {
            .weather-container {
                margin: 15px;
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    <div>
        <div class="weather-container">
            <h1>🌤️ Live Weather</h1>

            <form method="GET" action="/weather" class="mb-3">
                <div class="input-group">
                    <input type="text" name="city" class="form-control" placeholder="Enter city..." value="{{ $city ?? '' }}">
                    <button type="submit">Search</button>
                </div>
            </form>

            @if(isset($weather))
                <div class="card">
                    <h4 class="mb-2">{{ ucfirst($city) }}</h4>
                    <img src="http://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png" alt="Weather Icon" style="width: 90px; height: 90px;">
                    <div class="temp">{{ $weather['main']['temp'] }}°C</div>
                    <p class="description">{{ $weather['weather'][0]['description'] }}</p>
                    <div class="extra-info">
                        💨 {{ $weather['wind']['speed'] }} m/s &nbsp; | &nbsp; 💧 {{ $weather['main']['humidity'] }}%
                    </div>
                </div>
            @elseif(isset($error))
                <div class="alert alert-danger mt-3">{{ $error }}</div>
            @endif
        </div>

        <footer>
            Built with ❤️ using Laravel & OpenWeather API
        </footer>
    </div>

    <script>
    window.onload = function () {
        if (navigator.geolocation && !window.location.search.includes('lat')) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                window.location.href = `/weather?lat=${lat}&lon=${lon}`;
            });
        }
    };
    </script>
</body>
</html>
