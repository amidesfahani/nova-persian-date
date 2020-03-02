<template>
    <span>{{ persianDate }}</span>
</template>

<script>
import jMoment from "moment-jalaali"

export default {
    props: ['resourceName', 'field'],
    computed: {
        persianDate() {
            if(this.field.value) {
                return jMoment(this.field.value).format(this.format)
            }
        },
        format() {
            if(this.field.formats && this.field.formats.IndexField)
            {
                return this.field.formats.IndexField
            }
            return this.field.format || 'jYYYY/jMM/jDD HH:mm:ss'
        }
    },
}
</script>
