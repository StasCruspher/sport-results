<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Фізпідготовчі вимоги</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="mb-3" style="padding: 10px;">
    <button onclick="location.href='/age-groups'" class="btn btn-outline-secondary btn-sm">Вікові групи</button>
    <button onclick="location.href='/categories'" class="btn btn-outline-secondary btn-sm">Категорії</button>
    <button onclick="location.href='/phys-fitness-requirements'" class="btn btn-primary btn-sm">Вимоги</button>
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
    <h1>Вимоги</h1>

    {{-- Повідомлення про успіх --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Фільтри --}}
    <form method="GET" class="row g-3 mb-4 align-items-end" style="max-width: 900px;">
        <div class="col-md-3">
            <label for="gender_filter" class="form-label">Стать</label>
            <select name="gender" id="gender_filter" class="form-select">
                <option value="">Всі</option>
                <option value="чоловік" {{ request('gender') == 'чоловік' ? 'selected' : '' }}>чоловік</option>
                <option value="жінка" {{ request('gender') == 'жінка' ? 'selected' : '' }}>жінка</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="age_group_filter" class="form-label">Вікова група</label>
            <select name="age_group_id" id="age_group_filter" class="form-select">
                <option value="">Всі</option>
                @foreach($ageGroups as $ageGroup)
                    <option value="{{ $ageGroup->id }}" {{ request('age_group_id') == $ageGroup->id ? 'selected' : '' }}>
                        {{ $ageGroup->age_group_number }} ({{ $ageGroup->gender }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="category_filter" class="form-label">Категорія</label>
            <select name="category_id" id="category_filter" class="form-select">
                <option value="">Всі</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->category_number }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <button type="submit" class="btn btn-primary w-100">🔍 Фільтрувати</button>
            <a href="{{ route('phys_fitness_requirement.index') }}" class="btn btn-secondary w-100 mt-1">Скинути</a>
        </div>
    </form>

    {{-- Форма додавання нової вимоги --}}
    <form method="POST" action="{{ route('phys_fitness_requirement.store') }}" style="max-width: 800px;" class="mb-5">
        @csrf
        <div class="row g-3">
            <div class="col-md-3">
                <label for="age_group_id" class="form-label">Вікова група</label>
                <select name="age_group_id" id="age_group_id" class="form-select" required>
                    @foreach($ageGroups as $ageGroup)
                        <option value="{{ $ageGroup->id }}">{{ $ageGroup->age_group_number }} ({{ $ageGroup->gender }})</option>
                    @endforeach
                </select>
                @error('age_group_id') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label for="category_id" class="form-label">Категорія</label>
                <select name="category_id" id="category_id" class="form-select" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->category_number }}</option>
                    @endforeach
                </select>
                @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label for="gender" class="form-label">Стать</label>
                <select name="gender" id="gender" class="form-select" required>
                    <option value="чоловік">чоловік</option>
                    <option value="жінка">жінка</option>
                </select>
                @error('gender') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label for="exercise_threshold" class="form-label">Порог вправ</label>
                <input type="number" name="exercise_threshold" id="exercise_threshold" class="form-control" required min=1 max=100 value="{{ old('exercise_threshold') }}">
                @error('exercise_threshold') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label for="exercise_count" class="form-label">Кількість вправ</label>
                <input type="number" name="exercise_count" id="exercise_count" class="form-control" required min=3 max=5 value="{{ old('exercise_count') }}">
                @error('exercise_count') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label for="total_points" class="form-label">Бали</label>
                <input type="number" name="total_points" id="total_points" class="form-control" required min=1 max=1000 value="{{ old('total_points') }}">
                @error('total_points') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-2">
                <label for="result" class="form-label">Оцінка</label>
                <input type="number" min=1 max=100 name="result" id="result" class="form-control" required value="{{ old('result') }}">
                @error('result') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary">➕ Додати вимогу</button>
            </div>
        </div>
    </form>

    {{-- Таблиця вимог --}}
    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>Вікова група</th>
                <th>Категорія</th>
                <th>Стать</th>
                <th>Порог вправ</th>
                <th>Кількість вправ</th>
                <th>Бали</th>
                <th>Оцінка</th>
                <th style="width: 120px;">Дія</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requirements as $req)
                <tr>
                    <td>{{ $req->ageGroup->age_group_number }} ({{ $req->ageGroup->gender }})</td>
                    <td>{{ $req->category->category_number }}</td>
                    <td>{{ $req->gender }}</td>
                    <td>{{ $req->exercise_threshold }}</td>
                    <td>{{ $req->exercise_count }}</td>
                    <td>{{ $req->total_points }}</td>
                    <td>{{ $req->result }}</td>
                    <td>
                        <form action="{{ route('phys_fitness_requirement.destroy', $req) }}" method="POST" onsubmit="return confirm('Видалити цю вимогу?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Видалити</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted">Немає вимог</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
