@extends('GReqSys::templates.main')

@section('title', 'Создать заявку')

@section('header-js')
    <script src="{{ asset('/js/GReqSys/GReqSys.js') }}"></script>
@endsection

@section('content')
    <section id="new-req-form">
        <form @submit.prevent="submitForm" :class="{ disabled: formBlocked }" action="{{ route('req.store') }}" method="post">
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
                        <p class="text-danger mt-1">@{{ departmentsErrorMessage }}</p>
                    </div>
                    <div v-if="formData.city_id && formData.department_id">
                        <button type="submit" class="btn btn-success">Создать</button>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-6">
                    <div v-if="formErrorMessages.length" class="text-danger w-100 mb-2 alert alert-danger" role="alert">
                        <form-error v-for="(e, i) in formErrorMessages" :key="i" :error-data="e" />
                    </div>
                </div>
            </div>

            <div class="row mt-4 mb-3">
                <div class="col-6">
                    <h3>Сотрудники</h3>
                    <div class="d-flex gap-2 align-items-center flex-wrap mb-2">
                        <button class="btn btn-secondary" @click.prevent="addStaffRow">Добавить</button>
                        <button class="btn btn-danger" @click.prevent="clearStaff">Очистить</button>
                        <button class="btn btn-info text-light" @click.prevent="loadStaffData">Подстановка</button>
                    </div>

                    <div v-if="!!staffErrorMessage" class="w-100 mb-2 alert alert-warning" role="alert">@{{ staffErrorMessage }}</div>
                    <div v-if="!!staffInfoMessage" class="w-100 alert alert-info" role="alert">@{{ staffInfoMessage }}</div>
                </div>
            </div>

            <div class="req-form__staff-list staff-table">
                <div class="row mx-0 staff-table__row staff-table__head">
                    <div class="col">Фамилия</div>
                    <div class="col">Имя</div>
                    <div class="col">Отчество</div>
                    <div class="col">Табельный номер</div>
                    <div class="col">Email</div>
                    <div class="col">СНИЛС</div>
                    <div class="col-1">Действия</div>
                </div>

                <staff-row v-for="s in staffRows" :key="s.uid" :data="s" :req-type-id="formData.type_id" @remove="removeStaff(s.uid)" @paste_staff="pasteStaff" />
            </div>
        </form>
    </section>
@endsection

@section('footer-js')
    <script>
        const formError = Vue.defineComponent({
            name: 'formError',
            props: {
                errorData: Object,
            },
            template: `<div class="form-alert__message-block">
                <h5 class="m-0">@{{ errorData.title }}</h5>
                <ul v-if="errorData.errors?.length">
                    <li v-for="e in errorData.errors">@{{ e }}</li>
                </ul>
            </div>`,
        })

        const staffRow = Vue.defineComponent({
            name: 'staffRow',
            emits: [ 'remove', 'paste_staff' ],
            props: {
                data: Object,
                reqTypeId: String,
            },
            template: `<div class="row mx-0 staff-table__row gap-2" :class="rowCSS">
                <input type="text" class="col form-control" placeholder="Фамилия" v-model="data.last_name">
                <input type="text" class="col form-control" placeholder="Имя" v-model="data.first_name">
                <input type="text" class="col form-control" placeholder="Отчество" v-model="data.second_name">
                <input type="text" class="col form-control" placeholder="Табельный номер" v-model="data.emp_number" @paste.prevent="pasteEmpNumbers">
                <input type="email" class="col form-control" placeholder="Email" v-model="data.email">
                <input type="text" class="col form-control" placeholder="СНИЛС" v-model="data.insurance_number">
                <input type="button" class="col-1 btn btn-danger" value="Убрать" @click.prevent="remove">
            </div>`,
            computed: {
                rowCSS() {
                    return {
                        'staff-table__row_highlighted': this.reqTypeId == 1 && this.data.is_wt,
                    }
                },
            },
            methods: {
                remove() {
                    this.$emit('remove')
                },
                pasteEmpNumbers(e) {
                    let emp_numbers = e.clipboardData.getData('text').split('\n')
                    emp_numbers = emp_numbers.map(e => e.trim())
                    this.data.emp_number = emp_numbers.shift()

                    this.$emit('paste_staff', emp_numbers)
                },
            },
        })

        const reqForm = Vue.createApp({
            name: 'reqForm',
            components: {
                formError,
                staffRow,
            },
            data: () => ({
                formData: {
                    type_id: null,
                    city_id: null,
                    department_id: null,
                },

                nextStaffUID: 0,
                staffRows: [],

                departments: [],
                deptsLoading: false,

                staffErrorMessage: '',
                staffInfoMessage: '',
                formErrorMessages: [],
                departmentsErrorMessage: '',

                formBlocked: false,
            }),
            computed: {
                newStaffData() {
                    return {
                        uid: this.nextStaffUID,
                        first_name: '',
                        last_name: '',
                        second_name: '',
                        emp_number: '',
                        email: '',
                        insurance_number: '',
                    }
                },
            },
            watch: {
                'formData.type_id': function () {
                    this.clearStaffInfo()
                    this.checkStaffForMessage()
                },
            },
            methods: {
                addStaffRow() {
                    this.staffRows.push(this.newStaffData)
                    this.nextStaffUID++
                },
                clearFormErrors() {
                    this.formErrorMessages = []
                },
                checkFormErrors() {
                    if (!this.formData.type_id) this.formErrorMessages.push({ title: 'Тип заявки не указан' })
                    if (!this.formData.city_id) this.formErrorMessages.push({ title: 'Область не указана' })
                    if (!this.formData.department_id) this.formErrorMessages.push({ title: 'Организация не указана' })

                    let staffErrorMessages = this.checkStaffData()

                    if (staffErrorMessages.length) this.formErrorMessages.push({ title: 'Данные о сотрудниках заполнены не верно', errors: staffErrorMessages })

                    return !!this.formErrorMessages.length
                },
                isStaffEmpty(staffData) {
                    return !(staffData.last_name || staffData.first_name || staffData.second_name || staffData.emp_number || staffData.email || staffData.insurance_number)
                },
                removeEmptyStaff() {
                    this.staffRows = this.staffRows.filter(sD => !this.isStaffEmpty(sD))
                },
                checkStaffData() {
                    let staffErrorMessages = []

                    this.staffRows.forEach((sD, i) => {
                        if (sD.last_name && sD.first_name && sD.second_name && sD.emp_number && sD.email && sD.insurance_number) return

                        staffErrorMessages.push(`Данные о ${i + 1} сотруднике указаны не полностью`)
                    });

                    return staffErrorMessages
                },
                setFormErrorsFromResponse(errors) {
                    let staffErrors = []

                    for (let e in errors) {
                        if (errors.hasOwnProperty(e)) {
                            if (!e.startsWith('staff') || e === 'staff') this.formErrorMessages.push({ title: errors[e].join(',') })
                            else {
                                let staffIndex = e.split('.')[1]

                                if (!staffErrors[+staffIndex]) staffErrors[+staffIndex] = []
                                staffErrors[+staffIndex].push(errors[e].join(', '))
                            }
                        }
                    }

                    staffErrors.forEach((sE, i) => this.formErrorMessages.push({
                        title: `Сотрудник ${i + 1}`,
                        errors: sE,
                    }))
                },
                async submitForm() {
                    let postData = {
                        ...this.formData,
                        staff: this.staffRows,
                    }

                    this.removeEmptyStaff()
                    this.clearFormErrors()
                    if (this.checkFormErrors()) return

                    try {
                        this.formBlocked = true
                        await axios.post('/web-api/reqsys/req', postData)

                        window.location.href = '{{ route('req.index') }}'
                    } catch (e) {
                        let errors = e?.response?.data?.errors
                        errors && this.setFormErrorsFromResponse(errors)

                        console.log(e)
                    } finally {
                        this.formBlocked = false
                    }
                },
                removeStaff(uid) {
                    this.staffRows.splice(this.staffRows.findIndex(el => el.uid === uid), 1)
                },
                async loadDeptsFor(city_id) {
                    this.clearDepartmentsError()
                    this.formData.department_id = null
                    this.deptsLoading = true

                    try {
                        let response = (await axios.get(`/web-api/gaz/departments?city_id=${city_id}`)).data.data

                        this.departments = response
                    } catch (e) {
                        this.departmentsErrorMessage = e?.response?.data?.message || 'Произошла ошибка во время запроса к серверу'
                        console.log(e)
                    } finally {
                        this.deptsLoading = false
                    }
                },
                pasteStaff(emp_numbers) {
                    for (let emp_number; emp_number = emp_numbers.shift(); this.nextStaffUID++) {
                        let newStaff = this.newStaffData
                        newStaff.emp_number = emp_number

                        this.staffRows.push(newStaff)
                    }
                },
                clearStaffError() { this.staffErrorMessage = '' },
                clearStaffInfo() { this.staffInfoMessage = '' },
                clearDepartmentsError() { this.departmentsErrorMessage = '' },
                clearAllStaffMessages() {
                    this.clearStaffError()
                    this.clearStaffInfo()
                },
                clearStaff() {
                    this.clearAllStaffMessages()
                    this.staffRows = []
                    this.nextStaffUID = 0
                },
                checkStaffForMessage() {
                    if (this.formData.type_id == 1 && this.staffRows.some(s => s.is_wt))
                            this.staffInfoMessage = 'Отмеченные сотрудники уже имеют аккаунт WT'
                },
                async loadStaffData() {
                    this.clearAllStaffMessages()
                    if (!this.formData.department_id) return this.staffErrorMessage = 'Перед подстановкой данных необходимо указать организацию'

                    try {
                        let emp_numbers_query = this.staffRows.reduce((r, s) => {
                            r.push(s.emp_number)

                            return r
                        }, []).filter(en => !!en).join(',')

                        let response = (await axios.get(`/web-api/gaz/staff?emp_numbers=${emp_numbers_query}&department_id=${this.formData.department_id}&is_wt`)).data.data

                        if (this.staffRows.length !== response.length)
                            this.staffErrorMessage = 'Данные были загружены не для всех сотрудников. Некоторые табельные номера не были найдены'

                        response.forEach(sData => {
                            this.staffRows[
                                this.staffRows.findIndex(s => s.emp_number === sData.emp_number)
                            ] = sData
                        })
                    } catch (e) {
                        this.staffErrorMessage = e?.response?.data?.message || 'Произошла ошибка во время запроса к серверу'
                        console.log(e)
                    } finally {
                        this.checkStaffForMessage()
                    }
                },
            },
        }).mount('#new-req-form')
    </script>
@endsection
