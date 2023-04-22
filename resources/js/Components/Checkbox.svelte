<script>
    export let checked = false;
</script>

<input
    type="checkbox"
    bind:checked
    {...$$props}
    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
/>
