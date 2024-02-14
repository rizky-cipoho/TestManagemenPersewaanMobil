<template>
    <div class="h-screen w-full fixed z-50 flex justify-center items-center" v-if="deleteQuestion">
        <div class="bg-white w-4/12 z-50 text-center px-20 rounded py-5">
            <p class="text-xl font-bold">Hapus?</p>
            <div class="flex justify-between">
                <form @submit.prevent="form.delete(route('mobil.destroy', id))">
                    <button class="my-5 text-lg bg-red-600 px-5 rounded text-white" @click="">Ya</button>
                </form>
                <button class="my-5 text-lg bg-blue-600 px-5 rounded text-white" @click="deleteQuestion = false">Tidak</button>
                
            </div>
        </div>
        <div class="bg-black bg-opacity-50 h-screen w-full absolute" @click="deleteQuestion = false">
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
                    <div class="p-6 text-gray-900 text-2xl">Mobil Saya</div>
                    <div v-if="$page.props.flash.message" class="mx-10 bg-green-400 font-bold  px-10 rounded py-3 text-lg">{{ $page.props.flash.message }}</div> 
                    <div v-if="$page.props.flash.danger" class="mx-10 bg-red-400 font-bold  px-10 rounded py-3 text-lg">{{ $page.props.flash.danger }} </div> 
                    <div class="flex justify-end px-16">
                        <Link :href="route('mobil.create')" class="my-5 text-lg bg-blue-400 px-2 rounded text-white" as="button">Tambah Mobil</Link>
                    </div>
                    <div class="px-10">
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Model</th>
                                    <th>Merek</th>
                                    <th>Status Pinjam</th>
                                    <th>Harga Perhari</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr v-for="(mobil, index) in mobils">
                                    <td>{{++index}}</td>
                                    <td><div class="flex justify-center"><img :src="'/'+mobil.image" class="w-20"></div></td>
                                    <td>{{mobil.model}}</td>
                                    <td>{{mobil.merek}}</td>
                                    <td>{{mobil.pinjam == null ? 'Belum disewa' : mobil.pinjam.status }}</td>
                                    <td>{{rupiah(mobil.tarif_sewa)}}</td>
                                    <td v-if="mobil.pinjam == null" class="flex  gap-3 justify-center">
                                        <Link :href="route('mobil.edit', {id:mobil.id})" as="button" class="my-5 text-lg bg-yellow-400 px-2 rounded">Update</Link>
                                        
                                        <button class="my-5 text-lg bg-red-600 px-2 rounded text-white" @click="activeModal(mobil.id)">Hapus</button>
                                    </td>
                                    <td v-if="mobil.pinjam != null" class="py-5">
                                        <Link :href="route('pinjam.show', {id: mobil.pinjam.id})" class="my-5 text-lg bg-blue-600 px-2 rounded text-white">Detail</Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div v-if="mobils.length == 0">
                            <p class="p-10 text-lg text-center">Data kosong</p>
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
    import { ref, watch } from 'vue';
    const props = defineProps({
        mobils: Object
    });
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
      }).format(number);
    }
    let no = ref(1);
    let deleteQuestion = ref(false)
    let id = ref()
    let activeModal = function(val){
        id.value = val
        deleteQuestion.value = true
    }
    let form = useForm({
        id: id.value
    })
    watch(form, function(){
        if(form.processing){
            deleteQuestion.value = false

        }
    })
</script>
<style type="text/css">
    table, tbody, tr, td{
        text-align: center !important;
    }
</style>