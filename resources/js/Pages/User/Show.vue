<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Show Users
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
      <h3 class="text-lg leading-6 font-medium text-gray-900">
        Applicant Information
      </h3>
      <p class="mt-1 max-w-2xl text-sm text-gray-500">
        Personal details and application.
      </p>
    </div>
    <div class="border-t border-gray-200">
      <dl>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Full name
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{user.name}}
          </dd>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Status
          </dt>
          <span v-if="user.status == 'aktif'"  class=" px-2 w-20 text-center text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800  ">
                          Active
                        </span>
                        <span  v-else="user.status == 'tidak aktif'"  class=" px-2 w-25 text-center  text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 " >
                          Not Active
                        </span>
        </div>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Email address
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
           {{user.email}}
          </dd>
        </div>
        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Role
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{user.role}}
          </dd>
        </div>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
          <dt class="text-sm font-medium text-gray-500">
            Terdaftar di tanggal
          </dt>
          <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{dateTime(user.created_at)}}
          </dd>
        </div>
          <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-6 sm:gap-2 sm:px-3">
                  <Link :href="route('users.index')" class="bg-blue-500  mx-5 my-5 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"> Kembali </Link>
        </div>
       
      </dl>
    </div>
  </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'
    import { PaperClipIcon } from '@heroicons/vue/solid'
import moment from 'moment';
    import {  Link } from '@inertiajs/inertia-vue3';


    export default defineComponent({
        components: {
            AppLayout,
            Welcome,
            PaperClipIcon,
            Link
        },
        props:{
            user: Object
        },

          methods: {
            dateTime(value) {
            return moment(value).format("YYYY-MM-DD");
        }
    }
        
    })
</script>
