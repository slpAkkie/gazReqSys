@extends('GReqSys::templates.main')

@section('title', 'Система заявок ГАЗ - Просмотр заявок')

@section('content')
    <section class="table req-table">
        <div class="table__head">
            <div class="col-2 table__head-cell">Номер заявки</div>
            <div class="col-3 table__head-cell">Организация</div>
            <div class="col-2 table__head-cell">Город</div>
            <div class="col-2 table__head-cell">Автор заявки</div>
            <div class="col-3 table__head-cell">Тип заявки</div>
        </div>

        <div class="table__body">
            @if($reqs->count())
                @foreach ($reqs as $r)
                    <x-GReqSys::index.req-row :req="$r" />
                @endforeach
            @else
                <div class="table__row table__row_disabled">
                    <div class="col table__cell">Заявок еще нет</div>
                </div>
            @endif
        </div>
    </section>

    <section class="mt-5">
        {{ $reqs->links() }}
    </section>
@endsection
