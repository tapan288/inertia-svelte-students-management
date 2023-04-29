<script>
    import { Link } from "@inertiajs/svelte";

    export let data;
</script>

<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="max-w-none mx-auto">
        <div class="bg-white overflow-hidden shadow sm:rounded-lg">
            <div
                class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
            >
                <div class="flex-1 flex justify-between sm:hidden" />
                <div
                    class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                >
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <!-- space -->
                            <span class="font-medium">{data.meta.from}</span>
                            <!-- space -->
                            to
                            <!-- space -->
                            <span class="font-medium">{data.meta.to}</span>
                            <!-- space -->
                            of
                            <!-- space -->
                            <span class="font-medium">{data.meta.total}</span>
                            <!-- space -->
                            results
                        </p>
                    </div>
                    <div>
                        <nav
                            class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                            aria-label="Pagination"
                        >
                            {#each data.meta.links as link}
                                <Link
                                    preserveScroll
                                    as="button"
                                    href={link.url}
                                    disabled={link.active || !link.url}
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
