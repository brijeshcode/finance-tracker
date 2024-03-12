<template>
    <div v-show="message">
        <p class="text-xs text-red-600">
            {{ message }}
        </p>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['message']
    })
</script>
