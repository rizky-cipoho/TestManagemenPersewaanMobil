<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mobil Saya</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg pb-10">
                    <div class="p-6 text-gray-900 text-2xl">Mobil yang Ingin Disewa</div>   
                    <div v-if="$page.props.flash.message" class="mx-10 bg-green-400 font-bold  px-10 rounded py-3 text-lg">{{ $page.props.flash.message }}</div> 
                    <div class="px-10">
                        <form @submit.prevent="form.post(route('mobil.updateData', mobil.id))">

                            <table class="">
                                <tbody>
                                    <tr>
                                        <th>Merek Mobil</th>
                                        <th>: <input type="" name="" class="border px-2 py-1 rounded" v-model="form.merek" required></th>
                                    </tr>
                                    <tr>
                                        <th>Model Mobil</th>
                                        <th>: <input type="" name="" v-model="form.model" class="border px-2 py-1 rounded" required></th>
                                    </tr>
                                    <tr>
                                        <th>Nomor Plat Mobil</th>
                                        <th>: <input type="" name="" v-model="form.nomor_plat" class="border px-2 py-1 rounded" required></th>
                                    </tr>
                                    <tr>
                                        <th>Harga Sewa Perhari</th>
                                        <th>: <input type="" name="" v-model="form.tarif_sewa" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" class="border px-2 py-1 rounded" required></th>
                                    </tr>
                                    <tr>
                                        <th>Gambar Mobil</th>
                                        <th>: <input type="file" name="" class="border px-2 py-1 rounded" @change="changeImage"  @input="form.image = $event.target.files[0]" accept="image/*"></th>
                                    </tr>
                                    <tr>
                                    </tr>
                                </tbody>
                            </table>

                            <img v-if="image" :src="image" class="w-52 object-cover" >

                            <button class="my-5 text-lg bg-blue-600 px-2 rounded text-white">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
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
    console.log(props.mobils);
    const rupiah = (number)=>{
        return new Intl.NumberFormat("id-ID", {
          style: "currency",
          currency: "IDR"
      }).format(number);
    }
    let no = ref(1);
    let image = ref('/'+props.mobil.image);
    let changeImage = function(e) {
      const file = e.target.files[0];
      image.value = URL.createObjectURL(file);
  }
  let form = useForm({
    merek: props.mobil.merek,
    model: props.mobil.model,
    nomor_plat: props.mobil.nomor_plat,
    tarif_sewa: props.mobil.tarif_sewa,
    image: null,
  });
  function submit(){
    form.post(route('mobil.update', mobil.id),{
        _method: 'put',
    });
  }
  watch(form, function(){
    console.log(form)
  })
</script>
<style type="text/css">
    table, tbody, tr, td{
        text-align: left;
    }
</style>