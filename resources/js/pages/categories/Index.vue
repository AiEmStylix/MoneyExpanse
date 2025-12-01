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

interface Category {
    id: number;
    name: string;
    order: number;
    category_group_id: number;
    group: {
        id: number;
        name: string;
    };
}

interface Props {
    categories: Category[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
];

const deleteCategory = (id: number) => {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(`/categories/${id}`, {
            preserveScroll: true,
        });
    }
};
</script>

<template>

    <Head title="Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Categories</h1>
                    <p class="text-muted-foreground">
                        Manage your budget categories
                    </p>
                </div>
                <Link href="/categories/create">
                <Button>
                    <Icon name="plus" class="mr-2 h-4 w-4" />
                    Add Category
                </Button>
                </Link>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>All Categories</CardTitle>
                    <CardDescription>
                        Total: {{ categories.length }} categories
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Name</TableHead>
                                <TableHead>Group</TableHead>
                                <TableHead>Order</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="category in categories" :key="category.id">
                                <TableCell class="font-medium">{{
                                    category.name
                                    }}</TableCell>
                                <TableCell>{{ category.group.name }}</TableCell>
                                <TableCell>{{ category.order }}</TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="`/categories/${category.id}/edit`">
                                        <Button variant="ghost" size="sm">
                                            <Icon name="pencil" class="h-4 w-4" />
                                        </Button>
                                        </Link>
                                        <Button variant="ghost" size="sm" @click="deleteCategory(category.id)">
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
