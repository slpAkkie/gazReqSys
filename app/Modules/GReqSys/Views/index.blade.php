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
            <x-GReqSys::index.req-row :data="[
                'id' => '1',
                'created_at' => '12.08.2002',
                'department' => 'Горьковский автомобильный завод',
                'city' => 'Нижегородская область',
                'author' => 'Шаманин Александр Сергеевич',
                'type' => 'ИС WebTutor: создать аккаунт для сотрудника'
            ]" />
        </div>
    </section>

    {{-- TODO: Сделать пагинацию по 10 или 25 штук (Может больше) --}}
@endsection
