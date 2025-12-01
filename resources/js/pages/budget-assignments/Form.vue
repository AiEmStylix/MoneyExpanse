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

interface Category {
    id: number;
    name: string;
    group: {
        id: number;
        name: string;
    };
}

interface BudgetAssignment {
    id: number;
    category_id: number;
    month: string;
    amount: string;
}

interface Props {
    budgetAssignment?: BudgetAssignment;
    categories: Category[];
}

const props = defineProps<Props>();

const isEdit = !!props.budgetAssignment;

const form = useForm({
    category_id: props.budgetAssignment?.category_id || null,
    month: props.budgetAssignment?.month || new Date().toISOString().slice(0, 7),
    amount: props.budgetAssignment?.amount || '',
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Budget Assignments',
        href: '/budget-assignments',
    },
    {
        title: isEdit ? 'Edit Budget Assignment' : 'Create Budget Assignment',
        href: isEdit
            ? `/budget-assignments/${props.budgetAssignment!.id}/edit`
            : '/budget-assignments/create',
    },
];

const submit = () => {
    if (isEdit) {
        form.put(`/budget-assignments/${props.budgetAssignment!.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/budget-assignments');
            },
        });
    } else {
        form.post('/budget-assignments', {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/budget-assignments');
            },
        });
    }
};

const groupedCategories = props.categories.reduce((acc, category) => {
    const groupName = category.group.name;
    if (!acc[groupName]) {
        acc[groupName] = [];
    }
    acc[groupName].push(category);
    return acc;
}, {} as Record<string, Category[]>);
</script>

<template>

    <Head :title="isEdit ? 'Edit Budget Assignment' : 'Create Budget Assignment'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div>
                <h1 class="text-3xl font-bold">
                    {{ isEdit ? 'Edit Budget Assignment' : 'Create Budget Assignment' }}
                </h1>
                <p class="text-muted-foreground">
                    {{
                        isEdit
                            ? 'Update budget assignment details'
                            : 'Add a new budget assignment'
                    }}
                </p>
            </div>

            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Budget Assignment Details</CardTitle>
                    <CardDescription>
                        Assign a budget amount to a category for a specific month
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid gap-2">
                            <Label for="month">Month</Label>
                            <Input id="month" v-model="form.month" type="month" required />
                            <InputError :message="form.errors.month" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="category_id">Category</Label>
                            <Select v-model="form.category_id" required>
                                <SelectTrigger>
                                    <SelectValue placeholder="Select a category" />
                                </SelectTrigger>
                                <SelectContent>
                                    <template v-for="(categories, groupName) in groupedCategories" :key="groupName">
                                        <div class="px-2 py-1.5 text-sm font-semibold">
                                            {{ groupName }}
                                        </div>
                                        <SelectItem v-for="category in categories" :key="category.id"
                                            :value="category.id.toString()" class="pl-6">
                                            {{ category.name }}
                                        </SelectItem>
                                    </template>
                                </SelectContent>
                            </Select>
                            <InputError :message="form.errors.category_id" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="amount">Budget Amount</Label>
                            <Input id="amount" v-model="form.amount" type="number" step="0.01" min="0"
                                placeholder="0.00" required />
                            <InputError :message="form.errors.amount" />
                        </div>

                        <div class="flex gap-2">
                            <Button type="submit" :disabled="form.processing">
                                {{ isEdit ? 'Update' : 'Create' }} Budget Assignment
                            </Button>
                            <Button type="button" variant="outline" @click="router.visit('/budget-assignments')">
                                Cancel
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
