@extends('GReqSys::templates.main')

@section('title', 'Заявка №' . $req->id)

@section('content')
    <section>
        <a href="{{ route('req.index') }}" class="btn">Все заявки</a>
    </section>

    <section class="row my-4">
        <div class="col-6">
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Тип заявки</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->type->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="city" class="form-label col-4">Область</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->department->city->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="department" class="form-label col-4">Организация</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->department->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="department" class="form-label col-4">Автор заявки</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->author_staff->getFullName() }}">
            </div>
        </div>
    </section>

    <section>
        <h4>Вовлеченные сотрудники:</h4>

        <div class="table">
            <div class="table__head">
                <div class="col table__head-cell">ФИО</div>
                <div class="col table__head-cell">Табельный номер</div>
                <div class="col table__head-cell">Email</div>
                <div class="col table__head-cell">СНИЛС</div>
            </div>
            <div class="table__body">
                @foreach ($involved_staff as $s)
                    <div class="table__row">
                        <div class="col table__cell">{{ $s->getFullName() }}</div>
                        <div class="col table__cell">{{ $s->emp_number }}</div>
                        <div class="col table__cell">{{ $s->email }}</div>
                        <div class="col table__cell">{{ $s->insurance_number }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
