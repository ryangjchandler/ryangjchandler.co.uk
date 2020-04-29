<template>
    <div class="flex items-center justify-between text-lg px-5 py-4 border-b border-40">
        <div class="flex items-center flex-1">
            <div class="flex items-center mr-4">
                <button class="btn btn-default btn-icon btn-primary mr-2" :disabled="previousPath === path" @click="$emit('back')">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                </button>
                <button class="btn btn-default btn-icon btn-primary" :disabled="nextPath === '/'" @click="$emit('forward')">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" fill-rule="evenodd"></path></svg>
                </button>
            </div>
            <nav class="flex items-center bg-white border rounded border-50 px-3 py-2 w-1/2">
                <span class="text-60">/</span>
                <p v-for="(part, index) in parts" :key="part" class="flex items-center">
                    <a href="#" class="mx-1 text-base text-90">{{ part }}</a>
                    <span class="text-60" v-show="index < parts.length - 1">/</span>
                </p>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    props: [
        'nextPath',
        'previousPath',
        'path'
    ],
    computed: {
        parts: function () {
            return this.path.split('/').filter(Boolean)
        }
    }
}
</script>
