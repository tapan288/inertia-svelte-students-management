<script context="module">
    export { default as layout } from "../../Layouts/GuestLayout.svelte";
</script>

<script>
    export let status;

    import { useForm } from "@inertiajs/svelte";
    import InputLabel from "../../Components/InputLabel.svelte";
    import TextInput from "../../Components/TextInput.svelte";
    import InputError from "../../Components/InputError.svelte";
    import PrimaryButton from "../../Components/PrimaryButton.svelte";

    const form = useForm({
        email: "",
    });

    const submit = () => {
        $form.post(route("password.email"));
    };
</script>

<svelte:head>
    <title>Forgot Password</title>
</svelte:head>

<div class="mb-4 text-sm text-gray-600">
    Forgot your password? No problem. Just let us know your email address and we
    will email you a password reset link that will allow you to choose a new
    one.
</div>

{#if status}
    <div class="mb-4 font-medium text-sm text-green-600">
        {status}
    </div>
{/if}

<form on:submit|preventDefault={submit}>
    <div>
        <InputLabel for="email" value="Email" />

        <TextInput
            id="email"
            type="email"
            classes="mt-1 block w-full"
            bind:value={$form.email}
            required
            autofocus
            autocomplete="username"
        />

        <InputError class="mt-2" message={$form.errors.email} />
    </div>

    <div class="flex items-center justify-end mt-4">
        <PrimaryButton disabled={$form.processing}>
            Email Password Reset Link
        </PrimaryButton>
    </div>
</form>
