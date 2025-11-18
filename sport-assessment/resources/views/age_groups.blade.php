<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Вікові групи</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="mb-3" style="padding: 10px;">
    <button onclick="location.href='/age-groups'" class="btn btn-primary btn-sm">Вікові групи</button>
    <button onclick="location.href='/categories'" class="btn btn-outline-secondary btn-sm">Категорії</button>
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

    <h1>Вікові групи</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form method="GET" action="{{ route('age_groups.index') }}" class="mb-3">
        <label>Фільтр за статтю:</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="all" value="" {{ request('gender') === null ? 'checked' : '' }}>
            <label class="form-check-label" for="all">Усі</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="male" value="чоловік" {{ request('gender') === 'чоловік' ? 'checked' : '' }}>
            <label class="form-check-label" for="male">Чоловіки</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="gender" id="female" value="жінка" {{ request('gender') === 'жінка' ? 'checked' : '' }}>
            <label class="form-check-label" for="female">Жінки</label>
        </div>
        <button type="submit" class="btn btn-primary btn-sm ms-2">Фільтрувати</button>
    </form>

<form method="POST" action="{{ route('age_groups.store') }}" style="max-width: 500px;">
    @csrf

    <div style="margin-bottom: 15px;">
        <label for="age_group_number">Номер групи:</label><br>
        <input type="number" min=1 max=100 name="age_group_number" id="age_group_number" required style="width: 100%;">
    </div>

    <div style="margin-bottom: 15px;">
        <label for="description">Опис групи:</label><br>
        <textarea name="description" id="description" rows="4" required style="width: 100%;"></textarea>
    </div>

    <div style="margin-bottom: 15px;">
        <label for="gender">Стать:</label><br>
        <select name="gender" id="gender" required style="width: 100%; padding: 8px;">
            <option value="">-- Оберіть стать --</option>
            <option value="чоловік">Чоловік</option>
            <option value="жінка">Жінка</option>
        </select>
    </div>

    <button type="submit" style="
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    ">
        ➕ Додати
    </button>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Номер</th>
            <th>Опис</th>
            <th>Стать</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse ($ageGroups as $group)
            <tr>
                <td>{{ $group->age_group_number }}</td>
                <td>{{ $group->description }}</td>
                <td>{{ ucfirst($group->gender) }}</td>
                <td>
                    <form action="{{ route('age_groups.destroy', $group) }}" method="POST" onsubmit="return confirm('Видалити цю вікову групу?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Видалити</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center">Немає вікових груп</td></tr>
        @endforelse
    </tbody>
</table>


</div>
</body>
</html>
