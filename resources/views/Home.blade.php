<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="ASCII">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RC2</title>

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <form action="/Encrypt" method="POST">

        <input type="text" placeholder="Путь к исходному файлу" name="src_file_path">
        <input type="text" placeholder="Путь к результирующему файлу" name="end_file_path">

        <div class="line">
            <input type="text" placeholder="Пароль" name="password">
            <input type="text" placeholder="Подтверждение пароля" name="re_password">
        </div>
        <input type="number" placeholder="Длинна ключа" name="key_len">
        <div class="line checkbox-line">
            <input type="checkbox" name="delete_src_file">
            <div class="text">Удалить исходный файл</div>
        </div>
        <div class="line">
            <button type="submit" name="button" value="Encode">Зашифровать</button>
            <button type="submit" name="button" value="Decode">Расшифровать</button>
        </div>

        @csrf
    </form>
</body>
</html>