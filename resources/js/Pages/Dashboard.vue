<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-2xl font-bold leading-tight text-white sm:text-2xl">
                Health Information System Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Welcome Section -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="mb-2 text-lg font-semibold text-blue-600">
                            Welcome, Doctor!
                        </h3>
                        <p>
                            Manage your clients and health programs easily from
                            here.
                        </p>
                    </div>
                </div>

                <!-- Actions Section -->
                <div
                    class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
                >
                    <!-- Create Program -->
                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm transition hover:shadow-lg sm:rounded-lg"
                    >
                        <h4 class="text-md mb-2 font-bold text-blue-800">
                            Create Health Program
                        </h4>
                        <Link
                            href="/programs"
                            class="text-orange-600 hover:underline"
                        >
                            Go to Programs Management
                        </Link>
                    </div>

                    <!-- Register Client -->
                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm transition hover:shadow-lg sm:rounded-lg"
                    >
                        <h4 class="text-md mb-2 font-bold text-blue-800">
                            Register New Client
                        </h4>
                        <Link
                            href="/clients"
                            class="text-orange-600 hover:underline"
                        >
                            Go to Client Registration
                        </Link>
                    </div>

                    <!-- Enroll Client -->
                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm transition hover:shadow-lg sm:rounded-lg"
                    >
                        <h4 class="text-md mb-2 font-bold text-blue-800">
                            Enroll Client in Program(s)
                        </h4>
                        <Link
                            href="/enrollment"
                            class="text-orange-600 hover:underline"
                        >
                            Enroll Clients
                        </Link>
                    </div>

                    <!-- Search Client -->
                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm transition hover:shadow-lg sm:rounded-lg"
                    >
                        <h4 class="text-md mb-2 font-bold text-blue-800">
                            Search Clients
                        </h4>
                        <Link
                            href="/clients/search"
                            class="text-orange-600 hover:underline"
                        >
                            Search for a Client
                        </Link>
                    </div>

                    <!-- View Profile -->
                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm transition hover:shadow-lg sm:rounded-lg"
                    >
                        <h4 class="text-md mb-2 font-bold text-blue-800">
                            View Client Profiles
                        </h4>
                        <Link
                            href="/profile"
                            class="text-orange-600 hover:underline"
                        >
                            View Profiles
                        </Link>
                    </div>

                    <!-- API Access -->
                    <div
                        class="overflow-hidden bg-white p-6 shadow-sm transition hover:shadow-lg sm:rounded-lg"
                    >
                        <h4 class="text-md mb-2 font-bold text-blue-800">
                            API Access
                        </h4>
                        <p class="text-sm text-gray-600">
                            Expose client profiles securely via API.
                        </p>
                        <Link
                            href="/api/docs"
                            class="text-orange-600 hover:underline"
                        >
                            View API Documentation
                        </Link>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="mb-4 text-lg font-semibold text-blue-600">
                            Recent Activities
                        </h3>
                        <ul class="ml-5 list-disc space-y-2 text-gray-600">
                            <li>
                                New health program
                                <strong>"TB Awareness"</strong> created.
                            </li>
                            <li>
                                Client <strong>Jane Doe</strong> registered.
                            </li>
                            <li>
                                <strong>John Smith</strong> enrolled in "Malaria
                                Treatment Program".
                            </li>
                        </ul>
                        <div class="mt-4">
                            <Link
                                href="/activity"
                                class="text-orange-600 hover:underline"
                            >
                                View Full Activity Log
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
