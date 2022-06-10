@extends('GReqSys::templates.main')

@section('title', 'Создать заявку')

@section('header-js')
    <script src="{{ asset('/js/GReqSys/GReqSys.js') }}"></script>
@endsection

@section('content')
    <section id="new-req-form">
        <form @submit.prevent="submitForm" action="{{ route('req.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-2">
                        <label for="type" class="form-label">Тип заявки</label>
                        <select name="type_id" id="type" class="form-select" v-model="formData.type_id">
                            <option value="1">Тип 1</option>
                            <option value="2">Тип 2</option>
                            <option value="3">Тип 3</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="city" class="form-label">Область</label>
                        <select name="city_id" id="city" class="form-select" v-model="formData.city_id">
                            <option value="1">Область 1</option>
                            <option value="2">Область 2</option>
                            <option value="3">Область 3</option>
                        </select>
                    </div>
                    <div v-if="formData.city_id" class="mb-2">
                        <label for="department" class="form-label">Организация</label>
                        <select name="department_id" id="department" class="form-select" v-model="formData.department_id">
                            <option value="1">Организация 1</option>
                            <option value="2">Организация 2</option>
                            <option value="3">Организация 3</option>
                        </select>
                    </div>
                    <div v-if="formData.city_id && formData.department_id">
                        <button type="submit" class="btn btn-success">Создать</button>
                    </div>
                </div>
            </div>

            <h3 class="mt-4 mb-3">Сотрудники</h3>
            <button class="btn btn-secondary" @click.prevent="addStuffRow">Добавить</button>

            <div class="req-form__stuff-list stuff-table">
                <div class="row mx-0 stuff-table__head">
                    <div class="col">Фамилия</div>
                    <div class="col">Имя</div>
                    <div class="col">Отчество</div>
                    <div class="col">Табельный номер</div>
                    <div class="col">Email</div>
                    <div class="col">СНИЛС</div>
                    <div class="col-1">Действия</div>
                </div>

                <stuff-row v-for="s in stuffRows" :key="s.uid" :data="s" @remove="removeStuff(s.uid)" />
            </div>
        </form>
    </section>
@endsection

@section('footer-js')
    <script>
        const stuffRow = Vue.defineComponent({
            name: 'stuffRow',
            emits: [ 'remove' ],
            props: {
                data: Object,
            },
            template: `<div class="row mx-0 stuff-table__row gap-2">
                <input type="text" class="col form-control" placeholder="Фамилия" v-model="data.first_name">
                <input type="text" class="col form-control" placeholder="Имя" v-model="data.last_name">
                <input type="text" class="col form-control" placeholder="Отчество" v-model="data.second_name">
                <input type="text" class="col form-control" placeholder="Табельный номер" v-model="data.emp_number">
                <input type="email" class="col form-control" placeholder="Email" v-model="data.email">
                <input type="text" class="col form-control" placeholder="СНИЛС" v-model="data.insurance_number">
                <input type="button" class="col-1 btn btn-danger" value="Убрать" @click.prevent="remove">
            </div>`,
            methods: {
                remove() {
                    this.$emit('remove')
                },
            },
        })

        const reqForm = Vue.createApp({
            name: 'reqForm',
            components: {
                stuffRow,
            },
            data: () => ({
                formData: {
                    type_id: null,
                    city_id: null,
                    department_id: null,
                },
                stuffRows: [],
                nextStuffUID: 0,
            }),
            computed: {
                stuffData() {
                    return {
                        uid: this.nextStuffUID,
                        first_name: '',
                        last_name: '',
                        second_name: '',
                        emp_number: '',
                        email: '',
                        insurance_number: '',
                    }
                },
            },
            methods: {
                addStuffRow() {
                    this.stuffRows.push(this.stuffData)
                    this.nextStuffUID++
                },
                submitForm() {
                    let postData = {
                        ...this.formData,
                        stuff: this.stuffRows,
                    }

                    // TODO: Send request and handle validation errors
                },
                removeStuff(uid) {
                    this.stuffRows.splice(this.stuffRows.findIndex(el => el.uid === uid), 1)
                },
            },
            mounted() {
                this.addStuffRow()
            },
        }).mount('#new-req-form')
    </script>
@endsection
