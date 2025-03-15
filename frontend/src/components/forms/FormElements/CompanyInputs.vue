<template>
  <div class="space-y-6">
      <form @submit.prevent="handleSubmit">
          <div v-if="errorMessage" class="mb-5 rounded-xl border border-error-500 bg-error-50 p-4 dark:border-error-500/30 dark:bg-error-500/15">
              <div class="flex items-start gap-3">
                  <div class="-mt-0.5 text-error-500">
                      <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path fill-rule="evenodd" clip-rule="evenodd" d="M20.3499 12.0004C20.3499 16.612 16.6115 20.3504 11.9999 20.3504C7.38832 20.3504 3.6499 16.612 3.6499 12.0004C3.6499 7.38881 7.38833 3.65039 11.9999 3.65039C16.6115 3.65039 20.3499 7.38881 20.3499 12.0004ZM11.9999 22.1504C17.6056 22.1504 22.1499 17.6061 22.1499 12.0004C22.1499 6.3947 17.6056 1.85039 11.9999 1.85039C6.39421 1.85039 1.8499 6.3947 1.8499 12.0004C1.8499 17.6061 6.39421 22.1504 11.9999 22.1504ZM13.0008 16.4753C13.0008 15.923 12.5531 15.4753 12.0008 15.4753L11.9998 15.4753C11.4475 15.4753 10.9998 15.923 10.9998 16.4753C10.9998 17.0276 11.4475 17.4753 11.9998 17.4753L12.0008 17.4753C12.5531 17.4753 13.0008 17.0276 13.0008 16.4753ZM11.9998 6.62898C12.414 6.62898 12.7498 6.96476 12.7498 7.37898L12.7498 13.0555C12.7498 13.4697 12.414 13.8055 11.9998 13.8055C11.5856 13.8055 11.2498 13.4697 11.2498 13.0555L11.2498 7.37898C11.2498 6.96476 11.5856 6.62898 11.9998 6.62898Z" fill="#F04438"></path>
                      </svg>
                  </div>
                  <div>
                      <p class="text-sm text-gray-500 dark:text-gray-400">
                          {{ errorMessage }}
                      </p>
                  </div>
              </div>
          </div>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
         <div>
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
            Name*
          </label>
          <input
            type="text"
            v-model="formData.name"
            placeholder="Company Name"
            class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
          />
        </div>
          <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                  Description
              </label>
              <input
                  type="text"
                  v-model="formData.description"
                  placeholder="Company Description"
                  class="dark:bg-dark-900 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
              />
          </div>
            <button
                type="submit"
                class="flex items-center justify-center w-100 px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs"
            >
                Submit
            </button>
        </div>
      </form>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import 'flatpickr/dist/flatpickr.css'
import {decodeBase64} from "@/lib/encryption.js";
import router from "@/router";

let errorMessage = ref('');
const userToken = decodeBase64(localStorage.getItem('userToken'));

const formData = reactive({
  name: '',
  description: '',
})


const handleSubmit = async () => {
    try {
        errorMessage = null;
        const response = await fetch(`/api/company/create`, {
            method: 'POST',
            headers: {
                'Authorization': `Bearer ${userToken}`,
            },
            body: JSON.stringify({name: formData.name, description: formData.description}),
        });

        const data = await response.json();
        if (!response.ok) throw new Error(data.message || 'Creating of company failed');

        await router.push('/companies');
    } catch (error) {
        errorMessage = error.message;
    }
}
</script>
