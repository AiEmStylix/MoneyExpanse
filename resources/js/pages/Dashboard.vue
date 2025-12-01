<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import BudgetTable from '@/components/categories/BudgetTable.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader class="flex justify-center items-center">
                        <CardTitle>Left to budget:</CardTitle>
                    </CardHeader>
                    <CardContent class="flex justify-center items-center">
                        <p>$0.00</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex justify-center items-center">
                        <CardTitle>Total income:</CardTitle>
                    </CardHeader>
                    <CardContent class="flex justify-center items-center">
                        <p>$3,600.00</p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex justify-center items-center">
                        <CardTitle>Total assigned:</CardTitle>
                    </CardHeader>
                    <CardContent class="flex justify-center items-center">
                        <p>$3,600.00</p>
                    </CardContent>
                </Card>
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <BudgetTable />
            </div>
            <div
                class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
        <div
            class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <PlaceholderPattern />
        </div>

    </AppLayout>
</template>
