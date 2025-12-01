<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { type BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import InputError from '@/components/InputError.vue';

interface CategoryGroup {
    id: number;
    name: string;
}

interface Category {
    id: number;
    name: string;
    category_group_id: number;
    order: number;
}

interface Props {
    category?: Category;
    categoryGroups: CategoryGroup[];
}

const props = defineProps<Props>();

const isEdit = !!props.category;

const form = useForm({
    name: props.category?.name || '',
    category_group_id: props.category?.category_group_id || null,
    order: props.category?.order || 0,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Categories',
        href: '/categories',
    },
    {
        title: isEdit ? 'Edit Category' : 'Create Category',
        href: isEdit ? `/categories/${props.category!.id}/edit` : '/categories/create',
    },
];

const submit = () => {
    if (isEdit) {
        form.put(`/categories/${props.category!.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/categories');
            },
        });
    } else {
        form.post('/categories', {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/categories');
            },
        });
    }
};
</script>

<template>

    <Head :title="isEdit ? 'Edit Category' : 'Create Category'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div>
                <h1 class="text-3xl font-bold">
                    {{ isEdit ? 'Edit Category' : 'Create Category' }}
                </h1>
                <p class="text-muted-foreground">
                    {{ isEdit ? 'Update category details' : 'Add a new category' }}
                </p>
            </div>

            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Category Details</CardTitle>
                    <CardDescription>
                        Fill in the category information
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" type="text" placeholder="Enter category name"
                                required />
                            <InputError :message="form.errors.name" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="category_group_id">Category Group</Label>
                            <Select v-model="form.category_group_id" required>
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a category group" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem v-for="group in categoryGroups" :key="group.id"
                                        :value="group.id.toString()">
                                        {{ group.name }}
                                    </SelectItem>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.category_group_id" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="order">Order</Label>
                            <Input id="order" v-model.number="form.order" type="number" min="0" placeholder="0" />
                            <InputError :message="form.errors.order" />
                            <p class="text-xs text-muted-foreground">
                                Lower numbers appear first
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <Button type="submit" :disabled="form.processing">
                                {{ isEdit ? 'Update' : 'Create' }} Category
                            </Button>
                            <Button type="button" variant="outline" @click="router.visit('/categories')">
                                Cancel
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
