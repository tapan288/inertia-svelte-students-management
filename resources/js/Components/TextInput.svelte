<script>
    import { onMount } from "svelte";

    export let value = "",
        classes = "";

    let inputElement;

    onMount(() => {
        if (inputElement.hasAttribute("autofocus")) {
            inputElement.focus();
        }
    });
</script>

<input
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full {classes}"
    bind:value
    bind:this={inputElement}
    {...$$restProps}
/>
