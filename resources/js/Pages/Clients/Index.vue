<template>
    <div class="flex">
        <!-- Sidebar -->
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
        <div class="flex-1 p-8">
            <div class="mx-auto max-w-3xl rounded-md bg-blue-100 p-6 shadow-md">
                <h1 class="mb-6 text-center text-3xl font-bold">
                    Register New Client
                </h1>

                <!-- Form Section -->
                <form @submit.prevent="submit" class="space-y-4">
                    <!-- Name Input -->
                    <div>
                        <input
                            v-model="form.name"
                            type="text"
                            placeholder="Full Name"
                            class="w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': errors.name }"
                            aria-label="Client's full name"
                        />
                        <span v-if="errors.name" class="text-sm text-red-500">{{
                            errors.name
                        }}</span>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <input
                            v-model="form.email"
                            type="email"
                            placeholder="Email Address"
                            class="w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': errors.email }"
                            aria-label="Client's email address"
                        />
                        <span
                            v-if="errors.email"
                            class="text-sm text-red-500"
                            >{{ errors.email }}</span
                        >
                    </div>

                    <!-- Phone Input -->
                    <div>
                        <input
                            v-model="form.phone"
                            type="tel"
                            placeholder="Phone Number"
                            class="w-full rounded-md border p-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                            :class="{ 'border-red-500': errors.phone }"
                            aria-label="Client's phone number"
                        />
                        <span
                            v-if="errors.phone"
                            class="text-sm text-red-500"
                            >{{ errors.phone }}</span
                        >
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        :disabled="isSubmitting"
                        class="w-full rounded-md bg-blue-600 px-4 py-3 text-white hover:bg-blue-700 focus:outline-none disabled:bg-gray-400"
                    >
                        <span v-if="isSubmitting">Submitting...</span>
                        <span v-else>Register</span>
                    </button>
                </form>

                <!-- Success Message -->
                <div
                    v-if="successMessage"
                    class="mt-6 rounded-md bg-green-100 p-4 text-green-700 shadow-md"
                >
                    {{ successMessage }}
                </div>

                <!-- Error Message -->
                <div
                    v-if="errorMessage"
                    class="mt-6 rounded-md bg-red-100 p-4 text-red-700 shadow-md"
                >
                    {{ errorMessage }}
                </div>

                <!-- Clients List -->
                <div class="mt-8">
                    <h2 class="text-2xl font-bold">Registered Clients</h2>
                    <div class="mt-4 space-y-2">
                        <div
                            v-for="client in clients"
                            :key="client.id"
                            class="rounded-md bg-gray-100 p-4"
                        >
                            <a
                                :href="`/profile/${client.id}`"
                                class="text-blue-600 hover:underline"
                                >{{ client.name }}</a
                            >
                            <div class="text-sm text-gray-600">
                                {{ client.email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    clients: Array,
});

const emit = defineEmits(['add-client']);

const form = useForm({
    name: '',
    email: '',
    phone: '',
});

const isSubmitting = ref(false);
const successMessage = ref('');
const errorMessage = ref('');
const errors = ref({});

function submit() {
    isSubmitting.value = true;
    successMessage.value = '';
    errorMessage.value = '';

    form.post('/clients', {
        onSuccess: (response) => {
            successMessage.value = 'Client successfully registered!';
            form.reset();
            emit('add-client', response.client);
        },
        onError: (errors) => {
            errorMessage.value =
                'There was an error with your submission. Please try again.';
            errors.value = errors;
        },
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
}
</script>

<style scoped>
/* Sidebar Styling */
.sidebar {
    background-color: #1f2937;
    color: white;
}

/* Focus state for input fields */
input:focus {
    border-color: #4f80e0;
}

/* Button when disabled */
button:disabled {
    cursor: not-allowed;
}

/* Hover effects for sidebar links */
.sidebar a:hover {
    color: #60a5fa;
}
</style>
