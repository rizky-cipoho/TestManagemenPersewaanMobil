<script setup>
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import TextInput2 from '@/Components/TextInput2.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';

    const form = useForm({
        nama: '',
        alamat: '',
        telp: '',
        sim: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = () => {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="nama" value="Nama" />

                <TextInput
                id="nama"
                type="text"
                class="mt-1 block w-full"
                v-model="form.nama"
                required
                autofocus
                autocomplete="nama"
                />

                <InputError class="mt-2" :message="form.errors.nama" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div class="mt-4">
                <InputLabel for="alamat" value="alamat" />

                <textarea
                id="alamat"
                type="alamat"
                class="mt-1 block w-full rounded border-gray-300"
                v-model="form.alamat"
                required
                autocomplete="username"
                ></textarea>

                <InputError class="mt-2" :message="form.errors.alamat" />
            </div>
            <div class="mt-4">
                <InputLabel for="telp" value="telp" />

                <TextInput2
                id="telp"
                type="text"
                class="mt-1 block w-full"
                v-model="form.telp"

                required
                autocomplete="telp"
                />

                <InputError class="mt-2" :message="form.errors.telp" />
            </div>
            
            <div class="mt-4">
                <InputLabel for="sim" value="sim" />

                <TextInput
                id="sim"
                type="text"
                class="mt-1 block w-full"
                v-model="form.sim"
                required
                autocomplete="sim"
                />

                <InputError class="mt-2" :message="form.errors.sim" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                id="password"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password"
                required
                autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                id="password_confirmation"
                type="password"
                class="mt-1 block w-full"
                v-model="form.password_confirmation"
                required
                autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                :href="route('login')"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                Already registered?
            </Link>

            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Register
            </PrimaryButton>
        </div>
    </form>
</GuestLayout>
</template>
