<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Заліки</title>
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
    <button onclick="location.href='/exercises'" class="btn btn-outline-secondary btn-sm">Вправи</button>
    <button onclick="location.href='/scores'" class="btn btn-primary btn-sm">Залік</button>
<form action="{{ route('logout') }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-outline-danger btn-sm">
        🚪 Вийти
    </button>
</form>

</div>

<div class="container mt-5">
    <h1>Заліки</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form method="GET" class="row g-3 mb-4 align-items-end" style="max-width: 900px;">
    <!-- Підрозділ -->
    <div class="col-md-3">
        <label for="unit" class="form-label">Підрозділ</label>
        <input type="text" name="unit" id="unit" class="form-control" value="{{ request('unit') }}">
    </div>

    <!-- Діапазон дат -->
    <div class="col-md-3">
        <label class="form-label">Дата від</label>
        <input type="month" name="date_from" class="form-control" value="{{ request('date_from') }}">
    </div>
    <div class="col-md-3">
        <label class="form-label">Дата до</label>
        <input type="month" name="date_to" class="form-control" value="{{ request('date_to') }}">
    </div>

    <!-- Кількість вправ -->
    <div class="col-md-2">
        <label class="form-label">Кількість вправ</label>
        <select name="exercise_count" class="form-select">
            <option value="">Всі</option>
            @foreach($exerciseCounts as $count)
                <option value="{{ $count }}" {{ request('exercise_count') == $count ? 'selected' : '' }}>
                    {{ $count }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Незавершені заліки -->
    <div class="col-md-2 d-flex align-items-center">
        <div class="form-check mt-4">
            <input class="form-check-input" type="checkbox" name="incomplete" id="incomplete" value="1" {{ request('incomplete') ? 'checked' : '' }}>
            <label class="form-check-label" for="incomplete">
                Незавершені заліки
            </label>
        </div>
    </div>

    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">🔍 Фільтрувати</button>
        <a href="{{ route('scores.index') }}" class="btn btn-secondary">Скинути</a>
    </div>
</form>



    <form method="GET" class="mb-4 row g-3 align-items-end">
        <div class="col-md-4">
            <label for="unit" class="form-label">Пошук за підрозділом</label>
            <input type="text" name="unit" id="unit" class="form-control" value="{{ request('unit') }}" placeholder="Назва підрозділу">
        </div>

        <div class="col-md-3">
            <label for="sort_date" class="form-label">Сортування за датою</label>
            <select name="sort_date" id="sort_date" class="form-select">
                <option value="">За замовчуванням</option>
                <option value="asc" {{ request('sort_date') == 'asc' ? 'selected' : '' }}>Старі спочатку</option>
                <option value="desc" {{ request('sort_date') == 'desc' ? 'selected' : '' }}>Нові спочатку</option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">🔍 Пошук</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('scores.index') }}" class="btn btn-secondary w-100">Скинути</a>
        </div>
    </form>

    <a href="{{ route('scores.create') }}" class="btn btn-primary mb-3">➕ Створити залік</a>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>Підрозділ</th>
                <th>Кількість вправ</th>
                <th>Дата</th>
                <th style="width: 120px;">Дія</th>
            </tr>
        </thead>
        <tbody>
            @forelse($scores as $s)
                <tr>
                    <td>{{ $s->unit->unit_name ?? '—' }}</td>
                    <td>{{ $s->exercise_count }}</td>
                    <td>{{ $s->date }}</td>
                    <td>
                        <button onclick="location.href='{{ route('scores.show', $s->id) }}'" class="btn btn-info btn-sm">Переглянути</button>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Немає заліків</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $scores->links() }}
</div>
</body>
</html>
