<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Додати учня</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css" rel="stylesheet">
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
    <button type="submit" class="btn btn-outline-danger btn-sm">
        🚪 Вийти
    </button>
</form>

</div>
<div class="container mt-5">

    <h1>Додати учня</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('participants.store') }}" style="max-width: 600px;">
        @csrf

        <div class="mb-3">
            <label for="fullname" class="form-label">ПІБ:</label>
            <input type="text" name="fullname" id="fullname" class="form-control" required pattern="[A-Za-zА-Яа-яЁёІіЇїЄєҐґ\s'’ʻʹ-]+" value="{{ old('fullname') }}">
        </div>

        <div class="mb-3">
            <label for="mil_rank_id" class="form-label">Військове звання:</label>
            <input type="text" id="mil_rank_autocomplete" class="form-control" placeholder="Почніть вводити звання..." required>
            <input type="hidden" name="mil_rank_id" id="mil_rank_id" value="{{ old('mil_rank_id') }}">
            @error('mil_rank_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Стать:</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_m" value="чоловік" {{ old('gender') == 'чоловік' ? 'checked' : '' }} required>
                    <label class="form-check-label" for="gender_m">Чоловік</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="gender_f" value="жінка" {{ old('gender') == 'жінка' ? 'checked' : '' }}>
                    <label class="form-check-label" for="gender_f">Жінка</label>
                </div>
            </div>
            @error('gender')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="badge_number" class="form-label">Номер нагрудного знаку:</label>
            <input type="number" name="badge_number" id="badge_number" class="form-control" min=0 value="{{ old('badge_number') }}">
        </div>

<div class="mb-3">
    <label for="category_id" class="form-label">Категорія:</label>
    <select name="category_id" id="category_id" class="form-select" required>
        <option value="">-- Оберіть категорію --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                {{ $category->category_number }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="age_group_id" class="form-label">Вікова група:</label>
    <select name="age_group_id" id="age_group_id" class="form-select" required>
        <option value="">-- Оберіть вікову групу --</option>
        @foreach($ageGroups as $ageGroup)
            <option value="{{ $ageGroup->id }}"
                {{ old('age_group_id') == $ageGroup->id ? 'selected' : '' }}>
                {{ $ageGroup->age_group_number }} ({{ $ageGroup->gender }}) - {{ $ageGroup->description }}
            </option>
        @endforeach
    </select>
    @error('age_group_id')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>


        <div class="mb-3">
            <label for="unit_id" class="form-label">Підрозділ:</label>
            <input type="text" id="unit_autocomplete" class="form-control" placeholder="Почніть вводити підрозділ...">
            <input type="hidden" name="unit_id" id="unit_id" value="{{ old('unit_id') }}">
            @error('unit_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Зберегти</button>
        <a href="{{ route('participants.index') }}" class="btn btn-secondary ms-2">Назад</a>
    </form>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<script>
$(function() {
    let milRanks = @json($milRanks->pluck('name', 'id'));
    let categories = @json($categories->mapWithKeys(fn($c) => [$c->id => $c->category_number . ' - ' . Str::limit($c->description, 40)]));
    let ageGroups = @json($ageGroups->mapWithKeys(fn($a) => [$a->id => $a->age_group_number . ' (' . $a->gender . ') - ' . $a->description.substr(0,40)]));
    let units = @json($units->pluck('unit_name', 'id'));

    function setupAutocomplete(inputId, hiddenId, sourceData) {
        let data = Object.entries(sourceData).map(([id, label]) => ({ label, id }));

        $('#' + inputId).autocomplete({
            source: data,
            select: function(event, ui) {
                $('#' + hiddenId).val(ui.item.id);
                $(this).val(ui.item.label);
                return false;
            },
            focus: function(event, ui) {
                $(this).val(ui.item.label);
                return false;
            },
            change: function(event, ui) {
                if (!ui.item) {
                    $('#' + hiddenId).val('');
                    $(this).val('');
                }
            }
        });
    }

    setupAutocomplete('mil_rank_autocomplete', 'mil_rank_id', milRanks);
    setupAutocomplete('category_autocomplete', 'category_id', categories);
    setupAutocomplete('age_group_autocomplete', 'age_group_id', ageGroups);
    setupAutocomplete('unit_autocomplete', 'unit_id', units);
});
</script>

</body>
</html>
