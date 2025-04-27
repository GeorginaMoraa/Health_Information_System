<script setup>
import { useForm } from '@inertiajs/vue3';

// Form setup for registering a new program
const form = useForm({
    program_name: '',
    description: '',
});

function submit() {
    form.post('/programs'); // Post to the programs endpoint
}
</script>

<template>
    <div>
        <h1>Register New Program</h1>
        <form @submit.prevent="submit">
            <div>
                <label for="program_name">Program Name</label>
                <input
                    id="program_name"
                    v-model="form.program_name"
                    placeholder="Enter program name"
                    required
                />
            </div>

            <div>
                <label for="description">Description</label>
                <textarea
                    id="description"
                    v-model="form.description"
                    placeholder="Describe the program"
                    required
                ></textarea>
            </div>

            <div>
                <label for="start_date">Start Date</label>
                <input
                    id="start_date"
                    type="date"
                    v-model="form.start_date"
                    required
                />
            </div>

            <div>
                <label for="end_date">End Date</label>
                <input
                    id="end_date"
                    type="date"
                    v-model="form.end_date"
                    required
                />
            </div>

            <button type="submit">Register Program</button>
        </form>
    </div>
</template>
