<template>
    <div>
        <heading class="mb-6">Storage</heading>

        <card
            class="bg-white flex flex-col"
            style="min-height: 300px"
        >
            <Toolbar :path="currentPath" />
            <Browser :files="files" @dir-change="requestNewFiles" />
        </card>
    </div>
</template>

<script>
import Toolbar from './Toolbar'
import Browser from './Browser'

export default {
    components: {
        Toolbar,
        Browser,
    },
    data() {
        return {
            currentPath: '/',
            initialLoading: true,
            loading: false,
            files: {}
        }
    },
    created() {
        this.getFiles()
    },
    methods: {
        getFiles(path = '/') {
            Nova.request().get(`/nova-vendor/nova-storage-manager/files?path=${path}`)
                .then(response => {
                    this.files = response.data
                    this.initialLoading = false
                    this.loading = false
                })
        },
        requestNewFiles($event) {
            this.currentPath = `/${$event}`
            this.getFiles(`/${$event}`)
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
