<template>
    <div class="flex h-screen">
        <!-- Side Navigation Bar -->
        <div class="w-64 bg-gray-800 p-6 text-white">
            <h2 class="mb-8 text-2xl font-bold">Admin Dashboard</h2>
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="/dashboard" class="hover:text-blue-400"
                            >Dashboard</a
                        >
                    </li>
                    <li>
                        <a href="/enrollment" class="hover:text-blue-400"
                            >Enrollment</a
                        >
                    </li>
                    <li>
                        <a href="/programs" class="hover:text-blue-400"
                            >Programs</a
                        >
                    </li>
                    <li>
                        <a href="/profile" class="hover:text-blue-400"
                            >Profile</a
                        >
                    </li>
                    <li>
                        <a href="/api/docs" class="hover:text-blue-400"
                            >API Access</a
                        >
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 p-6">
            <h1 class="mb-6 text-2xl font-bold text-blue-600">
                Enroll Client to Program
            </h1>

            <!-- Form for Enrolling Client -->
            <form @submit.prevent="enrollClient" class="space-y-6">
                <!-- Client Selection -->
                <div>
                    <label class="mb-1 block font-semibold text-gray-700"
                        >Select Client:</label
                    >
                    <select
                        v-model="clientId"
                        class="w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': clientId === '' }"
                        required
                    >
                        <option value="">Please select a client</option>
                        <option
                            v-for="client in clients"
                            :key="client.id"
                            :value="client.id"
                        >
                            {{ client.name }}
                        </option>
                    </select>
                    <p v-if="clientId === ''" class="mt-1 text-sm text-red-500">
                        Client selection is required.
                    </p>
                </div>

                <!-- Program Dropdown -->
                <div>
                    <label class="mb-1 block font-semibold text-gray-700"
                        >Select Program:</label
                    >
                    <select
                        v-model="selectedProgram"
                        class="w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        :class="{ 'border-red-500': selectedProgram === '' }"
                        required
                    >
                        <option value="">Please select a program</option>
                        <option value="malaria">Malaria</option>
                        <option value="hiv">HIV</option>
                        <option value="tb">TB</option>
                    </select>
                    <p
                        v-if="selectedProgram === ''"
                        class="mt-1 text-sm text-red-500"
                    >
                        Program selection is required.
                    </p>
                </div>

                <!-- Display Enrolled Clients -->
                <div v-if="enrolledClients.length > 0">
                    <h3 class="mt-6 text-lg font-semibold text-blue-600">
                        Clients Enrolled in
                        {{ selectedProgram.toUpperCase() }} Program
                    </h3>
                    <ul class="mt-2 list-disc pl-5">
                        <li v-for="client in enrolledClients" :key="client.id">
                            {{ client.first_name }} {{ client.last_name }}
                        </li>
                    </ul>
                </div>

                <!-- Submit Button -->
                <div>
                    <button
                        type="submit"
                        class="w-full rounded-md bg-green-600 py-3 text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                        :disabled="isSubmitting"
                    >
                        <span v-if="isSubmitting">Submitting...</span>
                        <span v-else>Enroll</span>
                    </button>
                </div>
            </form>

            <!-- Success/Error Message -->
            <div v-if="statusMessage" class="mt-6 text-center">
                <p :class="statusClass">{{ statusMessage }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

// Props to receive the list of clients and programs
defineProps({
    clients: Array,
    programs: Array,
});

const clientId = ref('');
const selectedProgram = ref('');
const enrolledClients = ref([]);
const isSubmitting = ref(false); // To manage form submission state
const statusMessage = ref(''); // Message to show after submission
const statusClass = ref(''); // Class for message styling (success/error)

// Function to fetch enrolled clients based on selected program
const fetchEnrolledClients = async () => {
    // Simulate fetching enrolled clients from the server based on the selected program
    if (selectedProgram.value) {
        // Filter clients based on the selected program
        enrolledClients.value = clients.filter((client) =>
            client.programs.includes(selectedProgram.value),
        );
    }
};

// Enroll Client function to handle form submission
const enrollClient = async () => {
    if (!clientId.value || !selectedProgram.value) {
        return; // Prevent submission if validation fails
    }

    isSubmitting.value = true;
    statusMessage.value = ''; // Reset any previous status message

    try {
        // Simulate enrolling the client in the program (POST request)
        await router.post('/enrollment', {
            client_id: clientId.value,
            program_id: selectedProgram.value,
        });

        // Success
        statusMessage.value =
            'Client successfully enrolled in the selected program!';
        statusClass.value = 'text-green-500 font-semibold';

        // Clear selections after successful submission
        clientId.value = '';
        selectedProgram.value = '';
        fetchEnrolledClients(); // Refresh the enrolled clients list
    } catch (error) {
        // Error
        statusMessage.value =
            'An error occurred during enrollment. Please try again.';
        statusClass.value = 'text-red-500 font-semibold';
    } finally {
        isSubmitting.value = false; // Reset the submit state
    }
};

// Watch for changes in selected program to update the enrolled clients list
watch(selectedProgram, fetchEnrolledClients);
</script>

<style scoped>
/* Add custom styles or adjust existing ones for a better UI */
button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
}

/* Ensure sidebar and main content are responsive */
@media (max-width: 768px) {
    .w-64 {
        width: 16rem; /* Reduce width on small screens */
    }
}
</style>
