<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-2xl">Pinjam Mobil</div>
                    <div class="px-6 flex items-center gap-5 py-3">
                        <!-- <form class="flex items-center gap-5"> -->
                            <input type="text" v-model="model" placeholder="Model" class="rounded">
                            <input type="text" v-model="merek" placeholder="Merek" class="rounded">
                            <input type="checkbox" id="check" v-model="tersedia" placeholder="Merek" class="rounded">
                            <label for="check">Tersedia</label>
                            <button class="bg-blue-600 px-2 rounded text-white py-2" @click="search">Cari</button>
                            <!-- </form> -->
                        </div>
                        <div class="flex grid grid-cols-5 gap-5 px-10">
                            <div v-if="mobils.length == 0">
                                <p class="p-10 text-lg text-center">Data kosong</p>
                            </div>
                            <div v-for="mobils in allCar" class="border px-3 py-5">
                                <div class="bg-gray-400 bg-opacity-50 absolute" v-if="mobils.pinjam != null">
                                    Tidak Tersedia
                                </div>
                                <div class="flex justify-center">
                                    <img :src="'/'+mobils.image" class="h-28 object-cover">
                                </div>
                                <div class="flex items-center">
                                    <div>
                                        <p>{{mobils.model}} {{mobils.merek}}</p>

                                        <p class="text-red-600 font-bold">{{rupiah(mobils.tarif_sewa)}}/Hari</p>
                                        <small>Pemilik {{mobils.user.nama}}</small>
                                        <br>

                                        <Link :href="route('mobil.show', {id: mobils.id})" as="button" class="bg-blue-600 px-2 rounded text-white" :disabled="mobils.pinjam != null" :class="{'bg-gray-400':mobils.pinjam != null}">Sewa</Link>
                                    </div>
                                </div>
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
        import { ref, watch } from 'vue'
        const props = defineProps({
            mobils: Object,
            mobilsTersedia: Object
        });
        const allCar = ref(props.mobils)
        const merek = ref('');
        const model = ref('');
        const tersedia = ref(false);
        function search(){
            axios.post('/search', {
                merek: merek.value,
                model: model.value,
                tersedia: tersedia.value
            })
            .then(function (response) {
                allCar.value = response.data
            });
        }
        watch(merek, function(){
            if (merek.value == '' && model.value == '') {
                allCar.value = props.mobils
            }
        })
        watch(model, function(){
            if (merek.value == '' && model.value == '') {
                allCar.value = props.mobils
            }
        })
        const rupiah = (number)=>{
            return new Intl.NumberFormat("id-ID", {
              style: "currency",
              currency: "IDR"
          }).format(number);
        }
    </script>