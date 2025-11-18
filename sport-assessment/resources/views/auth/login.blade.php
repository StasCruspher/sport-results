<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Логін</title>
</head>
<body>
    <h1>Вхід</h1>

    @if ($errors->any())
        <div style="color:red">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Пароль:</label>
        <input type="password" name="password" required>
        <button type="submit">Увійти</button>
    </form>
</body>
</html>
