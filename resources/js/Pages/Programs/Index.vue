<template>
    <div class="flex">
        <!-- Sidebar (60% Blue) -->
        <div class="w-64 bg-blue-800 p-6 text-white">
            <h2 class="mb-6 text-2xl font-bold">Health Information System</h2>
            <ul class="space-y-4">
                <li>
                    <Link href="/dashboard" class="block p-2 hover:bg-blue-700"
                        >Dashboard</Link
                    >
                </li>
                <li>
                    <Link href="/programs" class="block p-2 hover:bg-blue-700"
                        >Programs</Link
                    >
                </li>
                <li>
                    <Link href="/clients" class="block p-2 hover:bg-blue-700"
                        >Clients</Link
                    >
                </li>
                <li>
                    <Link href="/enrollment" class="block p-2 hover:bg-blue-700"
                        >Enrollment</Link
                    >
                </li>
                <li>
                    <Link href="/profile" class="block p-2 hover:bg-blue-700"
                        >Profile</Link
                    >
                </li>
                <li>
                    <Link href="/api/docs" class="block p-2 hover:bg-blue-700"
                        >API Access</Link
                    >
                </li>
            </ul>
        </div>

        <!-- Main Content (30% White with Blue accents) -->
        <div class="flex-1 bg-white p-6 text-gray-800">
            <!-- Programs List Section -->
            <h1 class="mb-6 text-2xl font-bold text-blue-600">Programs</h1>
            <div class="space-y-4">
                <div
                    v-for="program in programs"
                    :key="program.id"
                    class="rounded-md border border-gray-200 bg-white p-4 shadow-md transition-shadow hover:shadow-lg"
                >
                    <h2 class="text-xl font-semibold text-blue-500">
                        {{ program.name }}
                    </h2>
                    <p class="mt-2 text-gray-600">{{ program.description }}</p>
                    <button
                        @click="editProgram(program)"
                        class="mt-4 rounded bg-orange-400 px-2 py-2 text-white hover:bg-orange-300"
                    >
                        Edit Program
                    </button>
                    <br />
                    <button
                        @click="confirmDelete(program.id)"
                        class="mt-4 rounded bg-red-400 px-2 py-1 text-white hover:bg-red-300"
                    >
                        Delete Program
                    </button>
                    <br />
                    <Link
                        :href="`/enrollment/${program.id}`"
                        class="mt-4 rounded bg-blue-400 px-2 py-2 text-white hover:bg-blue-300"
                        >View Clients</Link
                    >
                </div>
            </div>

            <!-- Register/Edit Program Section -->
            <div
                class="mt-12 rounded-lg border border-gray-200 bg-white p-6 shadow-lg"
            >
                <h1 class="text-2xl font-bold text-blue-600">
                    {{ isEditMode ? 'Edit Program' : 'Register New Program' }}
                </h1>
                <form @submit.prevent="submit" class="mt-6 space-y-4">
                    <!-- Program Name Input -->
                    <div>
                        <label
                            for="program_name"
                            class="block text-sm font-semibold text-gray-700"
                            >Program Name</label
                        >
                        <input
                            id="program_name"
                            v-model="form.name"
                            type="text"
                            placeholder="Enter program name"
                            class="w-full rounded-md border border-gray-300 p-2"
                            :class="{ 'border-red-500': form.errors.name }"
                            required
                        />
                        <span
                            v-if="form.errors.name"
                            class="text-sm text-red-500"
                            >{{ form.errors.name }}</span
                        >
                    </div>

                    <!-- Description Input -->
                    <div>
                        <label
                            for="description"
                            class="block text-sm font-semibold text-gray-700"
                            >Description</label
                        >
                        <textarea
                            id="description"
                            v-model="form.description"
                            placeholder="Describe the program"
                            class="w-full rounded-md border border-gray-300 p-2"
                            :class="{
                                'border-red-500': form.errors.description,
                            }"
                            required
                        ></textarea>
                        <span
                            v-if="form.errors.description"
                            class="text-sm text-red-500"
                            >{{ form.errors.description }}</span
                        >
                    </div>

                    <!-- Submit Button (Orange Accent) -->
                    <div>
                        <button
                            type="submit"
                            class="w-full rounded-md bg-orange-500 py-2 text-white transition-colors hover:bg-orange-600"
                            :disabled="form.processing"
                        >
                            <span v-if="form.processing">Submitting...</span>
                            <span v-else>
                                {{
                                    isEditMode
                                        ? 'Update Program'
                                        : 'Register Program'
                                }}
                            </span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Success/Error Message -->
            <div v-if="form.success" class="mt-6 text-green-500">
                <p>{{ form.success }}</p>
            </div>
            <div v-if="form.error" class="mt-6 text-red-500">
                <p>{{ form.error }}</p>
            </div>
        </div>
    </div>

    <!-- Confirm Delete Modal -->
    <div
        v-if="showDeleteConfirm"
        class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75"
    >
        <div class="rounded-lg bg-white p-6 shadow-lg">
            <p class="text-lg font-semibold text-gray-800">
                Are you sure you want to delete this program?
            </p>
            <div class="mt-4 flex justify-end space-x-4">
                <button
                    @click="deleteProgram(programToDelete)"
                    class="rounded-md bg-red-500 px-4 py-2 text-white hover:bg-red-600"
                >
                    Yes, Delete
                </button>
                <button
                    @click="cancelDelete"
                    class="rounded-md bg-gray-300 px-4 py-2 text-gray-800 hover:bg-gray-400"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    programs: Array,
});

const isEditMode = ref(false); // to toggle between register and edit mode
const editingProgram = ref(null); // to store the program being edited
const showDeleteConfirm = ref(false); // toggle delete confirmation modal
const programToDelete = ref(null); // store the program to be deleted

// Form setup for registering and editing a program
const form = useForm({
    name: '',
    description: '',
    success: '',
    error: '',
    processing: false,
});

// Edit program method
function editProgram(program) {
    isEditMode.value = true;
    editingProgram.value = program;
    form.name = program.name;
    form.description = program.description;
}

// Submit function (for both register and update)
function submit() {
    form.processing = true;
    if (isEditMode.value) {
        form.put(`/programs/${editingProgram.value.id}`, {
            onSuccess: () => {
                form.success = 'Program updated successfully!';
                form.reset();
                isEditMode.value = false; // exit edit mode
            },
            onError: (errors) => {
                form.error = 'There was an error updating the program.';
                form.errors = errors; // Capture errors for validation feedback
            },
            finally: () => {
                form.processing = false;
            },
        });
    } else {
        form.post('/programs', {
            onSuccess: () => {
                form.success = 'Program registered successfully!';
                form.reset();
            },
            onError: (errors) => {
                form.error = 'There was an error registering the program.';
                form.errors = errors; // Capture errors for validation feedback
            },
            finally: () => {
                form.processing = false;
            },
        });
    }
}

// Confirm delete program
function confirmDelete(programId) {
    showDeleteConfirm.value = true;
    programToDelete.value = programId;
}

// Cancel delete
function cancelDelete() {
    showDeleteConfirm.value = false;
    programToDelete.value = null;
}

// Delete program method
function deleteProgram(programId) {
    showDeleteConfirm.value = false;
    // Add deletion logic here (e.g., make an API call)
    console.log('Program deleted:', programId);
}
</script>

<style scoped>
/* Add custom styles */
button:disabled {
    background-color: #d1d5db;
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .w-64 {
        width: 16rem;
    }
}
</style>
