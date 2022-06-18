@extends('ReqSys::templates.main')

@section('title', 'Профиль' . (Auth::user()->admin ? ' (Администратор)' : ''))

@section('content')
    <section class="row my-4">
        <div class="col-6">
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">ФИО</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->getFullName() }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Табельный номер</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->emp_number }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">СНИЛС</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->insurance_number }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Email</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->email }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Город</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->getOrganization()->city->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Организация</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->getOrganization()->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Должность</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->getPost()->title }}">
            </div>
            <div class="mb-2 row gap-2">
                <label for="type" class="form-label col-4">Дата найма</label>
                <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->job_meta->hired_at }}">
            </div>
            @if ($user->staff->manager)
                <div class="mb-2 row gap-2">
                    <label for="type" class="form-label col-4">Руководитель</label>
                    <input type="text" class="col form-control" disabled="disabled" value="{{ $user->staff->manager->getFullName() }}">
                </div>
            @endif
        </div>
    </section>
@endsection
