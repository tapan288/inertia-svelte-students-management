<script>
    import { Link, useForm, page } from "@inertiajs/svelte";

    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.svelte";
    import AlertComponent from "@/Components/AlertComponent.svelte";

    export let roles;

    console.log(roles);

    let deleteForm = useForm();

    const handleDelete = (role_id) => {
        if (confirm("Are you sure you want to delete this student?")) {
            $deleteForm.delete(route("roles.destroy", role_id));
        }
    };
</script>

<AuthenticatedLayout>
    <div class="bg-gray-100 py-10">
        <div class="mx-auto max-w-7xl">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <h1 class="text-xl font-semibold text-gray-900">
                            Students
                        </h1>
                        <p class="mt-2 text-sm text-gray-700">
                            A list of all the Roles.
                        </p>
                    </div>

                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link
                            href={route("roles.create")}
                            as="button"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                        >
                            Add Role
                        </Link>
                    </div>
                </div>
                <div class="mt-8 flex flex-col">
                    <AlertComponent message={$page.props.flash.message} />
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div
                            class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                        >
                            <div
                                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                            >
                                <table
                                    class="min-w-full divide-y divide-gray-300"
                                >
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                ID
                                            </th>
                                            <th
                                                scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                Title
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="divide-y divide-gray-200 bg-white"
                                    >
                                        {#each roles.data as role}
                                            <tr>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {role.id}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {role.title}
                                                </td>

                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                                >
                                                    <Link
                                                        href={route(
                                                            "roles.edit",
                                                            role.id
                                                        )}
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Edit
                                                    </Link>

                                                    <button
                                                        on:click={() =>
                                                            handleDelete(
                                                                role.id
                                                            )}
                                                        class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        {/each}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- <Pagination data={students} /> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
