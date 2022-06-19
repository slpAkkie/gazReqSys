@extends('ReqSys::templates.main')

@section('title', 'Профиль' . (Auth::user()->admin ? ' (Администратор)' : ''))

@section('content')
    <section class="row my-4">
        <div class="col-6">
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">ФИО</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->getFullName() }}</div>
            </div>
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">Табельный номер</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->emp_number }}</div>
            </div>
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">СНИЛС</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->insurance_number }}</div>
            </div>
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">Email</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->email }}</div>
            </div>
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">Город</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->getOrganization()->city->title }}</div>
            </div>
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">Организация</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->getOrganization()->title }}</div>
            </div>
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">Должность</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->getPost()->title }}</div>
            </div>
            <div class="mb-2 row gap-2">
                <label class="form-label col-4">Дата найма</label>
                <div class="col form-control form-control_disabled">{{ $user->staff->job_meta->hired_at }}</div>
            </div>
            @if ($user->staff->manager)
                <div class="mb-2 row gap-2">
                    <label class="form-label col-4">Руководитель</label>
                    <div class="col form-control form-control_disabled">{{ $user->staff->manager->getFullName() }} ({{ $user->staff->manager->emp_number }})</div>
                </div>
            @endif
        </div>
    </section>
@endsection
