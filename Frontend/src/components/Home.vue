<template>

    <Card>
        <template #title>
            Hello There!
        </template>
        <template #content>
            <div class="flex flex-col gap-3 w-full">
                Look like frontend is working !
                <div class="flex flex-row w-full justify-around items-center">
                    <Button @click="decrement" icon="pi pi-minus"/>
                    {{ count }}
                    <Button @click="increment" icon="pi pi-plus"/>
                </div>
            </div>
        </template>
    </Card>

</template>

<script setup lang="ts">
import { ref } from 'vue';

const count = ref(0);

const increment = () => count.value = count.value+1
const decrement = () => count.value = count.value-1

</script>