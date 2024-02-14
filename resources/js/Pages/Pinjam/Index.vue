<template>
    <div class="h-screen w-full fixed z-50 flex justify-center items-center" v-if="question">
        <div class="bg-white w-4/12 z-50 text-center px-10 rounded py-5">
            <p class="text-xl font-bold py-4">Kembalikan Mobil</p>
            <div class="">
                <form @submit.prevent="form.delete(route('pinjam.destroy', {id:no}))" class="">
                    <input type="text" name="" class="px-3 rounded py-1 w-full text-center" placeholder="Tulis Plat Nomor mobil" v-model="form.nomor_plat">
                    <div class="flex justify-end">
                        <button class="my-1 text-lg bg-blue-600 px-5 rounded text-white" @click="">Ya</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-black bg-opacity-50 h-screen w-full absolute" @click="question = false">
        </div>
    </div>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pb-10">
                    <div class="p-6 text-gray-900 text-2xl">Mobil yang di pinjam</div>
                    <div v-if="$page.props.flash.message" class="mx-10 mb-6 bg-green-400 font-bold  px-10 rounded py-3 text-lg">{{ $page.props.flash.message }}</div>
                    <div v-if="$page.props.flash.danger" class="mx-10 mb-6 bg-red-400 font-bold  px-10 rounded py-3 text-lg">{{ $page.props.flash.danger }}</div> 
                    <div class="flex justify-end px-20">
                        <button class="my-5 text-lg bg-blue-600 px-2 rounded text-white" @click="question = true">Kembalikan Mobil</button>
                    </div>
                    <div class="px-10">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Model</th>
                                    <th>Merek</th>
                                    <th>Plat Nomor</th>
                                    <th>Harga Perhari</th>
                                    <th>Durasi Sewa</th>
                                    <th>Harga yang harus di bayar</th>
                                    <th>Status</th>
                                    <!-- <th>Kembalikan</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(pinjaman, index) in pinjaman">
                                    <td>{{++index}}</td>
                                    <td>{{pinjaman.mobil.model}}</td>
                                    <td>{{pinjaman.mobil.merek}}</td>
                                    <td>{{pinjaman.mobil.nomor_plat}}</td>
                                    <td>{{rupiah(pinjaman.mobil.tarif_sewa)}}</td>
                                    <td>{{selisih(pinjaman.mulai,pinjaman.selesai)+1}} hari</td>
                                    <td class="">{{rupiah(pinjaman.mobil.tarif_sewa*(selisih(pinjaman.mulai,pinjaman.selesai)+1))}}</td>
                                    <td>
                                        {{ pinjaman.status }}
                                        <!-- <form @submit.prevent="form.delete(route('pinjam.destroy', {id:pinjaman.id}))"> -->
                                            <!-- <button class="my-5 text-lg bg-blue-600 px-2 rounded text-white" @click="question = true">Kembalikan</button> -->
                                        <!-- </form> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="pinjaman.length == 0">
                            <p class="p-10 text-lg text-center">kosong</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import { ref } from 'vue';
    const props = defineProps({
        pinjaman: Object
    });
    // console.log(props.mobil.image);
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
      }).format(number);
    }
    let no = ref(1);
    let form = useForm({
        nomor_plat: null
    })
    let question = ref(false)
    function selisih(mulai, selesai){
        const tanggalMulai = new Date(mulai);
        const tanggalSelesai = new Date(selesai);
        const selisih = tanggalSelesai - tanggalMulai;
        return Math.floor(selisih / (1000 * 60 * 60 * 24));
    }
</script>
<style type="text/css">
    table, tbody, tr, td{
        text-align: center !important;
        padding-top: 10px;
        padding-botton: 10px;
    }
</style>