<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Вправи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="mb-3" style="padding: 10px;">
    <button onclick="location.href='/age-groups'" class="btn btn-outline-secondary btn-sm">Вікові групи</button>
    <button onclick="location.href='/categories'" class="btn btn-outline-secondary btn-sm">Категорії</button>
<button onclick="location.href='/phys-fitness-requirements'" class="btn btn-outline-secondary btn-sm">Вимоги</button>
    <button onclick="location.href='/mil-ranks'" class="btn btn-outline-secondary btn-sm">Військові звання</button>
    <button onclick="location.href='/participants'" class="btn btn-outline-secondary btn-sm">Учні</button>
    <button onclick="location.href='/units'" class="btn btn-outline-secondary btn-sm">Підрозділи</button>
    <button onclick="location.href='/exercises'" class="btn btn-primary btn-sm">Вправи</button>
    <button onclick="location.href='/scores'" class="btn btn-outline-secondary btn-sm">Залік</button>
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm">
        🚪 Вийти
    </button>
</form>

</div>

<div class="container mt-5">

    <h1>Вправи</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form method="GET" action="{{ route('exercises.index') }}" class="mb-3 d-flex gap-2">
    <input type="text" name="name" placeholder="Пошук за назвою" class="form-control" value="{{ request('name') }}">
    <input type="text" name="description" placeholder="Пошук за описом" class="form-control" value="{{ request('description') }}">
    <button type="submit" class="btn btn-primary">🔍 Знайти</button>
</form>

    {{-- Форма додавання --}}
    <form method="POST" action="{{ route('exercises.store') }}" style="max-width: 500px;">
        @csrf

        <div class="mb-3">
            <label for="exercise_name" class="form-label">Назва вправи (№):</label>
            <input type="text" name="exercise_name" id="exercise_name" class="form-control" maxlength="6" required>
        </div>

        <div class="mb-3">
            <label for="exercise_desc" class="form-label">Опис вправи:</label>
            <textarea name="exercise_desc" id="exercise_desc" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            ➕ Додати
        </button>
    </form>

<table class="table table-bordered table-striped mt-4">
    <thead class="table-primary">
        <tr>
            <th style="width: 150px;">Назва</th>
            <th>Опис</th>
            <th style="width: 100px;"></th>
            <th style="width: 100px;"></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($exercises as $exercise)
            <tr>
                <td>{{ $exercise->exercise_name }}</td>
                <td>{{ $exercise->exercise_desc }}</td>
                <td>
                    <a href="{{ route('requirements.index', $exercise) }}" class="btn btn-success btn-sm">Нормативи</a>
                </td>
                <td>
                    <form action="{{ route('exercises.destroy', $exercise) }}" method="POST" onsubmit="return confirm('Видалити цю вправу?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">Немає вправ</td>
            </tr>
        @endforelse
    </tbody>
</table>


</div>
</body>
</html>
