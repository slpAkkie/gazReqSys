@extends('templates.service')

@section('title', 'Заявка')

@section('content')

<a style="color: black;" href="{{ route('req.index') }}">Вернуться к списку заявок</a>
<div class="show-wrapper">
    <h1 class="text-center">Заявка №{{ $req->id }}</h1>

    <ul style="list-style-type: none" class="d-flex flex-column p-0">
        <li><b>Организация</b>: {{ $req->department->title }}<li>
        <li><b>Город</b>: {{ $req->department->city->title }}</li>
        {{-- <li><b>Автор заявки</b>: {{ $req->author_staff->getFullName() }}</li> --}}
        <li><b>Тип заявки</b>: {{ $req->type->title }}</li>
    </ul>

    <h4>Вовлеченные сотрудники:</h4>
    <table class="table table-striped">
        <thead>
            <tr>
            <th scope="col">Фамилия: </th>
            <th scope="col">Имя</th>
            <th scope="col">Отчество</th>
            <th scope="col">Табельный номер</th>
            <th scope="col">Email</th>
            <th scope="col">СНИЛС</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($involved_staff as $item)
                <tr>
                    <td>{{ $item->staff->last_name }}</td>
                    <td>{{ $item->staff->first_name }}</td>
                    <td>{{ $item->staff->second_name }}</td>
                    <td>{{ $item->staff->emp_number }}</td>
                    <td>{{ $item->staff->email }}</td>
                    <td>{{ $item->staff->insurance_number }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
