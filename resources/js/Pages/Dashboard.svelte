<script context="module">
    export { default as layout } from "../Layouts/AuthenticatedLayout.svelte";
</script>

<svelte:head>
    <title>Dashboard</title>
</svelte:head>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">You're logged in!</div>
        </div>
    </div>
</div>
