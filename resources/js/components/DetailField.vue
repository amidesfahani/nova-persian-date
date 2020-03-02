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
                let date = jMoment(this.field.value).format(this.format);
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
            return this.field.format || 'jYYYY/jMM/jDD HH:mm:ss'
        }
    },
}
</script>

<style>
.ltr-text {
    display: inline-block;
    direction: ltr;
}
</style>
