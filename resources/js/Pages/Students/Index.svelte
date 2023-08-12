<script>
    import axios from "axios";
    import { Link, useForm, page, router } from "@inertiajs/svelte";

    import {
        Button,
        Dropdown,
        DropdownItem,
        DropdownDivider,
        Chevron,
    } from "flowbite-svelte";

    import Pagination from "@/Components/Pagination.svelte";
    import AlertComponent from "@/Components/AlertComponent.svelte";
    import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.svelte";

    export let students, classes;

    let pageSize = "10",
        pageNumber = 1,
        sections = [],
        checked = [],
        searchTerm = "",
        class_id = "",
        section_id = "",
        selectPage = false,
        selectAll = false;

    let deleteForm = useForm();
    let massDestroyForm = useForm();

    const handleDelete = (student_id) => {
        if (confirm("Are you sure you want to delete this student?")) {
            $deleteForm.delete(route("students.destroy", student_id),{
                onSuccess: () => {
                    checked = checked.filter((id) => id != student_id);
                }
            });
        }
    };

    const deleteMultipleRecords = () => {
        if (confirm("Are you sure you want to delete these students?")) {
            $massDestroyForm.delete(
                route("students.massDestroy", { records: checked }),
                {
                    onSuccess: () => {
                        checked = [];
                    },
                }
            );
        }
    };

    const exportRecords = () => {
        window.open(route("students.export", { records: checked }));
    };

    const updatedStudentsUrl = (url) => {
        router.visit(url, {
            only: ["students"],
        });
    };

    const updatedSectionId = (section_id) => {
        if (section_id) {
            updatedStudentsUrl(studentsUrl + `&section_id=${section_id}`);
        }
    };

    const updatedClassId = (class_id) => {
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

    const updatedPageNumber = (page) => {
        pageNumber = page;
    };

    const updatedSelectPage = (selectPage) => {
        if (selectPage) {
            checked = students.data.map((student) => student.id);
        } else {
            checked = [];
            selectAll = false;
        }
    };

    const selectAllRecords = () => {
        selectAll = true;
        axios.get(studentsUrl + "&selectAll=" + selectAll).then((response) => {
            checked = response.data.data.map((item) => item.id);
        });
    };

    $: studentsUrl =
        `/students?pageSize=${pageSize}` +
        (pageNumber ? `&page=${pageNumber}` : "") +
        (searchTerm ? `&searchTerm=${searchTerm}` : "") +
        (class_id ? `&class_id=${class_id}` : "");

    $: updatedStudentsUrl(studentsUrl);
    $: updatedClassId(class_id);
    $: updatedSectionId(section_id);
    $: updatedSelectPage(selectPage);
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
                        {#if $page.props.can.student_create}
                            <Link
                                href={route("students.create")}
                                as="button"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                            >
                                Add Student
                            </Link>
                        {/if}
                    </div>
                </div>

                <div class="flex justify-between my-2">
                    <div class="flex">
                        <!-- pagination -->
                        <div>
                            <select
                                bind:value={pageSize}
                                id="per_page"
                                name="per_page"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            >
                                <option>10</option>
                                <option>20</option>
                                <option>30</option>
                            </select>
                        </div>

                        <!-- filter by class -->
                        <div class="ml-4">
                            <select
                                bind:value={class_id}
                                id="filter_by_class"
                                name="filter_by_class"
                                class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            >
                                <option value="">Select a Class</option>
                                {#each classes.data as item}
                                    <option value={item.id}>
                                        {item.name}
                                    </option>
                                {/each}
                            </select>
                        </div>

                        <!-- filter by section -->
                        {#if class_id}
                            <div class="ml-4">
                                <select
                                    bind:value={section_id}
                                    id="filter_by_section"
                                    name="filter_by_section"
                                    class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                >
                                    <option value="">Select a Section</option>
                                    {#each sections as item}
                                        <option value={item.id}>
                                            {item.name}
                                        </option>
                                    {/each}
                                </select>
                            </div>
                        {/if}

                        <!-- dropdown -->
                        {#if checked.length > 0}
                            <div class="ml-4 mt-2">
                                <Button size="sm"
                                    ><Chevron
                                        >With Checked ({checked.length})</Chevron
                                    ></Button
                                >
                                <Dropdown>
                                    <DropdownItem on:click={exportRecords}
                                        >Export</DropdownItem
                                    >
                                    <DropdownDivider />
                                    <DropdownItem
                                        on:click={deleteMultipleRecords}
                                        >Delete</DropdownItem
                                    >
                                </Dropdown>
                            </div>
                        {/if}
                    </div>

                    <!-- search -->
                    <div class="mt-2 flex items-center">
                        <input
                            bind:value={searchTerm}
                            type="text"
                            name="search"
                            placeholder="Enter Search Term"
                            id="search"
                            class="block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        />
                    </div>
                </div>

                <!-- currently selected info section -->
                <div class="my-4">
                    <div>
                        {#if selectAll}
                            You are currently selecting all {checked.length} items.
                        {:else if selectPage}
                            You have selected <strong>{checked.length}</strong>
                            items, Do you want to Select All
                            <strong>{students.meta.total}</strong>
                            items?
                            <button on:click={selectAllRecords} class="ml-2"
                                >Select All</button
                            >
                        {/if}
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
                                                <input
                                                    bind:checked={selectPage}
                                                    type="checkbox"
                                                    name=""
                                                    id=""
                                                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                />
                                            </th>
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
                                                Avatar
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
                                                    <input
                                                        value={student.id}
                                                        bind:group={checked}
                                                        type="checkbox"
                                                        name=""
                                                        id=""
                                                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                                                    />
                                                </td>
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
                                                    <img
                                                        src={student.avatar}
                                                        alt=""
                                                        width="200px"
                                                    />
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
                                                    {#if $page.props.can.student_edit}
                                                        <Link
                                                            href={route(
                                                                "students.edit",
                                                                student.id
                                                            )}
                                                            class="text-indigo-600 hover:text-indigo-900"
                                                        >
                                                            Edit
                                                        </Link>
                                                    {/if}
                                                    {#if $page.props.can.student_delete}
                                                        <button
                                                            on:click={() =>
                                                                handleDelete(
                                                                    student.id
                                                                )}
                                                            class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                        >
                                                            Delete
                                                        </button>
                                                    {/if}
                                                </td>
                                            </tr>
                                        {/each}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <Pagination data={students} {updatedPageNumber} />
                    </div>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
