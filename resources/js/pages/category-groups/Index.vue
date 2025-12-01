<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import Icon from '@/components/Icon.vue';

interface CategoryGroup {
    id: number;
    name: string;
    order: number;
    categories: Array<{
        id: number;
        name: string;
    }>;
}

interface Props {
    categoryGroups: CategoryGroup[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Category Groups',
        href: '/category-groups',
    },
];

const deleteCategoryGroup = (id: number) => {
    if (confirm('Are you sure you want to delete this category group?')) {
        router.delete(`/category-groups/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>

    <Head title="Category Groups" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Category Groups</h1>
                    <p class="text-muted-foreground">
                        Organize your categories into groups
                    </p>
                </div>
                <Link href="/category-groups/create">
                <Button>
                    <Icon name="plus" class="mr-2 h-4 w-4" />
                    Add Category Group
                </Button>
                </Link>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>All Category Groups</CardTitle>
                    <CardDescription>
                        Total: {{ categoryGroups.length }} groups
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Order</TableHead>
                                <TableHead>Categories</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="group in categoryGroups" :key="group.id">
                                <TableCell class="font-medium">{{
                                    group.name
                                    }}</TableCell>
                                <TableCell>{{ group.order }}</TableCell>
                                <TableCell>
                                    <div class="flex flex-wrap gap-1">
                                        <span v-for="category in group.categories" :key="category.id"
                                            class="inline-flex items-center rounded-md bg-muted px-2 py-1 text-xs">
                                            {{ category.name }}
                                        </span>
                                        <span v-if="group.categories.length === 0" class="text-muted-foreground">
                                            No categories
                                        </span>
                                    </div>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="`/category-groups/${group.id}/edit`">
                                        <Button variant="ghost" size="sm">
                                            <Icon name="pencil" class="h-4 w-4" />
                                        </Button>
                                        </Link>
                                        <Button variant="ghost" size="sm" @click="deleteCategoryGroup(group.id)">
                                            <Icon name="trash" class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
