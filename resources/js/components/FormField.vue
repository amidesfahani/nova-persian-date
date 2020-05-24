<template>
    <default-field :field="field" :errors="errors">
        <template slot="field">

            <input
                type="text"
                class="w-full form-control form-input form-input-bordered ltr-direction rtl-font-face"
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
            />

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

    props: ['resourceName', 'resourceId', 'field'],

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
            return jMoment().format(this.format)
        },
        altDateValue() {
            return this.value ? jMoment(this.value, this.format).format('YYYY-MM-DD HH:mm:ss') : ''
        },
        color() {
            return this.field.color || `rgb(30, 136, 229)`
        },
        fieldId() {
            var id = this.field.name + '-pdp'
            return id
        },
        minDate() {
            var minDate = new jMoment();
            if (this.field.min == 'lastyear') {
                minDate.jYear(minDate.jYear() - 1)
            }
            else
            if (this.field.min == 'lastmonth') {
                minDate.jMonth(minDate.jMonth() - 1)
            }
            else
            if (this.field.min == 'lastweek') {
                minDate.jDate(minDate.jDate() - 7)
            }
            else
            if (this.field.min == 'lastday') {
                minDate.jDate(minDate.jDate() - 1)
            }
            else
            if(jMoment(this.field.min, 'jYYYY/jMM/jDD').isValid()) {
                minDate = jMoment(this.field.min).format('jYYYY-jMM-jDD')
            }
            else
            if(moment(this.field.min, 'YYYY-MM-DD', true).isValid())
            {
                minDate = jMoment(this.field.min).format('jYYYY-jMM-jDD')
            }
            else
            {
                minDate = jMoment(this.field.min, 'jYYYY-jMM-jDD').format('jYYYY-jMM-jDD')
            }
            return minDate.format('jYYYY/jM/jD')
        },
        maxDate() {
            var maxDate = new jMoment();
            if (this.field.max == 'nextyear') {
                maxDate.jYear(maxDate.jYear() + 1)
            }
            else
            if (this.field.max == 'nextmonth') {
                maxDate.jMonth(maxDate.jMonth() + 1)
            }
            else
            if (this.field.max == 'nextweek') {
                maxDate.jDate(maxDate.jDate() + 7)
            }
            else
            if (this.field.max == 'nextday') {
                maxDate.jDate(maxDate.jDate() + 1)
            }
            else
            if(jMoment(this.field.max, 'jYYYY/jMM/jDD').isValid()) {
                maxDate = jMoment(this.field.max).format('jYYYY-jMM-jDD')
            }
            else
            if(moment(this.field.max, 'YYYY-MM-DD', true).isValid())
            {
                maxDate = jMoment(this.field.max).format('jYYYY-jMM-jDD')
            }
            else
            {
                maxDate = jMoment(this.field.max, 'jYYYY-jMM-jDD').format('jYYYY-jMM-jDD')
            }
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
</style>
