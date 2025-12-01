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
import { Textarea } from '@/components/ui/textarea';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Switch } from '@/components/ui/switch';
import InputError from '@/components/InputError.vue';

interface Category {
    id: number;
    name: string;
    category_group_id: number;
    group: {
        id: number;
        name: string;
    };
}

interface Transaction {
    id: number;
    category_id: number;
    date: string;
    amount: string;
    payee: string | null;
    description: string | null;
    inflow: boolean;
}

interface Props {
    transaction?: Transaction;
    categories: Category[];
}

const props = defineProps<Props>();

const isEdit = !!props.transaction;

const form = useForm({
    category_id: props.transaction?.category_id || null,
    date: props.transaction?.date || new Date().toISOString().split('T')[0],
    amount: props.transaction?.amount || '',
    payee: props.transaction?.payee || '',
    description: props.transaction?.description || '',
    inflow: props.transaction?.inflow || false,
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transactions',
        href: '/transactions',
    },
    {
        title: isEdit ? 'Edit Transaction' : 'Create Transaction',
        href: isEdit ? `/transactions/${props.transaction!.id}/edit` : '/transactions/create',
    },
];

const submit = () => {
    if (isEdit) {
        form.put(`/transactions/${props.transaction!.id}`, {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/transactions');
            },
        });
    } else {
        form.post('/transactions', {
            preserveScroll: true,
            onSuccess: () => {
                router.visit('/transactions');
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

    <Head :title="isEdit ? 'Edit Transaction' : 'Create Transaction'" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div>
                <h1 class="text-3xl font-bold">
                    {{ isEdit ? 'Edit Transaction' : 'Create Transaction' }}
                </h1>
                <p class="text-muted-foreground">
                    {{ isEdit ? 'Update transaction details' : 'Add a new transaction' }}
                </p>
            </div>

            <Card class="max-w-2xl">
                <CardHeader>
                    <CardTitle>Transaction Details</CardTitle>
                    <CardDescription>
                        Fill in the transaction information
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <div class="grid gap-2">
                            <Label for="date">Date</Label>
                            <Input id="date" v-model="form.date" type="date" required />
                            <InputError :message="form.errors.date" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="payee">Payee</Label>
                            <Input id="payee" v-model="form.payee" type="text" placeholder="Enter payee name" />
                            <InputError :message="form.errors.payee" />
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
                            <Label for="amount">Amount</Label>
                            <Input id="amount" v-model="form.amount" type="number" step="0.01" min="0"
                                placeholder="0.00" required />
                            <InputError :message="form.errors.amount" />
                        </div>

                        <div class="flex items-center space-x-2">
                            <Switch id="inflow" v-model:checked="form.inflow" />
                            <Label for="inflow">
                                {{ form.inflow ? 'Income (Inflow)' : 'Expense (Outflow)' }}
                            </Label>
                            <InputError :message="form.errors.inflow" />
                        </div>

                        <div class="grid gap-2">
                            <Label for="description">Description (Optional)</Label>
                            <Textarea id="description" v-model="form.description"
                                placeholder="Add notes about this transaction" rows="3" />
                            <InputError :message="form.errors.description" />
                        </div>

                        <div class="flex gap-2">
                            <Button type="submit" :disabled="form.processing">
                                {{ isEdit ? 'Update' : 'Create' }} Transaction
                            </Button>
                            <Button type="button" variant="outline" @click="router.visit('/transactions')">
                                Cancel
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
