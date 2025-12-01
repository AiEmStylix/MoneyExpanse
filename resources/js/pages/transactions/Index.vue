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
import { Badge } from '@/components/ui/badge';
import Icon from '@/components/Icon.vue';

interface Transaction {
    id: number;
    category_id: number;
    date: string;
    amount: string;
    payee: string | null;
    description: string | null;
    inflow: boolean;
    category: {
        id: number;
        name: string;
        category_group_id: number;
        group: {
            id: number;
            name: string;
        };
    };
}

interface Props {
    transactions: {
        data: Transaction[];
        current_page: number;
        last_page: number;
        per_page: number;
        total: number;
    };
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Transactions',
        href: '/transactions',
    },
];

const deleteTransaction = (id: number) => {
    if (confirm('Are you sure you want to delete this transaction?')) {
        router.delete(`/transactions/${id}`, {
            preserveScroll: true,
        });
    }
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString();
};

const formatCurrency = (amount: string) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(parseFloat(amount));
};
</script>

<template>

    <Head title="Transactions" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Transactions</h1>
                    <p class="text-muted-foreground">
                        Manage your income and expenses
                    </p>
                </div>
                <Link href="/transactions/create">
                <Button>
                    <Icon name="plus" class="mr-2 h-4 w-4" />
                    Add Transaction
                </Button>
                </Link>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>All Transactions</CardTitle>
                    <CardDescription>
                        Total: {{ transactions.total }} transactions
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Date</TableHead>
                                <TableHead>Payee</TableHead>
                                <TableHead>Category</TableHead>
                                <TableHead>Description</TableHead>
                                <TableHead>Type</TableHead>
                                <TableHead class="text-right">Amount</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="transaction in transactions.data" :key="transaction.id">
                                <TableCell>{{ formatDate(transaction.date) }}</TableCell>
                                <TableCell>{{ transaction.payee || '-' }}</TableCell>
                                <TableCell>
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{
                                            transaction.category.name
                                            }}</span>
                                        <span class="text-xs text-muted-foreground">{{
                                            transaction.category.group.name
                                            }}</span>
                                    </div>
                                </TableCell>
                                <TableCell>{{
                                    transaction.description || '-'
                                    }}</TableCell>
                                <TableCell>
                                    <Badge :variant="transaction.inflow ? 'default' : 'destructive'
                                        ">
                                        {{ transaction.inflow ? 'Income' : 'Expense' }}
                                    </Badge>
                                </TableCell>
                                <TableCell class="text-right font-medium">
                                    <span :class="transaction.inflow
                                            ? 'text-green-600'
                                            : 'text-red-600'
                                        ">
                                        {{ transaction.inflow ? '+' : '-'
                                        }}{{ formatCurrency(transaction.amount) }}
                                    </span>
                                </TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="`/transactions/${transaction.id}/edit`">
                                        <Button variant="ghost" size="sm">
                                            <Icon name="pencil" class="h-4 w-4" />
                                        </Button>
                                        </Link>
                                        <Button variant="ghost" size="sm" @click="deleteTransaction(transaction.id)">
                                            <Icon name="trash" class="h-4 w-4" />
                                        </Button>
                                    </div>
                                </TableCell>
                            </TableRow>
                        </TableBody>
                    </Table>

                    <div v-if="transactions.last_page > 1" class="mt-4 flex items-center justify-between">
                        <p class="text-sm text-muted-foreground">
                            Page {{ transactions.current_page }} of
                            {{ transactions.last_page }}
                        </p>
                        <div class="flex gap-2">
                            <Link :href="`/transactions?page=${transactions.current_page - 1}`"
                                :disabled="transactions.current_page === 1">
                            <Button variant="outline" size="sm" :disabled="transactions.current_page === 1">
                                Previous
                            </Button>
                            </Link>
                            <Link :href="`/transactions?page=${transactions.current_page + 1}`" :disabled="transactions.current_page === transactions.last_page
                                ">
                            <Button variant="outline" size="sm" :disabled="transactions.current_page ===
                                transactions.last_page
                                ">
                                Next
                            </Button>
                            </Link>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
