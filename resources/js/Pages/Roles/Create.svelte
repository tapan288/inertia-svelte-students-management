<script>
    import axios from "axios";
    import { useForm, page, Link } from "@inertiajs/svelte";

    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.svelte";
    import InputError from "@/Components/InputError.svelte";

    let form = useForm({
        title: null,
    });

    function submit() {
        $form.post(route("roles.store"));
    }
</script>

<svelte:head>
    <title>Create Role | {$page.props.appName}</title>
</svelte:head>

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
                                    Role Information
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Use this form to create a new Role.
                                </p>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label
                                        for="title"
                                        class="block text-sm font-medium text-gray-700"
                                        >Title</label
                                    >
                                    <input
                                        type="text"
                                        bind:value={$form.title}
                                        id="title"
                                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                    />
                                    <InputError message={$form.errors.title} />
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <Link
                                href={route("roles.index")}
                                as="button"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Cancel
                            </Link>
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
