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
import InputError from '@/components/InputError.vue';

interface CategoryGroup {
    id: number;
    name: string;
    order: number;
}

interface Props {
    categoryGroup?: CategoryGroup;
}

const props = defineProps<Props>();

const isEdit = !!props.categoryGroup;

const form = useForm({
    name: props.categoryGroup?.name || '',
    order: props.categoryGroup?.order || 0,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Category Groups',
        href: '/category-groups',
    },
    {
        title: isEdit ? 'Edit Category Group' : 'Create Category Group',
        href: isEdit
            ? `/category-groups/${props.categoryGroup!.id}/edit`
            : '/category-groups/create',
    },
];

const submit = () => {
    if (isEdit) {
        form.put(`/category-groups/${props.categoryGroup!.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/category-groups');
            },
        });
    } else {
        form.post('/category-groups', {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/category-groups');
            },
        });
    }
};
</script>

<template>

    <Head :title="isEdit ? 'Edit Category Group' : 'Create Category Group'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div>
                <h1 class="text-3xl font-bold">
                    {{ isEdit ? 'Edit Category Group' : 'Create Category Group' }}
                </h1>
                <p class="text-muted-foreground">
                    {{
                        isEdit
                            ? 'Update category group details'
                            : 'Add a new category group'
                    }}
                </p>
            </div>

            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Category Group Details</CardTitle>
                    <CardDescription>
                        Fill in the category group information
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid gap-2">
                            <Label for="name">Name</Label>
                            <Input id="name" v-model="form.name" type="text" placeholder="Enter category group name"
                                required />
                            <InputError :message="form.errors.name" />
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
                                {{ isEdit ? 'Update' : 'Create' }} Category Group
                            </Button>
                            <Button type="button" variant="outline" @click="router.visit('/category-groups')">
                                Cancel
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
