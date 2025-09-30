<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Выбор проекта</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #2c3e50, #3498db);
            color: white;
            text-align: center;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        h1 {
            margin-bottom: 20px;
            font-size: 28px;
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 15px 30px;
            font-size: 18px;
            color: white;
            background: #2980b9;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn:hover {
            background: #1abc9c;
            transform: scale(1.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Добро пожаловать</h1>
        <p>Выберите версию проекта:</p>

        <a href="/self-version/public/index.php" class="btn">Мой проект</a>
        <a href="/video-version/public/index.php" class="btn"> Проект автора</a>
    </div>
</body>

</html>