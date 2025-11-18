<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8" />
    <title>Створити залік</title>
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
    <h1>Створення заліку</h1>

    {{-- Вивід помилок --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h5>Будь ласка, виправте наступні помилки:</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('scores.store') }}">
        @csrf

<div class="mb-3">
    <label for="unit_name" class="form-label">Підрозділ</label>
    <input list="units_list" id="unit_name" name="unit_name"
           class="form-control @error('unit_name') is-invalid @enderror"
           placeholder="Почніть вводити підрозділ..." required
           value="{{ old('unit_name') }}">
    <datalist id="units_list">
        @foreach($units as $unit)
            <option value="{{ $unit->unit_name }}">
        @endforeach
    </datalist>
    @error('unit_name')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

        {{-- Дата --}}
<div class="mb-3">
    <label for="date" class="form-label">Дата заліку</label>
    <input type="text" name="date" id="date"
           class="form-control @error('date') is-invalid @enderror"
           placeholder="дд.мм.рррр" value="{{ old('date') }}" required>
    @error('date')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

<!-- Підключення jQuery та Bootstrap Datepicker -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<script>
$(document).ready(function(){
    $('#date').datepicker({
        format: "dd.mm.yyyy", // формат який використовується у валідації
        autoclose: true,
        todayHighlight: true
    });
});
</script>


        {{-- Вправи --}}
        <div class="mb-3">
            <label class="form-label">Вправи</label>
            @foreach($exercises as $exercise)
                <div class="form-check">
                    <input type="checkbox" name="exercises[]" id="ex{{ $exercise->id }}" value="{{ $exercise->id }}"
                           class="form-check-input" {{ in_array($exercise->id, old('exercises', [])) ? 'checked' : '' }}>
                    <label for="ex{{ $exercise->id }}" class="form-check-label">{{ $exercise->exercise_name }}</label>
                </div>
            @endforeach
            @error('exercises')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Зберегти</button>
        <a href="{{ route('scores.index') }}" class="btn btn-secondary">Назад</a>
    </form>
</div>

</body>
</html>
