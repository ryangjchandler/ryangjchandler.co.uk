<template>
    <div>
        <heading class="mb-6">Storage</heading>

        <card
            class="bg-white flex flex-col"
            style="min-height: 300px"
        >
            <Toolbar :path="currentPath" :previousPath="previousPath" :nextPath="nextPath" @back="goBack" @forward="goForward" />
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
            previousPath: '/',
            currentPath: '/',
            nextPath: '/',
            initialLoading: true,
            loading: false,
            files: {}
        }
    },
    created() {
        this.getFiles()
    },
    methods: {
        getFiles() {
            Nova.request().get(`/nova-vendor/nova-storage-manager/files?path=${this.currentPath}`)
                .then(response => {
                    this.files = response.data
                    this.initialLoading = false
                    this.loading = false
                })
        },
        requestNewFiles($event) {
            this.previousPath = this.currentPath
            this.currentPath = `/${$event}`
            this.getFiles()
        },
        goBack() {
            console.log('cool')
            this.nextPath = this.currentPath
            this.currentPath = this.previousPath
            this.previousPath = '/'
            this.getFiles()
        },
        goForward() {
            this.previousPath = this.currentPath
            this.currentPath = this.nextPath
            this.nextPath = '/'
            this.getFiles()
        }
    }
}
</script>

<style>
/* Scoped Styles */
</style>
