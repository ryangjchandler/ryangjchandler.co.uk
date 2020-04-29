<template>
    <div class="flex items-center justify-between text-lg pr-6 py-4 border-b border-40">
        <div class="flex items-center">
            <div class="w-16 text-center">
                <input type="checkbox" class="checkbox">
            </div>
            <nav class="flex items-center">
                <span class="text-60 pl-3">/</span>
                <p v-for="(part, index) in parts" :key="part" class="flex items-center">
                    <a href="#" class="mx-4 text-base text-90">{{ part }}</a>
                    <span class="text-60" v-show="index < parts.length - 1">/</span>
                </p>
            </nav>
        </div>
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
