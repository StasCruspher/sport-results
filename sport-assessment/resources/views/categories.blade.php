<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Категорії</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="mb-3" style="padding: 10px;">
    <button onclick="location.href='/age-groups'" class="btn btn-outline-secondary btn-sm">Вікові групи</button>
    <button onclick="location.href='/categories'" class="btn btn-primary btn-sm">Категорії</button>
<button onclick="location.href='/phys-fitness-requirements'" class="btn btn-outline-secondary btn-sm">Вимоги</button>
    <button onclick="location.href='/mil-ranks'" class="btn btn-outline-secondary btn-sm">Військові звання</button>
    <button onclick="location.href='/participants'" class="btn btn-outline-secondary btn-sm">Учні</button>
    <button onclick="location.href='/units'" class="btn btn-outline-secondary btn-sm">Підрозділи</button>
    <button onclick="location.href='/exercises'" class="btn btn-outline-secondary btn-sm">Вправи</button>
    <button onclick="location.href='/scores'" class="btn btn-outline-secondary btn-sm">Залік</button>
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm">
        🚪 Вийти
    </button>
</form>

</div>
<div class="container mt-5">

    <h1>Категорії</h1>

    {{-- Повідомлення про успіх --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Форма додавання --}}
    <form method="POST" action="{{ route('categories.store') }}" style="max-width: 500px;">
        @csrf

        <div class="mb-3">
            <label for="category_number" class="form-label">Номер категорії:</label>
            <input type="number" min=1 max=100 name="category_number" id="category_number" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">
            ➕ Додати
        </button>
    </form>

    {{-- Таблиця категорій --}}
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-primary">
            <tr>
                <th style="width: 120px;">Номер</th>
                <th style="width: 100px;">Дія</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category->category_number }}</td>
                    <td>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Видалити цю категорію?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Немає категорій</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
</body>
</html>
