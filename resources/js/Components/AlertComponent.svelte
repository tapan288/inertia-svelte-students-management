<script>
    export let message,
        type = "success";
</script>

{#if message && type == "success"}
    <div class="rounded-md bg-green-100 p-4 mb-4">
        <div class="ml-3">
            <p class="text-sm font-medium text-green-800">
                {message}
            </p>
        </div>
    </div>
{/if}

{#if message && type == "error"}
    <div class="rounded-md bg-red-100 p-4 mb-4">
        <div class="ml-3">
            <p class="text-sm font-medium text-red-800">
                {message}
            </p>
        </div>
    </div>
{/if}
