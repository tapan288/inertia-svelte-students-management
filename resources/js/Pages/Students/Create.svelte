<script>
    import axios from "axios";
    import { useForm } from "@inertiajs/svelte";

    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.svelte";

    let sections;

    let form = useForm({
        name: null,
        email: null,
        phone_number: null,
        class_id: null,
        section_id: null,
    });

    function submit() {
        $form.post(route("students.store"));
    }

    const getSections = (class_id) => {
        if (class_id) {
            axios
                .get(route("sections.index"), {
                    params: {
                        class_id: class_id,
                    },
                })
                .then((response) => {
                    sections = response.data.data;
                });
        } else {
            sections = [];
        }
    };

    $: getSections($form.class_id);

    export let classes;
</script>

<AuthenticatedLayout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
            <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                <form
                    action="#"
                    method="POST"
                    on:submit|preventDefault={submit}
                >
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                            <div>
                                <h3
                                    class="text-lg leading-6 font-medium text-gray-900"
                                >
                                    Student Information
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Use this form to create a new student.
                                </p>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label
                                        for="name"
                                        class="block text-sm font-medium text-gray-700"
                                        >Name</label
                                    >
                                    <input
                                        type="text"
                                        bind:value={$form.name}
                                        id="name"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    />
                                    {#if $form.errors.name}
                                        <div class="text-red-500">
                                            {$form.errors.name}
                                        </div>
                                    {/if}
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label
                                        for="email"
                                        class="block text-sm font-medium text-gray-700"
                                        >Email Address</label
                                    >
                                    <input
                                        type="text"
                                        id="email"
                                        bind:value={$form.email}
                                        autocomplete="email"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    />
                                    {#if $form.errors.email}
                                        <div class="text-red-500">
                                            {$form.errors.email}
                                        </div>
                                    {/if}
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <label
                                        for="phone_number"
                                        class="block text-sm font-medium text-gray-700"
                                        >Phone Number</label
                                    >
                                    <input
                                        type="text"
                                        id="phone_number"
                                        bind:value={$form.phone_number}
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    />
                                    {#if $form.errors.phone_number}
                                        <div class="text-red-500">
                                            {$form.errors.phone_number}
                                        </div>
                                    {/if}
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label
                                        for="class_id"
                                        class="block text-sm font-medium text-gray-700"
                                        >Class</label
                                    >
                                    <select
                                        id="class_id"
                                        bind:value={$form.class_id}
                                        class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    >
                                        <option value="">Select a Class</option>
                                        {#each classes.data as singleClass}
                                            <option value={singleClass.id}>
                                                {singleClass.name}
                                            </option>
                                        {/each}
                                    </select>
                                    {#if $form.errors.class_id}
                                        <div class="text-red-500">
                                            {$form.errors.class_id}
                                        </div>
                                    {/if}
                                </div>

                                <div class="col-span-6 sm:col-span-3">
                                    <label
                                        for="section_id"
                                        class="block text-sm font-medium text-gray-700"
                                        >Section</label
                                    >
                                    <select
                                        id="section_id"
                                        bind:value={$form.section_id}
                                        class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    >
                                        <option value=""
                                            >Select a Section</option
                                        >
                                        {#each sections as section}
                                            <option value={section.id}>
                                                {section.name}
                                            </option>
                                        {/each}
                                    </select>
                                    {#if $form.errors.section_id}
                                        <div class="text-red-500">
                                            {$form.errors.section_id}
                                        </div>
                                    {/if}
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <a
                                href="#"
                                as="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Cancel
                            </a>
                            <button
                                type="submit"
                                class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
