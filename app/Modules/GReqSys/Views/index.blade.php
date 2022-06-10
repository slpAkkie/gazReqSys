@extends('GReqSys::templates.main')

@section('title', 'Система заявок ГАЗ - Просмотр заявок')

@section('content')
    <section class="req-table">
        <div class="row mx-0 req-table__head">
            <div class="col-2">Номер заявки</div>
            <div class="col-3">Организация</div>
            <div class="col-2">Город</div>
            <div class="col-2">Автор заявки</div>
            <div class="col-3">Тип заявки</div>
        </div>

        <div class="req-body">
            @foreach ($reqs as $req)
                <x-GReqSys::index.req-row :data="[
                    'id' => $req->id,
                    'created_at' => $req->created_at,
                    'department' => $req->department->title,
                    'city' => $req->department->city->title,
                    'author' => $req->getStuffFullName(),
                    'type' => $req->type->title
                ]" />
            @endforeach
        </div>
    </section>

    {{-- TODO: Сделать пагинацию по 10 или 25 штук (Может больше) --}}
@endsection
