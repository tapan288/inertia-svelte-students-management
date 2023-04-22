<script>
    export let message = null;
</script>

{#if message}
    <p class="text-sm text-red-600 mt-2">
        {message}
    </p>
{/if}
