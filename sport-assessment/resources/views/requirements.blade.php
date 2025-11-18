<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Нормативи для {{ $exercise->exercise_name }}</title>
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

    <h1>Нормативи для: {{ $exercise->exercise_name }}</h1>
    <p><strong>Опис:</strong> {{ $exercise->exercise_desc }}</p>

    {{-- Повідомлення --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Форма додавання нормативу --}}
    <form method="POST" action="{{ route('requirements.store', $exercise) }}" style="max-width: 600px;">
        @csrf

        <div class="mb-3">
            <label for="result" class="form-label">Результат:</label>
            <input type="number" step="0.01" name="result" id="result" class="form-control" value="{{ old('result') }}" required min=0.01 max=99999>
            @error('result')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="point" class="form-label">Бали:</label>
            <input type="number" name="point" id="point" class="form-control" value="{{ old('point') }}" required min=1 max=1000>
            @error('point')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Стать:</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="male" value="чоловік" {{ old('gender') == 'чоловік' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="male">Чоловік</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="female" value="жінка" {{ old('gender') == 'жінка' ? 'checked' : '' }}>
                    <label class="form-check-label" for="female">Жінка</label>
                </div>
            </div>
            @error('gender')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">➕ Додати норматив</button>
        <a href="{{ route('requirements.exercises') }}" class="btn btn-secondary ms-2">Назад до вправ</a>
    </form>

    {{-- Таблиця нормативів --}}
    <table class="table table-bordered table-striped mt-4">
        <thead class="table-primary">
            <tr>
                <th>Результат</th>
                <th>Бали</th>
                <th>Стать</th>
                <th style="width: 100px;">Дія</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requirements as $requirement)
                <tr>
                    <td>{{ $requirement->result }}</td>
                    <td>{{ $requirement->point }}</td>
                    <td>{{ $requirement->gender }}</td>
                    <td>
                        <form action="{{ route('requirements.destroy', $requirement) }}" method="POST" onsubmit="return confirm('Видалити цей норматив?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Нормативи відсутні</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
</body>
</html>
