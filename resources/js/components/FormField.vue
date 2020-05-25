<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">
            <div class="relative">
                <span @click="show=true" v-if="editable" class="absolute left-0 top-0 flex items-center h-full px-3 btn-primary" style="border-radius: .5rem 0 0 .5rem;">
                    <svg version="1.1" width="16px" height="16px" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg" fill="#f9f9f9"><path d="M436 160H12C5.4 160 0 154.6 0 148V112C0 85.5 21.5 64 48 64H96V12C96 5.4 101.4 0 108 0H148C154.6 0 160 5.4 160
    12V64H288V12C288 5.4 293.4 0 300 0H340C346.6 0 352 5.4 352 12V64H400C426.5 64 448 85.5 448 112V148C448 154.6
    442.6 160 436 160zM12 192H436C442.6 192 448 197.4 448 204V464C448 490.5 426.5 512 400 512H48C21.5 512 0 490.5 0
    464V204C0 197.4 5.4 192 12 192zM128 396C128 389.4 122.6 384 116 384H76C69.4 384 64 389.4 64 396V436C64 442.6 69.4
    448 76 448H116C122.6 448 128 442.6 128 436V396zM128 268C128 261.4 122.6 256 116 256H76C69.4 256 64 261.4 64
    268V308C64 314.6 69.4 320 76 320H116C122.6 320 128 314.6 128 308V268zM256 396C256 389.4 250.6 384 244
    384H204C197.4 384 192 389.4 192 396V436C192 442.6 197.4 448 204 448H244C250.6 448 256 442.6 256 436V396zM256
    268C256 261.4 250.6 256 244 256H204C197.4 256 192 261.4 192 268V308C192 314.6 197.4 320 204 320H244C250.6 320 256
    314.6 256 308V268zM384 396C384 389.4 378.6 384 372 384H332C325.4 384 320 389.4 320 396V436C320 442.6 325.4 448
    332 448H372C378.6 448 384 442.6 384 436V396zM384 268C384 261.4 378.6 256 372 256H332C325.4 256 320 261.4 320
    268V308C320 314.6 325.4 320 332 320H372C378.6 320 384 314.6 384 308V268z"></path></svg>
                </span>
                <input
                    type="text"
                    class="w-full form-control form-input form-input-bordered ltr-direction rtl-font-face"
                    :class="editable ? 'is-editable' : ''"
                    v-model="value"
                    :id="fieldId"
                    :placeholder="placeholder"
                />
                <date-picker
                    v-model="value"
                    :id="field.name"
                    :format="format"
                    :initial-value="persianDate"
                    class="rtl-direction rtl-font-face rtl-font-size"
                    :class="errorClasses"
                    :color="color"
                    :placeholder="placeholder"
                    :type="type"
                    :element="fieldId"
                    :min="minDate"
                    :max="maxDate"
                    :locale="locale"
                    :editable="editable"
                    :show="show"
                    @close="show=false"
                />
            </div>
        </template>
    </default-field>
</template>

<script>
import VuePersianDatetimePicker from 'vue-persian-datetime-picker'
import moment from 'moment'
import jMoment from "moment-jalaali"

import { FormField, HandlesValidationErrors } from 'laravel-nova'

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field', 'errorClasses'],
    
    data() {
        return {
            show: false
        }
    },

    computed: {
        locale() {
            return this.field.locale || 'fa,en'
        },
        format() {
            if(this.field.formats && this.field.formats.FormField)
            {
                return this.field.formats.FormField
            }
            return this.field.format || this.createFormat
        },
        persianDate() {
            if (!this.field.value) {
                return ''
            } else {
                return jMoment(this.field.value).format(this.format)
            }
        },
        placeholder() {
            return this.field.placeholder || jMoment().format(this.format)
        },
        altDateValue() {
            return this.value ? jMoment(this.value, this.format).format('YYYY-MM-DD HH:mm:ss') : ''
        },
        editable() {
            return this.field.editable || false
        },
        color() {
            return this.field.color || `rgb(30, 136, 229)`
        },
        fieldId() {
            // if (this.editable) return ''
            var id = this.field.name + '-pdp'
            return id
        },
        minDate() {
            if (!this.field.min) return ''
            var minDate = this.calculateMoment(this.field.min, 'min');
            return minDate.format('jYYYY/jM/jD')
        },
        maxDate() {
            if (!this.field.max) return ''
            var maxDate = this.calculateMoment(this.field.max, 'max');
            return maxDate.format('jYYYY/jM/jD')
        },
        type() {
            return this.field.type || 'datetime'
        },
        createFormat() {
            switch(this.type)
            {
                case 'date':
                    return 'jYYYY/jMM/jDD';
                case 'time':
                    return 'HH:mm';
                case 'year-month':
                    return 'jYYYY/jMM';
                case 'year':
                    return 'jYYYY';
                case 'month':
                    return 'jMM';
                case 'datetime':
                    return 'jYYYY/jMM/jDD HH:mm:ss';
            }
        }
    },

    methods: {
        calculateMoment(value, type) {
            var m = new jMoment();
            if (value == 'lastyear') {
                m.jYear(m.jYear() - 1)
            }
            else
            if (value == 'lastmonth') {
                m.jMonth(m.jMonth() - 1)
            }
            else
            if (value == 'lastweek') {
                m.jDate(m.jDate() - 7)
            }
            else
            if (value == 'lastday') {
                m.jDate(m.jDate() - 1)
            }
            else
            if (value == 'today') {
                if (type == 'max') {
                    m.endOf('day')
                } else {
                    m.startOf('day')
                }
            }
            else
            if (value == 'thisyear') {
                if (type == 'max') {
                    m.endOf('jyear')
                } else {
                    m.startOf('jyear')
                }
            }
            else
            if (value == 'thismonth') {
                if (type == 'max') {
                    m.endOf('jmonth')
                } else {
                    m.startOf('jmonth')
                }
            }
            else
            if (value == 'thisweek') {
                if (type == 'max') {
                    m.endOf('jweek')
                } else {
                    m.startOf('jweek')
                }
            }
            else
            if (value == 'nextyear') {
                m.jYear(m.jYear() + 1)
            }
            else
            if (value == 'nextmonth') {
                m.jMonth(m.jMonth() + 1)
            }
            else
            if (value == 'nextweek') {
                m.jDate(m.jDate() + 7)
            }
            else
            if (value == 'nextday') {
                m.jDate(m.jDate() + 1)
            }
            else
            if(value.indexOf('/') !== -1 && jMoment(value, 'jYYYY/jMM/jDD').isValid()) {
                m = jMoment(value, 'jYYYY/jMM/jDD')
            }
            else
            if(value.indexOf('-') !== -1 && jMoment(value, 'jYYYY-jMM-jDD').isValid()) {
                m = jMoment(value, 'jYYYY-jMM-jDD')
            }
            else
            if(value.indexOf('/') !== -1 && moment(value, 'YYYY/MM/DD', true).isValid())
            {
                m = moment(value, 'YYYY/MM/DD')
            }
            else
            if(value.indexOf('-') !== -1 && moment(value, 'YYYY-MM-DD', true).isValid())
            {
                m = moment(value, 'YYYY-MM-DD')
            }
            else
            {
                m = jMoment(value, 'jYYYY-jMM-jDD')
            }
            return m
        },
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.persianDate
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute, this.altDateValue || '')
        },

        /**
         * Update the field's internal value.
         */
        handleChange(value) {
            this.value = value
        },
    },
    components: {
        datePicker: VuePersianDatetimePicker
    }
}
</script>

<style scoped>
.ltr-direction {
    direction: ltr;
    text-align: left;
}
.rtl-direction {
    direction: rtl;
}
/* .rtl-font-face {
    font-family: 'IranSans' !important;
} */
.rtl-font-size {
    font-size: 12px;
}
input.is-editable {
    direction: ltr;
    text-align: left;
    padding-left: 3rem;
}
</style>
