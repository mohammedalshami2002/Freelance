<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <title>صفحة الضحية</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #1a2294;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .sensitive-button {
            padding: 200px 400px;
            font-size: 24px;
            font-weight: bold;
            color: rgb(146, 24, 24);
            background-color: #dc3545;
            /* زر أحمر */
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }
    </style>
</head>

<body>


    <button class="sensitive-button"
        onclick="document.body.style.backgroundColor = 'red'; this.innerHTML = 'تم حذف حسابك بنجاح!';">
        احذف حسابي
    </button>


</body>

</html>
