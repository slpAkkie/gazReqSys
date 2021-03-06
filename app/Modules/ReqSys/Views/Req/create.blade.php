@extends('ReqSys::templates.main')

@section('title', 'Создать заявку')

@section('content')
    <section id="req-form">
        <form @submit.prevent="submitForm" :class="{ disabled: formSubmiting }" action="{{ route('api.reqsys.req.store') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-6">
                    <div class="mb-2 row gap-2">
                        <label for="type" class="form-label col-4">Тип заявки</label>
                        <select name="type_id" id="type" class="form-select col" v-model.number="formData.type_id">
                            @foreach ($req_types as $t)
                                <option value="{{ $t->id }}">{{ $t->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2 row gap-2">
                        <label for="city" class="form-label col-4">Город</label>
                        <select name="city_id" id="city" class="form-select col" v-model.number="formData.city_id">
                            @foreach ($cities as $c)
                                <option value="{{ $c->id }}">{{ $c->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div v-if="formData.city_id && formData.type_id" class="mb-2 row gap-2">
                        <label for="organization" class="form-label col-4">Организация @{{ organizationsLoading ? '(Загрузка)' : '' }}</label>
                        <select name="organization_id" id="organization" class="form-select col" v-model.number="formData.organization_id" :disabled="organizationsLoading">
                            <option v-for="d in organizations" :key="d.id" :value="d.id">@{{ d.title }}</option>
                        </select>
                    </div>
                    <div v-if="formData.city_id && formData.organization_id">
                        <button type="submit" class="btn btn-primary">Отправить заявку</button>
                    </div>
                </div>

                <div class="col-6">
                    <div v-if="alerts.form.error.length" class="w-100 mb-2 alert alert-danger" role="alert">
                        <form-error v-for="(e, i) in alerts.form.error" :key="i" :error-data="e" />
                    </div>

                    <div class="mb-3">
                        <div v-if="!!alerts.organizations.error" class="w-100 alert alert-danger h6" role="alert">@{{ alerts.organizations.error }}</div>
                        <div v-if="!!alerts.staff.error" class="w-100 alert alert-danger h6" role="alert">@{{ alerts.staff.error }}</div>
                        <div v-if="!!alerts.staff.warn" class="w-100 alert alert-warning h6" role="alert">@{{ alerts.staff.warn }}</div>
                        <div v-if="!!alerts.staff.info" class="w-100 alert alert-info h6" role="alert">@{{ alerts.staff.info }}</div>
                    </div>
                </div>
            </div>

            <div v-if="formData.organization_id" class="mt-4">
                <div class="row">
                    <div class="col-6">
                        <h3 class="mb-3">Сотрудники</h3>
                        <div class="d-flex gap-2 align-items-center flex-wrap mb-2">
                            <button class="btn" :disabled="isLimitStaff" @click.prevent="addStaff">Добавить</button>
                            <button class="btn" @click.prevent="loadStaff">Подстановка по табельному номеру</button>
                            <button class="btn btn-danger" @click.prevent="clearStaff">Очистить</button>
                        </div>
                    </div>
                    <div class="col-6 d-flex justify-content-end align-items-end">
                        <p class="mb-1 fw-bold">@{{ formData.staff.length }} / @{{ maxStaffCount }}</p>
                    </div>
                </div>

                <div class="req-form__staff-list table" :class="{ table_blocked: staffTableBlocked }">
                    <div class="table__head">
                        <div class="table__head-cell table__cell_index">№</div>
                        <div class="col table__head-cell">Фамилия</div>
                        <div class="col table__head-cell">Имя</div>
                        <div class="col table__head-cell">Отчество</div>
                        <div class="col table__head-cell">Табельный номер</div>
                        <div class="col table__head-cell">Email</div>
                        <div class="col table__head-cell">СНИЛС</div>
                        <div class="col-1 table__head-cell">Действия</div>
                    </div>

                    <div class="table__body">
                        <staff-row v-for="(s, i) in formData.staff" :key="s.uid" :data="s" :staff-index="i" :req-type-id="formData.type_id" @remove="removeStaff(s.uid)" @paste_staff="pasteStaff" />
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection

@section('footer-js')
    <script>
        /**
         * Vue элемент - Блок для отрисовки ошибки в форме
         */
        const formError = Vue.defineComponent({
            name: 'formError',
            props: {
                errorData: Object,
            },
            template: `<div class="alert__message-block">
                <h6 class="m-0">@{{ errorData.title }}</h6>
                <ul v-if="errorData.errors?.length" class="m-0">
                    <li v-for="e in errorData.errors">@{{ e }}</li>
                </ul>
            </div>`,
        })



        /**
         * Vue элемент - Строка сотрудника
         */
        const staffRow = Vue.defineComponent({
            name: 'staffRow',
            emits: [ 'remove', 'paste_staff' ],
            props: {
                staffIndex: Number,
                data: Object,
                reqTypeId: Number,
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
                <div class="table__cell table__cell_index">@{{ staffIndex + 1 }}</div>
                <input type="text" class="col table__cell form-control" placeholder="Фамилия" v-model="data.last_name">
                <input type="text" class="col table__cell form-control" placeholder="Имя" v-model="data.first_name">
                <input type="text" class="col table__cell form-control" placeholder="Отчество" v-model="data.second_name">
                <input type="text" class="col table__cell form-control" placeholder="Табельный номер" v-model="data.emp_number" @paste.prevent="pasteEmpNumbers">
                <input type="email" class="col table__cell form-control" placeholder="Email" v-model="data.email">
                <input type="text" class="col table__cell form-control" placeholder="СНИЛС" v-model="data.insurance_number">
                <input type="button" class="col-1 btn btn-danger" value="Убрать" @click.prevent="$emit('remove')">
            </div>`,
            computed: {
                rowCSS() {
                    return {
                        'table__row_highlighted': this.reqTypeId == 1 && this.data.wt_acc_exists,
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
                pasteEmpNumbers(e) {
                    let emp_numbers = e.clipboardData.getData('text').split('\n')
                    emp_numbers = emp_numbers.map(e => e.trim())

                    this.data.emp_number = emp_numbers.shift()

                    this.$emit('paste_staff', {
                        emp_numbers,
                        uid: this.data.uid,
                        index: this.staffIndex,
                    })
                },
            },
        })



        /**
         * Vue элемент - Форма создания заявки
         */
        const reqForm = Vue.createApp({
            name: 'reqForm',
            components: {
                staffRow,
                formError,
            },
            data: () => ({
                formData: {
                    type_id: null,
                    city_id: null,
                    organization_id: null,
                    staff: [],
                },

                // Уникальный идентификатор строки сотрудника
                // Для указания в ключе перебора Vue.js
                nextStaffUID: 0,
                staffRegExp: {
                    last_name: /^[A-Za-zА-Яа-яЁё]+$/,
                    first_name: /^[A-Za-zА-Яа-яЁё]+$/,
                    second_name: /^[A-Za-zА-Яа-яЁё]+$/,
                    emp_number: /^\d{6}$/,
                    email: /^[^@]+@[^@]+\.[^@]{2,3}$/,
                    insurance_number: /^\d{3}-\d{3}-\d{3}\s\d{2}$/,
                },
                staffTableBlocked: false,
                maxStaffCount: 50,

                organizations: [],
                organizationsLoading: false,

                formSubmiting: false,

                alerts: {
                    staff: {
                        info: null,
                        warn: null,
                        error: null,
                    },
                    organizations: {
                        info: null,
                        warn: null,
                        error: null,
                    },
                    form: {
                        info: [],
                        warn: [],
                        error: [],
                    },
                },
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
                isLimitStaff() {
                    return this.formData.staff.length >= this.maxStaffCount;
                }
            },
            watch: {
                'formData.type_id': function () {
                    this.clearStaffInfoAlert()
                    this.checkInfoForStaff()
                },
                'formData.city_id': function (newVal) {
                    this.loadOrganizations(newVal)
                },
                'formData.organization_id': function () {
                    this.clearStaff()
                },
            },
            methods: {
                addStaff() {
                    if (this.formData.staff.length >= this.maxStaffCount) return
                    this.formData.staff.push(this.newStaffData)
                    this.nextStaffUID++
                },
                pasteStaff({ emp_numbers, uid, index }) {
                    for (let emp_number; emp_number = emp_numbers.shift(); this.nextStaffUID++) {
                        if (this.formData.staff.length >= this.maxStaffCount) continue
                        let newStaff = this.newStaffData
                        newStaff.emp_number = emp_number

                        this.formData.staff.splice(++index, 0, newStaff)
                    }

                    this.removeDublicatedStaff()
                },
                removeStaff(uid) {
                    this.formData.staff.splice(this.formData.staff.findIndex(el => el.uid === uid), 1)
                },
                checkInfoForStaff() {
                    if (this.formData.type_id == 1 && this.formData.staff.some(s => s.wt_acc_exists))
                            this.alerts.staff.info = 'Отмеченные сотрудники уже имеют аккаунт WT. Создание аккаунта для них будет пропущено (Если аккаунт был деактивирован, он будет восстановлен)'
                },
                isStaffEmpty(staffData) {
                    return !(staffData.last_name || staffData.first_name || staffData.second_name || staffData.emp_number || staffData.email || staffData.insurance_number)
                },
                removeEmptyStaff() {
                    this.formData.staff = this.formData.staff.filter(sD => !this.isStaffEmpty(sD))
                },
                removeDublicatedStaff() {
                    this.formData.staff = this.formData.staff.filter((sD, i) => sD.emp_number ? this.formData.staff.findIndex(sDD => sDD.emp_number === sD.emp_number) === i : true)
                },
                checkStaffEmpNumbers() {
                    this.formData.staff.forEach((sD, i) => {
                        if (!sD.emp_number.match(this.staffRegExp.emp_number))
                            this.alerts.staff.error = 'Табельный номер может состоять только из 6 цифр'
                    });

                    return !!this.alerts.staff.error
                },
                checkErrorsForStaff() {
                    let errorAlert = this.alerts.form.error

                    this.formData.staff.forEach((sD, i) => {
                        let staffErrors = []
                        if (sD.last_name && sD.first_name && sD.second_name && sD.emp_number && sD.email && sD.insurance_number) {
                            if (!sD.last_name.match(this.staffRegExp.last_name)) staffErrors.push('Фамилия может содержать только буквы')
                            if (!sD.first_name.match(this.staffRegExp.first_name)) staffErrors.push('Имя может содержать только буквы')
                            if (!sD.second_name.match(this.staffRegExp.second_name)) staffErrors.push('Отчество может содержать только буквы')
                            if (!sD.emp_number.match(this.staffRegExp.emp_number)) staffErrors.push('Табельный номер может состоять только из 6 цифр')
                            if (!sD.email.match(this.staffRegExp.email)) staffErrors.push('Email должен быть валидным адресом электронной почты')
                            if (!sD.insurance_number.match(this.staffRegExp.insurance_number)) staffErrors.push('СНИЛС должен быть в формате 000-000-000 00')
                        } else staffErrors.push(`Данные о сотруднике указаны не полностью`)

                        if (staffErrors.length) errorAlert.push({
                            title: `Данные о ${i + 1} сотруднике заполнены неверно`,
                            errors: staffErrors,
                        })
                    });

                    return !!errorAlert.length
                },
                clearStaffInfoAlert() { this.alerts.staff.info = '' },
                clearStaffWarnAlert() { this.alerts.staff.warn = '' },
                clearStaffErrorAlert() { this.alerts.staff.error = '' },
                clearStaffAlerts() {
                    this.clearStaffInfoAlert()
                    this.clearStaffWarnAlert()
                    this.clearStaffErrorAlert()
                },
                clearStaff() {
                    this.clearStaffAlerts()
                    this.formData.staff = []
                    this.nextStaffUID = 0
                },
                async loadStaff() {
                    this.clearAllAlerts()

                    this.removeEmptyStaff()
                    this.removeDublicatedStaff()
                    if (!this.formData.organization_id) return this.alerts.staff.warn = 'Для подстановки необходимо указать организацию'

                    let emp_numbers_query = this.formData.staff.map(i => i.emp_number).filter(i => !!i).join(',')
                    if (!this.formData.staff.length || !emp_numbers_query) return this.alerts.staff.warn = 'Для подстановки необходимо указать Табельные номера сотрудников'

                    if (this.checkStaffEmpNumbers()) return

                    try {
                        this.staffTableBlocked = true

                        let response = (await axios.get(`{{ route('api.gaz.staff.index') }}?emp_numbers=${emp_numbers_query}&organization_id=${this.formData.organization_id}`)).data.data

                        if (this.formData.staff.length !== response.length)
                            this.alerts.staff.warn = 'Данные были загружены не для всех сотрудников. Некоторые табельные номера не были найдены'

                            this.formData.staff.forEach((sData, staffIndex) => {
                            let i = response.findIndex(item => item.emp_number === sData.emp_number)

                            if (i !== -1) this.formData.staff[staffIndex] = { ...sData, ...response[i] }
                            else this.formData.staff[staffIndex] = { emp_number: sData.emp_number }
                        })
                    } catch (e) {
                        this.alerts.staff.error = e?.response?.data?.message || 'Произошла ошибка во время запроса к серверу'
                        console.log(e)
                    } finally {
                        this.checkInfoForStaff()
                        this.staffTableBlocked = false
                    }
                },
                clearFormInfoAlerts() { this.alerts.form.info = [] },
                clearFormWarnAlerts() { this.alerts.form.warn = [] },
                clearFormErrorAlert() { this.alerts.form.error = [] },
                clearFormAlerts() {
                    this.clearFormInfoAlerts()
                    this.clearFormWarnAlerts()
                    this.clearFormErrorAlert()
                },
                checkFormErrors() {
                    let errors = this.alerts.form.error

                    if (!this.formData.staff.length) errors.push({ title: 'Список сотрудников должен содержать хотя бы одну запись' })
                    if (!this.formData.type_id) errors.push({ title: 'Тип заявки не указан' })
                    if (!this.formData.city_id) errors.push({ title: 'Город не указана' })
                    if (!this.formData.organization_id) errors.push({ title: 'Организация не указана' })

                    if (this.checkErrorsForStaff().length) return true

                    return !!errors.length
                },
                async submitForm() {
                    this.removeEmptyStaff()
                    this.removeDublicatedStaff()

                    this.clearAllErrors()
                    if (this.checkFormErrors()) return
                    this.clearAllAlerts()

                    try {
                        this.formSubmiting = true
                        let response = (await axios.post('{{ route('api.reqsys.req.store') }}', this.formData)).data

                        window.location.href = `{{ route('req.index') }}/${response}`
                    } catch (e) {
                        let errors = e?.response?.data?.errors
                        errors && this.setFormErrorsFromResponse(errors)

                        console.log(e)
                    } finally {
                        this.formSubmiting = false
                    }
                },
                setFormErrorsFromResponse(errors) {
                    let staffErrors = []

                    for (let e in errors) {
                        if (errors.hasOwnProperty(e)) {
                            if (!e.startsWith('staff') || e === 'staff') this.alerts.form.error.push({ title: errors[e].join(', ') })
                            else {
                                let staffIndex = e.split('.')[1]

                                if (!staffErrors[+staffIndex]) staffErrors[+staffIndex] = []
                                staffErrors[+staffIndex].push(errors[e].join(', '))
                            }
                        }
                    }

                    staffErrors.forEach((sE, i) => this.alerts.form.error.push({
                        title: `Сотрудник ${i + 1}`,
                        errors: sE,
                    }))
                },
                clearOrganizationsInfoAlerts() { this.alerts.organizations.info = '' },
                clearOrganizationsWarnAlerts() { this.alerts.organizations.warn = '' },
                clearOrganizationsErrorAlert() { this.alerts.organizations.error = '' },
                clearOrganizationsAlerts() {
                    this.clearOrganizationsInfoAlerts()
                    this.clearOrganizationsWarnAlerts()
                    this.clearOrganizationsErrorAlert()
                },
                async loadOrganizations(city_id) {
                    this.clearOrganizationsAlerts()
                    this.formData.organization_id = null
                    this.organizationsLoading = true

                    try {
                        let response = (await axios.get(`{{ route('api.gaz.organization.index') }}?city_id=${city_id}`)).data.data

                        this.organizations = response
                    } catch (e) {
                        this.alerts.organizations.error = e?.response?.data?.message || 'Произошла ошибка во время запроса к серверу'
                        console.log(e)
                    } finally {
                        this.organizationsLoading = false
                    }
                },
                clearAllErrors() {
                    this.clearOrganizationsErrorAlert()
                    this.clearStaffErrorAlert()
                    this.clearFormErrorAlert()
                },
                clearAllAlerts() {
                    this.clearOrganizationsAlerts()
                    this.clearStaffAlerts()
                    this.clearFormAlerts()
                },
            },
        }).mount('#req-form')
    </script>
@endsection
