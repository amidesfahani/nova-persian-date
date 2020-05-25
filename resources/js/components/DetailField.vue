<template>
    <panel-item :field="fieldPersianDate" />
</template>

<script>
import jMoment from "moment-jalaali"

export default {
    props: ['resource', 'resourceName', 'resourceId', 'field'],
    computed: {
        fieldPersianDate() {
            if(this.field.value)
            {
                // let date = jMoment(this.field.value).format(this.format);
                let date = this.persianDate();
                this.field.value = `<span class="ltr-text">${date}</span>`;
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
        },
        persianDate() {
            if(this.field.value) {
                var d = jMoment(this.field.value)
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
    display: inline-block;
    direction: ltr;
}
</style>
