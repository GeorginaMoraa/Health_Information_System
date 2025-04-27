<template>
    <div class="p-6">
        <h1 class="mb-6 text-3xl font-bold text-gray-800">Search Clients</h1>

        <div class="mb-6 flex items-center space-x-2">
            <input
                v-model="search"
                @keyup.enter="searchClients"
                type="text"
                placeholder="Enter client name or email"
                class="flex-1 rounded-md border border-gray-300 p-3 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <button
                :disabled="loading || !search.trim()"
                @click="searchClients"
                class="rounded-md bg-blue-600 px-5 py-3 text-white hover:bg-blue-700 disabled:opacity-50"
            >
                <span v-if="!loading">Search</span>
                <span v-else>Loading...</span>
            </button>
        </div>

        <div v-if="error" class="mb-4 text-red-600">
            {{ error }}
        </div>

        <div v-if="results.length" class="space-y-4">
            <div
                v-for="client in results"
                :key="client.id"
                class="rounded-lg bg-gray-100 p-4 shadow-sm transition hover:shadow-md"
            >
                <h2 class="text-lg font-semibold">
                    {{ client.name }}
                </h2>
                <p class="text-sm text-gray-600">{{ client.email }}</p>
            </div>
        </div>

        <div v-else-if="searched && !loading" class="mt-6 text-gray-600">
            No clients found matching "{{ search }}".
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const search = ref('');
const results = ref([]);
const loading = ref(false);
const error = ref('');
const searched = ref(false);

const searchClients = async () => {
    if (!search.value.trim()) {
        error.value = 'Please enter a search term.';
        return;
    }

    loading.value = true;
    error.value = '';
    searched.value = true;

    try {
        const response = await axios.get(
            `/api/clients/${encodeURIComponent(search.value)}`,
        );
        if (response.data && response.data.client) {
            results.value = [response.data.client];
        } else {
            results.value = [];
        }
    } catch (err) {
        console.error(err);
        error.value = 'Something went wrong while searching. Please try again.';
        results.value = [];
    } finally {
        loading.value = false;
    }
};
</script>
