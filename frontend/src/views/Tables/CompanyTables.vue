<template>
  <AdminLayout>
    <PageBreadcrumb :pageTitle="currentPageTitle" />
          <div class="flex items-end justify-end gap-5 mb-5">
              <Button size="sm" @click="redirectToAddCompany" variant="primary" :startIcon="PlusIcon">Add Company</Button>
          </div>
    <div class="space-y-5 sm:space-y-6">
      <ComponentCard title="">
        <BasicCompanyTable />
      </ComponentCard>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref } from "vue";
import PageBreadcrumb from "@/components/common/PageBreadcrumb.vue";
import AdminLayout from "@/components/layout/AdminLayout.vue";
import ComponentCard from "@/components/common/ComponentCard.vue";
import BasicCompanyTable from "@/components/tables/basic-tables/BasicCompanyTable.vue";
import {PlusIcon} from "@/icons";
import Button from "@/components/ui/Button.vue";
import router from "@/router";
const currentPageTitle = ref("Companies");

const redirectToAddCompany = () => {
    router.push('/company/create');
}
</script>
