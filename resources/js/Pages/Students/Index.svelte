<script>
    import { Link, useForm, page } from "@inertiajs/svelte";

    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.svelte";
    import AlertComponent from "@/Components/AlertComponent.svelte";

    export let students;

    let deleteForm = useForm();

    const handleDelete = (student_id) => {
        if (confirm("Are you sure you want to delete this student?")) {
            $deleteForm.delete(route("students.destroy", student_id));
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
                            A list of all the Students.
                        </p>
                    </div>

                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link
                            href={route("students.create")}
                            as="button"
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                        >
                            Add Student
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
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Email
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Phone Number
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Class
                                            </th>
                                            <th
                                                scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Section
                                            </th>
                                            <th
                                                scope="col"
                                                class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                            />
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="divide-y divide-gray-200 bg-white"
                                    >
                                        {#each students.data as student}
                                            <tr>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {student.id}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {student.name}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {student.email}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {student.phone_number}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {student.class.name}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {student.section.name}
                                                </td>
                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                                >
                                                    <Link
                                                        href={route(
                                                            "students.edit",
                                                            student.id
                                                        )}
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Edit
                                                    </Link>

                                                    <button
                                                        on:click={() =>
                                                            handleDelete(
                                                                student.id
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
                        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                            <div class="max-w-none mx-auto">
                                <div
                                    class="bg-white overflow-hidden shadow sm:rounded-lg"
                                >
                                    <div
                                        class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
                                    >
                                        <div
                                            class="flex-1 flex justify-between sm:hidden"
                                        />
                                        <div
                                            class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                                        >
                                            <div>
                                                <p
                                                    class="text-sm text-gray-700"
                                                >
                                                    Showing
                                                    <!-- space -->
                                                    <span class="font-medium"
                                                        >{students.meta
                                                            .from}</span
                                                    >
                                                    <!-- space -->
                                                    to
                                                    <!-- space -->
                                                    <span class="font-medium"
                                                        >{students.meta
                                                            .to}</span
                                                    >
                                                    <!-- space -->
                                                    of
                                                    <!-- space -->
                                                    <span class="font-medium"
                                                        >{students.meta
                                                            .total}</span
                                                    >
                                                    <!-- space -->
                                                    results
                                                </p>
                                            </div>
                                            <div>
                                                <nav
                                                    class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                                    aria-label="Pagination"
                                                >
                                                    {#each students.meta.links as link}
                                                        <Link
                                                            preserveScroll
                                                            as="button"
                                                            href={link.url}
                                                            disabled={link.active ||
                                                                !link.url}
                                                            class="{link.active
                                                                ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                                                                : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'}  relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                                        >
                                                            {@html link.label}
                                                        </Link>
                                                    {/each}
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
