<script setup lang="ts">
import axios from 'axios';
import {reactive, ref} from 'vue';

interface PingPayload {
    uuid: string;
    battery_percentage: number;
}

const form = ref<PingPayload>({
    uuid: '',
    battery_percentage: 100,
});

const isSubmitting = ref(false);
const statusMessage = ref<string | null>(null);
const errorMessage = ref<string | null>(null);

const submit = async () => {
    isSubmitting.value = true;
    statusMessage.value = null;
    errorMessage.value = null;

    await axios.post('/api/ping', form.value).then(() => {
        statusMessage.value = 'Ping stored successfully.';
        form.value.uuid = '';
        form.value.battery_percentage = 100;
    }).catch((error) => {
        errorMessage.value = 'Unable to send ping. Please try again.';
        console.error(error);
    }).finally(() => {
        isSubmitting.value = false;

    })
};
</script>

<template>
    <main class="min-h-screen bg-gray-950 text-white flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-lg p-6 shadow-xl">
            <h1 class="text-2xl font-semibold mb-4">Send Ping</h1>
            <form class="space-y-4" @submit.prevent="submit">
                <label class="block">
                    <span class="text-sm text-gray-300">UUID</span>
                    <input
                        v-model="form.uuid"
                        type="text"
                        required
                        class="mt-1 w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-400 focus:outline-none"
                        placeholder="00000000-0000-0000-0000-000000000000"
                    />
                </label>
                <label class="block">
                    <span class="text-sm text-gray-300">Battery Percentage</span>
                    <input
                        v-model.number="form.battery_percentage"
                        type="number"
                        min="0"
                        max="100"
                        required
                        class="mt-1 w-full rounded-md border border-gray-700 bg-gray-800 px-3 py-2 text-white focus:border-indigo-400 focus:outline-none"
                    />
                </label>
                <button
                    type="submit"
                    :disabled="isSubmitting"
                    class="w-full rounded-md bg-indigo-500 py-2 font-medium text-white hover:bg-indigo-400 disabled:opacity-50"
                >
                    {{ isSubmitting ? 'Sending…' : 'Send Ping' }}
                </button>
            </form>
            <p v-if="statusMessage" class="mt-4 text-green-400 text-sm">{{ statusMessage }}</p>
            <p v-if="errorMessage" class="mt-2 text-red-400 text-sm">{{ errorMessage }}</p>
        </div>
    </main>
</template>
