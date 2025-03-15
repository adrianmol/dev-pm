<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
    <div class="grid grid-cols-1">
      <div class="space-y-12">
        <ComponentCard>
          <ProjectInputs />
        </ComponentCard>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from 'vue'
import PageBreadcrumb from '@/components/common/PageBreadcrumb.vue'
import AdminLayout from '@/components/layout/AdminLayout.vue'
import ComponentCard from '@/components/common/ComponentCard.vue'
import ProjectInputs from "@/components/forms/FormElements/ProjectInputs.vue";
const currentPageTitle = ref('Company Form')
</script>
