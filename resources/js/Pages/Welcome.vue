<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen items-center justify-center bg-gradient-to-br from-blue-100 to-blue-300"
    >
        <div class="max-w-xl rounded-2xl bg-white p-8 text-center shadow-xl">
            <h1 class="mb-4 text-4xl font-bold text-blue-700">
                Welcome to Health Information System
            </h1>
            <p class="mb-6 text-gray-600">
                Manage clients, enroll them in health programs, and keep track
                of vital health information easily and securely.
            </p>

            <div class="flex justify-center space-x-4">
                <Link
                    href="/login"
                    class="rounded-full bg-blue-600 px-6 py-3 text-white transition hover:bg-blue-700"
                >
                    Login
                </Link>

                <Link
                    href="/register"
                    class="rounded-full bg-gray-300 px-6 py-3 text-gray-700 transition hover:bg-gray-400"
                >
                    Register
                </Link>
            </div>
        </div>
    </div>
</template>
