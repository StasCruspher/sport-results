<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Учні</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<div class="mb-3" style="padding: 10px;">
    <button onclick="location.href='/age-groups'" class="btn btn-outline-secondary btn-sm">Вікові групи</button>
    <button onclick="location.href='/categories'" class="btn btn-outline-secondary btn-sm">Категорії</button>
    <button onclick="location.href='/phys-fitness-requirements'" class="btn btn-outline-secondary btn-sm">Вимоги</button>
    <button onclick="location.href='/mil-ranks'" class="btn btn-outline-secondary btn-sm">Військові звання</button>
    <button onclick="location.href='/participants'" class="btn btn-primary btn-sm">Учні</button>
    <button onclick="location.href='/units'" class="btn btn-outline-secondary btn-sm">Підрозділи</button>
    <button onclick="location.href='/exercises'" class="btn btn-outline-secondary btn-sm">Вправи</button>
    <button onclick="location.href='/scores'" class="btn btn-outline-secondary btn-sm">Залік</button>
    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">🚪 Вийти</button>
    </form>
</div>

<div class="container mt-5">

    <h1>Учні</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('participants.create') }}" class="btn btn-primary mb-3">➕ Додати учня</a>

    {{-- Форма фільтрів --}}
    <form method="GET" action="{{ route('participants.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="fullname" class="form-control" placeholder="Пошук ПІБ" value="{{ request('fullname') }}">
            </div>
            <div class="col-md-2">
                <select name="mil_rank_id" class="form-select">
                    <option value="">Всі звання</option>
                    @foreach($milRanks as $rank)
                        <option value="{{ $rank->id }}" @selected(request('mil_rank_id') == $rank->id)>{{ $rank->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="gender" class="form-select">
                    <option value="">Всі статі</option>
                    <option value="чоловік" @selected(request('gender')=='чоловік')>Чоловік</option>
                    <option value="жінка" @selected(request('gender')=='жінка')>Жінка</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" name="badge_number" class="form-control" placeholder="Номер нагрудного" value="{{ request('badge_number') }}">
            </div>
            <div class="col-md-2">
                <select name="category_id" class="form-select">
                    <option value="">Всі категорії</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id')==$category->id)>{{ $category->category_number }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="age_group_id" class="form-select">
                    <option value="">Всі вікові групи</option>
                    @foreach($ageGroups as $group)
                        <option value="{{ $group->id }}" @selected(request('age_group_id')==$group->id)>{{ $group->age_group_number }} - {{ $group->gender }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="unit_id" class="form-select">
                    <option value="">Всі підрозділи</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" @selected(request('unit_id')==$unit->id)>{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Фільтрувати</button>
            </div>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead class="table-primary">
            <tr>
                <th>ПІБ</th>
                <th>Звання</th>
                <th>Стать</th>
                <th>Номер нагрудного знаку</th>
                <th>Категорія</th>
                <th>Вікова група</th>
                <th>Підрозділ</th>
                <th style="width: 100px;"></th>
                <th style="width: 100px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($participants as $p)
                <tr>
                    <td>{{ $p->fullname }}</td>
                    <td>{{ $p->milRank->name ?? '' }}</td>
                    <td>{{ $p->gender }}</td>
                    <td>{{ $p->badge_number }}</td>
                    <td>{{ $p->category->category_number ?? '' }}</td>
                    <td>{{ $p->ageGroup->age_group_number ?? '' }} - {{ $p->ageGroup->gender ?? '' }}</td>
                    <td>{{ $p->unit->unit_name ?? '' }}</td>
                    <td>
                        <form action="{{ route('participants.destroy', $p) }}" method="POST" onsubmit="return confirm('Видалити учня?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Видалити</button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('participants.scores', $p->id) }}"
                           class="btn btn-sm btn-primary">
                            Заліки
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="text-center text-muted">Немає учнів</td></tr>
            @endforelse
        </tbody>
    </table>

</div>
</body>
</html>
