<script setup>
import '@fortawesome/fontawesome-free/css/all.css';
import Pagination from '../Pagination.vue';
import { Link, router, useForm, usePage } from '@inertiajs/vue3';
import { computed, ref, watch } from "vue";

// Props from backend
defineProps({
    students: Object,
});

// Initialize search and pagination state
const searchTerm = ref(usePage().props.search ?? "");
const pageNumber = ref(1);

// Watch the search input to reset pagination
watch(searchTerm, () => {
    pageNumber.value = 1;
});

// Build the dynamic URL for student list
const studentsUrl = computed(() => {
    const url = new URL(route('Students.index'));

    url.searchParams.append('page', pageNumber.value);

    if (searchTerm.value) {
        url.searchParams.append('search', searchTerm.value);
    }

    return url.toString(); // Return as a string
});

// Watch URL changes and fetch updated data via Inertia
watch(
    () => studentsUrl.value,
    (newValue) => {
        router.visit(newValue, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }
);

// Delete functionality
const deleteForm = useForm({});
const deleteStudent = (id) => {
    if (confirm("Are you sure you want to delete this student?")) {
        deleteForm.delete(route('Students.destroy', id), {
            preserveScroll: true,
            onSuccess: () => {
                alert("Student deleted successfully!");
            },
            onError: () => {
                alert("Failed to delete the student. Please try again.");
            },
        });
    }
};
</script>

<template>
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
        <h2 class="text-2xl font-semibold mb-4 text-gray-700">Students List</h2>

        <!-- Search Bar -->
        <div class="mb-4 flex items-center gap-2">
            <input
                v-model="searchTerm"
                type="text"
                class="p-2 border border-gray-300 rounded w-full sm:w-1/3"
                placeholder="Search Students..."
            />
        </div>

        <!-- Add Student Button -->
        <div class="mb-4 flex justify-start">
            <Link
                :href="route('Students.create')"
                class="bg-green-500 text-white px-4 py-2 rounded shadow-md hover:bg-green-600"
            >
                <i class="fas fa-plus"></i> Add Student
            </Link>
        </div>

        <!-- Students Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 table-fixed">
                <thead>
                    <tr class="bg-gray-300 text-black">
                        <th class="p-3 border w-12">ID</th>
                        <th class="p-3 border w-32">Name</th>
                        <th class="p-3 border w-48">Email</th>
                        <th class="p-3 border w-24">Class</th>
                        <th class="p-3 border w-24">Section</th>
                        <th class="p-3 border w-36">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="student in students.data" :key="student.id" class="hover:bg-gray-100">
                        <td class="p-3 border text-center">{{ student.id }}</td>
                        <td class="p-3 border">{{ student.name }}</td>
                        <td class="p-3 border">{{ student.email }}</td>
                        <td class="p-3 border text-center">{{ student.class.name }}</td>
                        <td class="p-3 border text-center">{{ student.section.name }}</td>
                        <td class="p-3 border text-center flex gap-2 justify-center">
                            <!-- Edit Button -->
                            <Link
                                :href="route('Students.edit', student.id)"
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded flex items-center gap-1"
                            >
                                <i class="fas fa-edit"></i>
                            </Link>

                            <!-- Delete Button -->
                            <button
                                @click="deleteStudent(student.id)"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded flex items-center gap-1"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <Pagination :data="students" />
    </div>
</template>

<style scoped>
table {
    table-layout: fixed;
}
</style>
