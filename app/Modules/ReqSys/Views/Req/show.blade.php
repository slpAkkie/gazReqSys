@extends('ReqSys::templates.main')

@section('title', 'Заявка №' . $req->id . ' от ' . $req->created_at)

@section('content')
    @if ($req->created_at !== $req->updated_at)
    <h6 class="page-subtitle">
        (Обновлено {{ $req->updated_at }})
    </h6>
    @endif

    <section>
        <a href="{{ url()->previous() }}" class="btn">Назад</a>
    </section>

    <section class="row my-4">
        <div class="col-6">
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Тип заявки</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->type->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="city" class="form-label col-4">Область</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->organization->city->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="organization" class="form-label col-4">Организация</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->organization->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="organization" class="form-label col-4">Автор заявки</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ "{$req->author_staff->getFullName()} ({$req->author_staff->emp_number})" }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="organization" class="form-label col-4">Статус заявки</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $req->status->title }}">
            </div>

            <div class="d-flex gap-2">
                @if($may_vote)
                    <form action="{{ route('req.confirm', $req->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="submit" class="btn btn-primary" value="Подтвердить">
                    </form>
                @endif

                @if($may_be_resolved)
                    <form action="{{ route('req.resolve', $req->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="submit" class="btn btn-primary" value="Провести">
                    </form>
                @endif
            </div>
        </div>


        @if($may_vote)
            <div class="col-6">
                <form class="d-flex flex-column align-items-end h-100 gap-2" action="{{ route('req.deny', $req->id) }}" method="post">
                    @csrf
                    @method('put')
                    <textarea class="form-control w-100 flex-grow-1" name="refusal_reason" id="refusal_reason" placeholder="Причина отказа"></textarea>
                    <input type="submit" class="btn btn-danger" value="Отклонить">
                </form>
            </div>
        @elseif($req->status->slug === 'denied')
            <div class="col-6">
                <div class="alert alert-danger" role="alert">
                    <h5>Причина отказа</h5>
                    <span class="fw-semibold">{{ $req->getUserWhoDenied()->staff->getFullName() }}:</span> {{ $req->getRefusalReason() }}
                </div>
            </div>
        @endif
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
                @foreach ($req_staff as $s)
                    <div class="table__row">
                        <div class="col table__cell">{{ $s->getFullName() }}</div>
                        <div class="col table__cell">{{ $s->emp_number }}</div>
                        <div class="col table__cell">{{ $s->email }}</div>
                        <div class="col table__cell">{{ $s->insurance_number }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
