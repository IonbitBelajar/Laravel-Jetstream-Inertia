<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Posts Index
        <Link
          class="float-right"
          :href="route('posts.create')"
          v-if="$page.props.permission.posts.create"
        >
          <jet-button>Create</jet-button>
        </Link>
      </h2>
    </template>

    <div v-if="$page.props.flash.message" class=" bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" >
      <strong class="font-bold">Successfully! </strong>
      <span class="block sm:inline">
        {{ $page.props.flash.message }}
      </span>
      <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
        <svg
          class="fill-current h-6 w-6 text-green-500"
          role="button"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 20 20"
        >
          <title>Close</title>
          <path
            d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"
          />
        </svg>
      </span>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <jet-input
          type="text"
          class="block ml-2 mb-4 w-60"
          v-model="form.search"
          placeholder="Cari user..."
        />
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class=" py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8 " >
                <div class=" shadow overflow-hidden border-b border-gray-200 sm:rounded-lg " >
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider " >
                          Title
                        </th>
                        <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider " >
                          Content
                        </th>
                        <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider " >
                          Created At
                        </th>
                        <th scope="col" class=" px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider " >
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-if="!posts_all.data.length">
                        <td class="p-4 text-center text-gray-900" colspan="5">
                          No data
                        </td>
                      </tr>
                      <tr v-for="post in posts_all.data" :key="post.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex items-center">
                            <div class="ml-4">
                              <div class="text-sm font-medium text-gray-900">
                                {{ post.title }}
                              </div>
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span class=" px-2 inline-flex text-xs leading-5 " >
                                    {{ post.content }}
                          </span>
                        </td>
                        <td class=" px-6 py-4 whitespace-nowrap text-sm text-gray-900 " >
                          {{ post.created_at }}
                        </td>
                        <td class="text-left  px-6 py-4 whitespace-nowrap text-right text-sm font-medium " >
                          <Link :href="route('posts.show', post.id)" class="text-indigo-600 hover:text-indigo-900 ml-1" v-if="post.can.view" >Show</Link>
                          <Link :href="route('posts.edit', post.id)" class="text-indigo-600 hover:text-indigo-900 ml-1" v-if="post.can.view" >Edit</Link >
                          <button class="text-white-600 hover:text-white-900 ml-1" @click.prevent="deletePost(`${post.id}`)" >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                  <jet-pagination class="m-5" :links="posts_all.links" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { reactive, watchEffect } from "vue";
import { pickBy } from "lodash";
import { Inertia } from "@inertiajs/inertia";
import { defineComponent } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Jetstream/Welcome.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input";
import JetPagination from "@/Components/Pagination";
import { Link } from "@inertiajs/inertia-vue3";

export default defineComponent({
  components: {
    AppLayout,
    Welcome,
    Link,
    JetButton,
    JetInput,
    JetPagination,
  },
  props: {
    posts_all: Object,
    filters: Object,
  },

  setup(props) {
    const form = reactive({
      search: props.filters.search,
      page: props.filters.page,
    });

    watchEffect(() => {
      const query = pickBy(form);
      Inertia.replace(
        route("posts.index", Object.keys(query).length ? query : {})
      );
    });
    function deletePost(id) {
      Inertia.delete(`/admin/posts/${id}`);
    }

    return { form, deletePost };
  },
});
</script>
