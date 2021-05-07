<template>
    <panel-item :field="fieldPersianDate">
        <template slot="value">
            <span v-if="field.humanize" class="inline-flex items-center">
                <span>{{persianDate()}}</span>
                <span class="ltr inline-flex items-center text-gray-600 text-xs ml-3">
                    <span><svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></span>
                    <span class="mr-1 ltr inline-block">{{moment.format(format)}}</span>
                </span>
            </span>
            <span v-else class="ltr inline-block">{{persianDate()}}</span>
        </template>
    </panel-item>
</template>

<script>
import jMoment from "moment-jalaali"

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    computed: {
        fieldPersianDate() {
            if(this.field.value)
            {
                this.field.value = this.persianDate()
                // let date = this.persianDate();
                // if (this.field.humanize)
                // {
                //     this.field.value = `<span class="">${date}</span>`;
                // }
                // else
                // {
                //     this.field.value = `<span class="ltr inline-block">${date}</span>`;
                // }
                this.field.asHtml = true;
            }
            return this.field
        },
        format() {
            if(this.field.formats && this.field.formats.DetailField)
            {
                return this.field.formats.DetailField
            }
            return this.field.format || this.createFormat
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
                    return 'jYYYY/jMM/jDD HH:mm';
                case 'full':
                    return 'jYYYY/jMM/jDD HH:mm:ss';
            }
            return 'jYYYY/jMM/jDD HH:mm';
        },
        moment() {
            return jMoment(this.field.value)
        }
    },
    methods: {
        canHumanize() {
            if (this.type == 'time' || this.type == 'year-month' || this.type == 'year' || this.type == 'month')
            {
                return false
            }
            return true
        },
        persianDate() {
            if(this.field.value) {
                // var d = jMoment(this.field.value)
                var d = this.moment
                if(this.field.humanize && this.canHumanize())
                {
                    if(d.isBefore(jMoment()))
                    {
                        return d.fromNow()
                    }
                    else
                    {
                        return d.toNow()
                    }
                }
                return d.format(this.format)
            }
        }
    }
}
</script>

<style>
.ltr-text {
    display: inline-block !important;
    direction: ltr;
}
</style>
