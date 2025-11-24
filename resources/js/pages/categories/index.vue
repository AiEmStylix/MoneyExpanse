<script setup lang="ts">

import type { Category } from '@/components/categories/columns'
import { computed, onMounted, ref } from 'vue'
import { Button } from '@/components/ui/button';
import DataTable from '@/components/categories/DataTable.vue';
import AppLayout from '@/layouts/AppLayout.vue'
import { columns } from '@/components/categories/columns'
import { CirclePlus } from 'lucide-vue-next'
import { Link, usePage } from '@inertiajs/vue3'
import { watchEffect } from 'vue';
import { toast } from 'vue-sonner'
import { useFlash } from '@/composables/useFlash';

const props = defineProps<{
    categories: Category[]
}>();

toast.success('Event has been created')

const data = computed(() => props.categories);

const deleted = (id: string) => {
    console.log(id)
}
onMounted(() => {
    useFlash();
})
</script>

<template>
    <AppLayout>
        <div class=" flex flex-col w-full m-2 space-y-2">
            <Button size="icon" class="ml-auto mr-3" as-child>
                <Link href="/categories/create">
                <CirclePlus />
                </Link>
            </Button>
            <DataTable :columns="columns" :data="data"></DataTable>
        </div>

    </AppLayout>
</template>
