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
                :editable="editable"
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
        editable() {
            return this.field.editable || false
        },
        color() {
            return this.field.color || `rgb(30, 136, 229)`
        },
        fieldId() {
            var id = this.field.name + '-pdp'
            return id
        },
        minDate() {
            var minDate = this.calculateMoment(this.field.min, 'min');
            return minDate.format('jYYYY/jM/jD')
        },
        maxDate() {
            var moment = this.calculateMoment(this.field.max, 'max');
            return moment.format('jYYYY/jM/jD')
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
            if(jMoment(value, 'jYYYY/jMM/jDD').isValid()) {
                m = jMoment(value).format('jYYYY-jMM-jDD')
            }
            else
            if(moment(value, 'YYYY-MM-DD', true).isValid())
            {
                m = jMoment(value)
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
</style>
