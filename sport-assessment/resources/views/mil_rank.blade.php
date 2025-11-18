<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Військові звання</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="mb-3" style="padding: 10px;">
    <button onclick="location.href='/age-groups'" class="btn btn-outline-secondary btn-sm">Вікові групи</button>
    <button onclick="location.href='/categories'" class="btn btn-outline-secondary btn-sm">Категорії</button>
<button onclick="location.href='/phys-fitness-requirements'" class="btn btn-outline-secondary btn-sm">Вимоги</button>

    <button onclick="location.href='/mil-ranks'" class="btn btn-primary btn-sm">Військові звання</button>
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

    <h1>Військові звання</h1>

    {{-- Повідомлення про успіх --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form method="GET" action="{{ route('mil-ranks.index') }}" class="mb-3" style="max-width: 400px;">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Пошук за назвою" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">🔍 Пошук</button>
        </div>
    </form>

    {{-- Форма додавання --}}
    <form method="POST" action="{{ route('mil-ranks.store') }}" style="max-width: 500px;">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Назва звання:</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}" maxlength=250>
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">
            ➕ Додати
        </button>
    </form>

    {{-- Таблиця звань --}}
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-primary">
            <tr>
                <th>Назва звання</th>
                <th style="width: 120px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($ranks as $rank)
                <tr>
                    <td>{{ $rank->name }}</td>
                    <td>
                        <form action="{{ route('mil-ranks.destroy', $rank) }}" method="POST" onsubmit="return confirm('Видалити це звання?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center text-muted">Немає звань</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
</body>
</html>
