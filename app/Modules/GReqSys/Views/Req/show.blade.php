@extends('GReqSys::templates.main')

@section('title', 'Заявка №' . $req->id)

@section('content')
    <section>
        <a href="{{ route('req.index') }}" class="btn btn-primary">Все заявки</a>
    </section>

    <section class="req-info">
        <div class="row">
            <ul class="col-6 d-flex flex-column my-4 list-unstyled">
                <li><b>Тип заявки</b>: {{ $req->type->title }}</li>
                <li><b>Город</b>: {{ $req->department->city->title }}</li>
                <li><b>Организация</b>: {{ $req->department->title }}<li>
                <li><b>Автор заявки</b>: {{ $req->author_staff->getFullName() }}</li>
            </ul>
        </div>
    </section>

    <section class="req-staff-table">
        <h4>Вовлеченные сотрудники:</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Фамилия: </th>
                    <th>Имя</th>
                    <th>Отчество</th>
                    <th>Табельный номер</th>
                    <th>Email</th>
                    <th>СНИЛС</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($involved_staff as $s)
                    <tr>
                        <td>{{ $s->last_name }}</td>
                        <td>{{ $s->first_name }}</td>
                        <td>{{ $s->second_name }}</td>
                        <td>{{ $s->emp_number }}</td>
                        <td>{{ $s->email }}</td>
                        <td>{{ $s->insurance_number }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
