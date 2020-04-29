<template>
    <table class="table w-full" cellspacing="0" cellpadding="0">
        <thead>
            <tr>
                <th class="w-16">

                </th>
                <th class="text-left">
                    Name
                </th>
                <th class="text-center">
                    Last Modified
                </th>
                <th class="text-left">
                    Permissions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(file, index) in files" :key="index">
                <td class="text-center">
                    <input type="checkbox" class="checkbox">
                </td>
                <td>
                    <a href="#" v-if="file.type === 'dir'" class="font-semibold text-90 no-underline">
                        {{ file.name }}
                    </a>
                    <span v-else class="text-90">{{ file.name }}</span>
                </td>
                <td class="text-center">{{ file.lastModified }}</td>
                <td>{{ file.permissions }}</td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    props: [
        'files'
    ],
}
</script>
