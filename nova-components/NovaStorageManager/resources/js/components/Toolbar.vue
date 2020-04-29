<template>
    <div class="flex items-center justify-between text-lg px-6 py-4 border-b border-40">
        <nav class="flex items-center">
            <span class="text-60">/</span>
            <p v-for="(part, index) in parts" :key="part" class="flex items-center">
                <a href="#" class="mx-4 text-sm text-90">{{ part }}</a>
                <span class="text-60" v-show="index < parts.length - 1">/</span>
            </p>
        </nav>
    </div>
</template>

<script>
export default {
    props: [
        'path'
    ],
    computed: {
        parts: function () {
            return this.path.split('/').filter(Boolean)
        }
    }
}
</script>
