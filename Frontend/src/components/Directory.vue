<template>

    <Card v-if="loading">
        <template #content>
            <p>Loading...</p>
        </template>
    </Card>
    <Card v-else-if="needsPassword && !accessGranted">
        <template #content>
            <div class="flex flex-col gap-3">
                <p>Password is needed to access this resource</p>
                <div class="flex flex-row gap-3">
                    <Password v-model="password" :feedback="false"/>
                    <Button label="Access" @click="reloadDirectory"/>
                </div>
            </div>
        </template>
    </Card>
    <Card v-else="accessGranted">
        <template #content>
            <b v-if="!files.length">This directory is empty</b>
            <div v-else class="flex flex-col gap-3">
                <div v-for="file in files" :key="file.file" class="flex flex-row justify-between gap-3">
                    <div class="flex flex-col gap-0">
                        <span>{{ file.file }}</span>
                        <small class="opacity-50 font-bold">{{ prettySize(file.size) }}</small>
                    </div>
                    <Button @click="download(file)" icon="pi pi-download" />
                </div>
            </div>
        </template>
    </Card>

</template>


<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { apiFetch, apiUrl } from '../plugins/api';
import { Button, Card, Password } from 'primevue';

const router = useRouter();
const uuid = router.currentRoute.value.params.uuid as string;

type File = {
    file: string,
    size: number
}

const loading = ref(false);
const needsPassword = ref(false);
const password = ref<string|null>(null);
const accessGranted = ref(false);

const files = ref<File[]>([]);

const kilobyte = 1024;
const megabyte = 1024 * kilobyte;
const gigabyte = 1024 * megabyte;

const prettySize = (bytes: number) => {
    if (bytes >= gigabyte)
        return (bytes/gigabyte).toFixed(2) + " Go"
    else if (bytes >= megabyte)
        return (bytes/megabyte).toFixed(2) + " Mo"
    else if (bytes >= kilobyte)
        return (bytes/kilobyte).toFixed(2) + " ko"

    return bytes + " b"
}

const reloadDirectory = async () => {
    let response = null;
    try {
        loading.value = true;
        const params: { password?: string } = {};
        if(password.value)
            params.password = password.value

        const requestParams = Object.keys(params).length 
            ? {params}
            : undefined
        ;

        response = await apiFetch(`/${uuid}`, requestParams);
    }
    catch (error) {
        if (error.message === 'unauthorized') {
            needsPassword.value = true;
            password.value = null;
            return;
        }
        console.error(error);
        console.info(error);
    }
    finally {
        loading.value = false;
    }

    files.value = response
    accessGranted.value = true;
}

const download = (file: File) => {
    let params = `?file=${file.file}`;
    if (password.value)
        params += "&password=" + password.value

    let url = apiUrl(`/${uuid}/download${params}`);
    window.open(url);
}


onMounted(reloadDirectory)

</script>