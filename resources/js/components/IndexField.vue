<template>
    <span v-if="field.value" class="whitespace-no-wrap" :class="{'block ltr': !field.humanize}">{{ persianDate }}</span>
    <span v-else>&mdash;</span>
</template>

<script>
import jMoment from "moment-jalaali"
//import fa from "moment/src/locale/fa";
//jMoment.locale("fa", fa);
// jMoment.loadPersian();

export default {
    props: ['resourceName', 'field'],
    computed: {
        persianDate() {
            if(this.field.value) {
                var d = jMoment(this.field.value)
                if(this.field.humanize && this.canHumanize())
                {
                    return d.fromNow()
                }
                return d.format(this.format)
            }
        },
        format() {
            if(this.field.formats && this.field.formats.IndexField)
            {
                return this.field.formats.IndexField
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
                    return 'jYYYY/jMM/jDD HH:mm:ss';
            }
        }
    },
    methods: {
        canHumanize() {
            if (this.type == 'time' || this.type == 'year-month' || this.type == 'year' || this.type == 'month')
            {
                return false
            }
            return true
        }
    }
}
</script>
