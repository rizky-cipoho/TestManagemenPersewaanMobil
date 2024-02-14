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
                    <div v-if="$page.props.flash.message" class="mx-10 bg-green-400 font-bold  px-10 rounded py-3 text-lg">{{ $page.props.flash.message }}</div> 
                    <div class="flex justify-between">
                        <div class="w-3/6">
                            <img :src="'/'+mobil.mobil.image" class="object-cover">
                        </div>
                        <div class="w-3/6">
                            <p class="text-2xl font-bold">{{mobil.model}} {{mobil.merek}}</p>
                            <br>
                            <table >
                                <tr>
                                    <td class="mt-10"><p>Disewa Oleh</p></td>
                                    <td><p></p>: {{mobil.user.nama}}</td>
                                </tr>
                                <tr>
                                    <td class="mt-10"><p>SIM</p></td>
                                    <td><p></p>: {{mobil.user.sim}}</td>
                                </tr>
                                <tr>
                                    <td class="mt-10"><p>Alamat Penyewa</p></td>
                                    <td><p></p>: {{mobil.user.alamat}}</td>
                                </tr>
                                <tr>
                                    <td><p>Model</p></td>
                                    <td><p></p>: {{mobil.mobil.model}}</td>
                                </tr>
                                <tr>
                                    <td><p>Merek</p></td>
                                    <td><p></p>: {{mobil.mobil.merek}}</td>
                                </tr>
                                
                                <tr>
                                    <td><p>Plat Nomor</p></td>
                                    <td><p></p>: {{mobil.mobil.nomor_plat}}</td>
                                </tr>
                                <tr>
                                    <td><p>Harga Sewa Perhari</p></td>
                                    <td><p></p>: {{rupiah(mobil.mobil.tarif_sewa)}}</td>
                                </tr>
                                <tr>
                                    <td><p>Durasi Sewa</p></td>
                                    <td><p></p>: {{selisih(mobil.mulai, mobil.selesai)+1}}</td>
                                </tr>
                                <tr>
                                    <td><p>Total</p></td>
                                    <td><p></p>: {{rupiah(mobil.mobil.tarif_sewa*(selisih(mobil.mulai, mobil.selesai)+1))}}</td>
                                </tr>
                                <tr>
                                    <td><p>Status</p></td>
                                    <td><p></p>: {{mobil.status}}</td>
                                </tr>
                                <tr v-if="mobil.status != 'Sudah Dikonfirmasi'">
                                    <td>
                                        <form @submit.prevent="form.patch(route('pinjam.update', {id:mobil.id}))">
                                            <button class="my-5 text-lg bg-blue-600 px-2 rounded text-white">Konfirmasi</button>
                                        </form>
                                    </td>
                                </tr>
                            </table>
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
    const props = defineProps({
        mobil: Object
    });
    console.log(props.mobil);
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
      }).format(number);
    }
    const form = useForm({
      id: props.mobil.id,
      durasi: 1,
  })
    function selisih(mulai, selesai){
        const tanggalMulai = new Date(mulai);
        const tanggalSelesai = new Date(selesai);
        const selisih = tanggalSelesai - tanggalMulai;
        return Math.floor(selisih / (1000 * 60 * 60 * 24));
    }
</script>
<style type="text/css">
    table, tr, td{
        text-align: left !important;
        padding-bottom: 10px;
        padding-top: 10px;
    }
</style>