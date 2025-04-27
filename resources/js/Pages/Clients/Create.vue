<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    phone: '',
});

function submit() {
    form.post('/clients');
}
</script>

<template>
    <div>
        <h1>Register New Client</h1>
        <form @submit.prevent="submit">
            <input v-model="form.name" placeholder="Name" />
            <input v-model="form.email" placeholder="Email" />
            <input v-model="form.phone" placeholder="Phone" />
            <button type="submit">Register</button>
        </form>
    </div>
</template>
