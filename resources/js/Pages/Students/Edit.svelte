<script>
    import axios from "axios";
    import { useForm, Link } from "@inertiajs/svelte";

    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.svelte";
    import InputError from "@/Components/InputError.svelte";

    export let classes, student;

    let sections = [];

    let form = useForm({
        name: student.data.name,
        email: student.data.email,
        phone_number: student.data.phone_number,
        class_id: student.data.class.id,
        section_id: student.data.section.id,
        avatar: student.data.avatar,
        _method: "PUT",
    });

    const submit = () => {
        $form.post(route("students.update", student.data.id));
    };

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
                                    Edit Student ({student.data.name})
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Use this form to update the student data.
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
                                    <InputError message={$form.errors.name} />
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
                                    <InputError message={$form.errors.email} />
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

                                <div class="col-span-6 sm:col-span-4">
                                    {#if student.data.avatar}
                                        <img
                                            class="mb-5"
                                            src={student.data.avatar}
                                            alt=""
                                            width="300px"
                                        />
                                    {/if}
                                    <label
                                        for="avatar"
                                        class="block text-sm font-medium text-gray-700"
                                        >Avatar</label
                                    >
                                    <input
                                        type="file"
                                        id="avatar"
                                        bind:files={$form.avatar}
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    />
                                    <InputError message={$form.errors.avatar} />
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
                                    <InputError
                                        message={$form.errors.class_id}
                                    />
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
                                            <option
                                                value={section.id}
                                                selected={section.id ==
                                                    student.data.section.id}
                                            >
                                                {section.name}
                                            </option>
                                        {/each}
                                    </select>
                                    <InputError
                                        message={$form.errors.section_id}
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <Link
                                href={route("students.index")}
                                as="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Cancel
                            </Link>
                            <button
                                type="submit"
                                class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
