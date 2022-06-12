@extends('GReqSys::templates.main')

@section('title', 'Создать заявку')

@section('header-js')
    <script src="{{ asset('/js/GReqSys/GReqSys.js') }}"></script>
@endsection

@section('content')
    <section id="new-req-form">
        <form @submit.prevent="submitForm" :class="{ disabled: formBlocked }" action="{{ route('api.greqsys.req.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-2 row gap-2">
                        <label for="type" class="form-label col-4">Тип заявки</label>
                        <select name="type_id" id="type" class="form-select col" v-model="formData.type_id">
                            @foreach ($req_types as $t)
                                <option value="{{ $t->id }}">{{ $t->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2 row gap-2">
                        <label for="city" class="form-label col-4">Область</label>
                        <select name="city_id" id="city" class="form-select col" v-model="formData.city_id" @change="loadDeptsFor($event.target.value)">
                            @foreach ($cities as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div v-if="formData.city_id && formData.type_id" class="mb-2 row gap-2">
                        <label for="department" class="form-label col-4">Организация @{{ deptsLoading ? '(Загрузка)' : '' }}</label>
                        <select name="department_id" id="department" class="form-select col" v-model="formData.department_id" :disabled="deptsLoading">
                            <option v-for="d in departments" :key="d.id" :value="d.id">@{{ d.title }}</option>
                        </select>
                    </div>
                    <div v-if="formData.city_id && formData.department_id">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </div>

                <div class="col-6">
                    <div v-if="formErrorMessages.length" class="w-100 mb-2 alert alert-danger" role="alert">
                        <form-error v-for="(e, i) in formErrorMessages" :key="i" :error-data="e" />
                    </div>

                    <div class="mb-3">
                        <div v-if="!!departmentsErrorMessage" class="w-100 alert alert-warning h6" role="alert">@{{ departmentsErrorMessage }}</div>
                        <div v-if="!!staffErrorMessage" class="w-100 alert alert-warning h6" role="alert">@{{ staffErrorMessage }}</div>
                        <div v-if="!!staffInfoMessage" class="w-100 alert alert-info h6" role="alert">@{{ staffInfoMessage }}</div>
                    </div>
                </div>
            </div>

            <div v-if="formData.department_id" class="mt-4">
                <div class="row mb-3">
                    <div class="col-6">
                        <h3>Сотрудники</h3>
                        <div class="d-flex gap-2 align-items-center flex-wrap mb-2">
                            <button class="btn" @click.prevent="addStaff">Добавить</button>
                            <button class="btn" @click.prevent="loadStaffData">Подстановка</button>
                            <button class="btn btn-danger" @click.prevent="clearStaff">Очистить</button>
                        </div>
                    </div>
                </div>

                <div class="req-form__staff-list table" :class="{ table_blocked: staffTableBlocked }">
                    <div class="table__head">
                        <div class="col table__head-cell">Фамилия</div>
                        <div class="col table__head-cell">Имя</div>
                        <div class="col table__head-cell">Отчество</div>
                        <div class="col table__head-cell">Табельный номер</div>
                        <div class="col table__head-cell">Email</div>
                        <div class="col table__head-cell">СНИЛС</div>
                        <div class="col-1 table__head-cell">Действия</div>
                    </div>

                    <staff-row v-for="s in staffRows" :key="s.uid" :data="s" :req-type-id="formData.type_id" @remove="removeStaff(s.uid)" @paste_staff="pasteStaff" />
                </div>
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
                <h6 class="m-0">@{{ errorData.title }}</h6>
                <ul v-if="errorData.errors?.length" class="m-0">
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
            data: () => ({
                maxLength: {
                    last_name: 16,
                    first_name: 16,
                    second_name: 16,
                    emp_number: 6,
                    email: 64,
                    insurance_number: 14,
                },
            }),
            template: `<div class="table__row input-group" :class="rowCSS">
                <input type="text" class="col table__cell form-control" placeholder="Фамилия" v-model="data.last_name">
                <input type="text" class="col table__cell form-control" placeholder="Имя" v-model="data.first_name">
                <input type="text" class="col table__cell form-control" placeholder="Отчество" v-model="data.second_name">
                <input type="text" class="col table__cell form-control" placeholder="Табельный номер" v-model="data.emp_number" @paste.prevent="pasteEmpNumbers">
                <input type="email" class="col table__cell form-control" placeholder="Email" v-model="data.email">
                <input type="text" class="col table__cell form-control" placeholder="СНИЛС" v-model="data.insurance_number">
                <input type="button" class="col-1 btn btn-danger" value="Убрать" @click.prevent="remove">
            </div>`,
            computed: {
                rowCSS() {
                    return {
                        'table__row_highlighted': this.reqTypeId == 1 && this.data.is_wt,
                    }
                },
            },
            watch: {
                'data.last_name': function (newVal, oldVal) { (newVal.length > this.maxLength.last_name) && (this.data.last_name = oldVal) },
                'data.first_name': function (newVal, oldVal) { (newVal.length > this.maxLength.first_name) && (this.data.first_name = oldVal) },
                'data.second_name': function (newVal, oldVal) { (newVal.length > this.maxLength.second_name) && (this.data.second_name = oldVal) },
                'data.emp_number': function (newVal, oldVal) { (newVal.length > this.maxLength.emp_number) && (this.data.emp_number = oldVal) },
                'data.email': function (newVal, oldVal) { (newVal.length > this.maxLength.email) && (this.data.email = oldVal) },
                'data.insurance_number': function (newVal, oldVal) {
                    (newVal.length > this.maxLength.insurance_number) && (this.data.insurance_number = oldVal)

                    let trimedVal = newVal.trim().replaceAll(/[-\s]/g, '')
                    let val = trimedVal.slice(0, 3)
                    if (trimedVal.slice(3, 6))
                        val += `-${trimedVal.slice(3, 6)}`
                    if (trimedVal.slice(6, 9))
                        val += `-${trimedVal.slice(6, 9)}`
                    if (trimedVal.slice(9, 11))
                        val += ` ${trimedVal.slice(9, 11)}`

                    this.data.insurance_number = val
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
                staffRegExp: {
                    last_name: /^[A-Za-zА-Яа-я]+$/,
                    first_name: /^[A-Za-zА-Яа-я]+$/,
                    second_name: /^[A-Za-zА-Яа-я]+$/,
                    emp_number: /^\d{6}$/,
                    email: /^[^@]+@[^@]+\.[^@]{2,3}$/,
                    insurance_number: /^\d{3}-\d{3}-\d{3}\s\d{2}$/,
                },
                staffTableBlocked: false,
                staffErrorMessage: '',
                staffInfoMessage: '',

                departments: [],
                deptsLoading: false,
                departmentsErrorMessage: '',

                formErrorMessages: [],
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
                'formData.department_id': function () {
                    this.clearStaff()
                },
            },
            methods: {
                addStaff() {
                    this.staffRows.push(this.newStaffData)
                    this.nextStaffUID++
                },
                pasteStaff(emp_numbers) {
                    this.removeEmptyStaff()

                    for (let emp_number; emp_number = emp_numbers.shift(); this.nextStaffUID++) {
                        let newStaff = this.newStaffData
                        newStaff.emp_number = emp_number

                        this.staffRows.push(newStaff)
                    }
                },
                removeStaff(uid) {
                    this.staffRows.splice(this.staffRows.findIndex(el => el.uid === uid), 1)
                },
                checkStaffForMessage() {
                    if (this.formData.type_id == 1 && this.staffRows.some(s => s.is_wt))
                            this.staffInfoMessage = 'Отмеченные сотрудники уже имеют аккаунт WT. Создание аккаунта для них будет пропущено (Если аккаунт был деактивирован, он будет восстановлен)'
                },
                removeEmptyStaff() {
                    this.staffRows = this.staffRows.filter(sD => !this.isStaffEmpty(sD))
                },
                removeDublicatedStaff() {
                    this.staffRows = this.staffRows.filter((sD, i) => sD.emp_number ? this.staffRows.findIndex(sDD => sDD.emp_number === sD.emp_number) === i : true)
                },
                isStaffEmpty(staffData) {
                    return !(staffData.last_name || staffData.first_name || staffData.second_name || staffData.emp_number || staffData.email || staffData.insurance_number)
                },
                checkStaffData() {
                    let staffErrorMessages = []

                    this.staffRows.forEach((sD, i) => {
                        let staffErrors = []
                        if (sD.last_name && sD.first_name && sD.second_name && sD.emp_number && sD.email && sD.insurance_number) {
                            if (!sD.last_name.match(this.staffRegExp.last_name)) staffErrors.push('Фамилия может содержать только буквы')
                            if (!sD.first_name.match(this.staffRegExp.first_name)) staffErrors.push('Имя может содержать только буквы')
                            if (!sD.second_name.match(this.staffRegExp.second_name)) staffErrors.push('Отчество может содержать только буквы')
                            if (!sD.emp_number.match(this.staffRegExp.emp_number)) staffErrors.push('Табельный номер может состоять только из 6 цифр')
                            if (!sD.email.match(this.staffRegExp.email)) staffErrors.push('Email должен быть валидным адресом электронной почты')
                            if (!sD.insurance_number.match(this.staffRegExp.insurance_number)) staffErrors.push('СНИЛС должен быть в формате 000-000-000 00')
                        } else staffErrors.push(`Данные о сотруднике указаны не полностью`)

                        if (staffErrors.length) staffErrorMessages.push({
                            title: `Данные о ${i + 1} сотруднике заполнены неверно`,
                            errors: staffErrors,
                        })
                    });

                    return staffErrorMessages
                },
                clearStaffError() { this.staffErrorMessage = '' },
                clearStaffInfo() { this.staffInfoMessage = '' },
                clearAllStaffMessages() {
                    this.clearStaffError()
                    this.clearStaffInfo()
                },
                clearStaff() {
                    this.clearAllStaffMessages()
                    this.staffRows = []
                    this.nextStaffUID = 0
                },
                async loadStaffData() {
                    this.clearAllErrors()

                    this.removeDublicatedStaff()
                    this.removeEmptyStaff()
                    if (!this.formData.department_id) return this.staffErrorMessage = 'Перед подстановкой данных необходимо указать организацию'

                    let emp_numbers_query = this.staffRows.reduce((r, s) => {
                            r.push(s.emp_number)

                            return r
                        }, []).filter(en => !!en).join(',')
                    if (!this.staffRows.length || emp_numbers_query === '') return this.staffErrorMessage = 'Для подстановки нужно указать Табельные номера сотрудников'

                    this.staffTableBlocked = true
                    try {

                        let response = (await axios.get(`/web-api/gaz/staff?emp_numbers=${emp_numbers_query}&department_id=${this.formData.department_id}&is_wt`)).data.data

                        if (this.staffRows.length !== response.length)
                            this.staffErrorMessage = 'Данные были загружены не для всех сотрудников. Некоторые табельные номера не были найдены'

                        response.forEach(sData => {
                            let staffIndex = this.staffRows.findIndex(s => s.emp_number === sData.emp_number)
                            this.staffRows[staffIndex] = {
                                ...this.staffRows[staffIndex],
                                ...sData,
                            }
                        })
                    } catch (e) {
                        this.staffErrorMessage = e?.response?.data?.message || 'Произошла ошибка во время запроса к серверу'
                        console.log(e)
                    } finally {
                        this.checkStaffForMessage()
                    this.staffTableBlocked = false
                    }
                },
                clearFormErrors() {
                    this.formErrorMessages = []
                },
                checkFormErrors() {
                    if (!this.staffRows.length) this.formErrorMessages.push({ title: 'Список сотрудников должен содержать хотя бы одну запись' })
                    if (!this.formData.type_id) this.formErrorMessages.push({ title: 'Тип заявки не указан' })
                    if (!this.formData.city_id) this.formErrorMessages.push({ title: 'Область не указана' })
                    if (!this.formData.department_id) this.formErrorMessages.push({ title: 'Организация не указана' })

                    let staffErrorMessages = this.checkStaffData()

                    if (staffErrorMessages.length) this.formErrorMessages.push(...staffErrorMessages)

                    return !!this.formErrorMessages.length
                },
                async submitForm() {
                    this.removeDublicatedStaff()
                    this.removeEmptyStaff()

                    let postData = {
                        ...this.formData,
                        staff: this.staffRows,
                    }

                    this.clearAllErrors()
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
                clearDepartmentsError() { this.departmentsErrorMessage = '' },
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
                clearAllErrors() {
                    this.clearAllStaffMessages()
                    this.clearDepartmentsError()
                    this.clearFormErrors()
                },
            },
        }).mount('#new-req-form')
    </script>
@endsection
