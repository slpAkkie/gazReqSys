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
                            @foreach ($req_types as $t)
                                <option value="{{ $t->id }}">{{ $t->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="city" class="form-label">Область</label>
                        <select name="city_id" id="city" class="form-select" v-model="formData.city_id" @change="loadDeptsFor($event.target.value)">
                            @foreach ($cities as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div v-if="formData.city_id" class="mb-2">
                        <label for="department" class="form-label">Организация @{{ deptsLoading ? '(Загрузка)' : '' }}</label>
                        <select name="department_id" id="department" class="form-select" v-model="formData.department_id" :disabled="deptsLoading">
                            <option v-for="d in departments" :key="d.id" :value="d.id">@{{ d.title }}</option>
                        </select>
                    </div>
                    <div v-if="formData.city_id && formData.department_id">
                        <button type="submit" class="btn btn-success">Создать</button>
                    </div>
                </div>
            </div>

            <h3 class="mt-4 mb-3">Сотрудники</h3>
            <button class="btn btn-secondary me-2" @click.prevent="addStuffRow">Добавить</button>
            <button class="btn btn-danger me-2" @click.prevent="clearStuff">Очистить</button>
            <button class="btn btn-info text-light me-2" @click.prevent="loadStuffData">Подстановка</button>
            <span class="text-danger">@{{ stuffErrorMessage }}</span>

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

                <stuff-row v-for="s in stuffRows" :key="s.uid" :data="s" @remove="removeStuff(s.uid)" @paste_stuff="pasteStuff" />
            </div>
        </form>
    </section>
@endsection

@section('footer-js')
    <script>
        const stuffRow = Vue.defineComponent({
            name: 'stuffRow',
            emits: [ 'remove', 'paste_stuff' ],
            props: {
                data: Object,
            },
            template: `<div class="row mx-0 stuff-table__row gap-2">
                <input type="text" class="col form-control" placeholder="Фамилия" v-model="data.first_name">
                <input type="text" class="col form-control" placeholder="Имя" v-model="data.last_name">
                <input type="text" class="col form-control" placeholder="Отчество" v-model="data.second_name">
                <input type="text" class="col form-control" placeholder="Табельный номер" v-model="data.emp_number" @paste.prevent="pasteEmpNumbers">
                <input type="email" class="col form-control" placeholder="Email" v-model="data.email">
                <input type="text" class="col form-control" placeholder="СНИЛС" v-model="data.insurance_number">
                <input type="button" class="col-1 btn btn-danger" value="Убрать" @click.prevent="remove">
            </div>`,
            methods: {
                remove() {
                    this.$emit('remove')
                },
                pasteEmpNumbers(e) {
                    let emp_numbers = e.clipboardData.getData('text').split('\n')
                    emp_numbers = emp_numbers.map(e => e.trim())
                    this.data.emp_number = emp_numbers.shift()

                    this.$emit('paste_stuff', emp_numbers)
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
                departments: [],
                deptsLoading: false,
                nextStuffUID: 0,
                stuffErrorMessage: '',
            }),
            computed: {
                newStuffData() {
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
                    this.stuffRows.push(this.newStuffData)
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
                async loadDeptsFor(city_id) {
                    this.deptsLoading = true

                    try {
                        let response = (await axios.get(`/web-api/gaz/departments?city_id=${city_id}`)).data.data

                        this.departments = response
                    } catch (e) {
                        console.log('Произошла ошибка во время запроса к серверу')
                        console.log(e)
                    } finally {
                        this.deptsLoading = false
                    }
                },
                pasteStuff(emp_numbers) {
                    for (let emp_number; emp_number = emp_numbers.shift(); this.nextStuffUID++) {
                        let newStuff = this.newStuffData
                        newStuff.emp_number = emp_number

                        this.stuffRows.push(newStuff)
                    }
                },
                clearStuffError() {
                    this.stuffErrorMessage = ''
                },
                clearStuff() {
                    this.clearStuffError()
                    this.stuffRows = []
                    this.nextStuffUID = 0
                },
                async loadStuffData() {
                    this.clearStuffError()
                    if (!this.formData.department_id) return this.stuffErrorMessage = 'Перед подстановкой данных необходимо указать организацию'

                    try {
                        // TODO: Запрос к gaz web-api
                    } catch (e) {
                        // TODO: Сообщение об ошибке
                    } finally {
                        // TODO: Действия после запроса
                    }
                },
            },
            mounted() {
                this.addStuffRow()
            },
        }).mount('#new-req-form')
    </script>
@endsection
