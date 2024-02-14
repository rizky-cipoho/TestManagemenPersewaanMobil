<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pb-10">
                    <div class="p-6 text-gray-900 text-2xl">Pinjam Mobil</div>
                    <div class="flex justify-between">
                        <div class="w-3/6 p-6">
                            <img :src="'/'+mobil.image" class="object-cover">
                        </div>
                        <div class="w-3/6">
                            <p class="text-xl">{{mobil.model}} {{mobil.merek}}</p>
                            <br>
                            <p class="text-2xl text-red-600 font-black">{{rupiah(mobil.tarif_sewa)}}/Hari</p>
                            <br>
                            <table>
                                <tr>
                                    <td><p>Merek</p></td>
                                    <td>: {{mobil.merek}}</td>
                                </tr>
                                <tr>
                                    <td><p>Model</p></td>
                                    <td>: {{mobil.model}}</td>
                                </tr>
                                <tr>
                                    <td><p>Plat Nomor</p></td>
                                    <td>: {{mobil.nomor_plat}}</td>
                                </tr>
                                <tr>
                                    <td><p>Pemilik Mobil</p></td>
                                    <td>: {{mobil.user.nama}}</td>
                                </tr>
                                <tr>
                                    <td><p>Alamat Pemilik</p></td>
                                    <td>: {{mobil.user.alamat}}</td>
                                </tr>
                                <tr>
                                    <td><p>Tanggal Pinjam</p></td>
                                    <td><p>: <input type="date" name="" class="rounded" v-model="form.mulai" @change="form.selesai = null"></p></td>
                                </tr>
                                <tr>
                                    <td><p>Tanggal Selesai</p></td>
                                    <td><p>: <input type="date" name="" class="rounded" :disabled="form.mulai == null" :min="form.mulai" v-model="form.selesai"></p></td>
                                </tr>
                            </table>
                            <form @submit.prevent="form.post(route('pinjam.store'))">
                                <button class="my-5 text-lg bg-blue-600 px-2 rounded text-white">
                                    Sewa
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="h-20">

        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { ref,watch } from 'vue';
    const props = defineProps({
        mobil: Object
    });
    // console.log(props.mobil.image);
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
      }).format(number);
    }
    const form = useForm({
      id: props.mobil.id,
      mulai: null,
      selesai: null,
  })

</script>
<style type="text/css">
    table, tr, td{
        text-align: left !important;
        padding-bottom: 10px;
        padding-top: 10px;
    }
</style>