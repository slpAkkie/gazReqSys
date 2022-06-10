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
            @foreach ($reqs as $r)
                <x-GReqSys::index.req-row :req="$r" />
            @endforeach
        </div>
    </section>

    <section class="mt-5">
        {{ $reqs->links() }}
    </section>
@endsection
