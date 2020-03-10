<template>
    <span>{{ persianDate }}</span>
</template>

<script>
import jMoment from "moment-jalaali"
import fa from "moment/src/locale/fa";
jMoment.locale("fa", fa);
jMoment.loadPersian();

export default {
    props: ['resourceName', 'field'],
    computed: {
        persianDate() {
            if(this.field.value) {
                var d = jMoment(this.field.value)
                if(this.field.humanize)
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
