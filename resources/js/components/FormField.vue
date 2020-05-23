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
            if(moment(this.field.min, 'YYYY-MM-DD', true).isValid())
            {
                alert(jMoment(this.field.min).format('jYYYY-jMM-jDD'))
                return this.field.min ? jMoment(this.field.min, this.format).format('jYYYY-jMM-jDD') : '';
            }
            return this.field.min ? jMoment(this.field.min,'jYYYY-jMM-jDD').format('jYYYY-jMM-jDD') : '';
        },
        type() {
            return this.field.type || 'datetime'
        },
        createFormat() {
            switch(this.type)
            {
                case 'datetime':
                    return 'jYYYY/jMM/jDD HH:mm:ss';
                case 'date':
                    return 'jYYYY/jMM/jDD';
                case 'time':
                    return 'HH:mm';
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
.rtl-font-face {
    font-family: 'IranSans' !important;
}
.rtl-font-size {
    font-size: 12px;
}
</style>
