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

interface BudgetAssignment {
    id: number;
    category_id: number;
    month: string;
    amount: string;
    category: {
        id: number;
        name: string;
        group: {
            id: number;
            name: string;
        };
    };
}

interface Props {
    budgetAssignments: BudgetAssignment[];
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Budget Assignments',
        href: '/budget-assignments',
    },
];

const deleteBudgetAssignment = (id: number) => {
    if (confirm('Are you sure you want to delete this budget assignment?')) {
        router.delete(`/budget-assignments/${id}`, {
            preserveScroll: true,
        });
    }
};

const formatCurrency = (amount: string) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(parseFloat(amount));
};

const formatMonth = (month: string) => {
    return new Date(month).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
    });
};
</script>

<template>

    <Head title="Budget Assignments" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Budget Assignments</h1>
                    <p class="text-muted-foreground">
                        Assign budgets to categories by month
                    </p>
                </div>
                <Link href="/budget-assignments/create">
                <Button>
                    <Icon name="plus" class="mr-2 h-4 w-4" />
                    Add Budget Assignment
                </Button>
                </Link>
            </div>

            <Card>
                <CardHeader>
                    <CardTitle>All Budget Assignments</CardTitle>
                    <CardDescription>
                        Total: {{ budgetAssignments.length }} assignments
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <Table>
                        <TableHeader>
                            <TableRow>
                                <TableHead>Month</TableHead>
                                <TableHead>Category</TableHead>
                                <TableHead>Group</TableHead>
                                <TableHead class="text-right">Amount</TableHead>
                                <TableHead class="text-right">Actions</TableHead>
                            </TableRow>
                        </TableHeader>
                        <TableBody>
                            <TableRow v-for="assignment in budgetAssignments" :key="assignment.id">
                                <TableCell>{{ formatMonth(assignment.month) }}</TableCell>
                                <TableCell class="font-medium">{{
                                    assignment.category.name
                                    }}</TableCell>
                                <TableCell>{{
                                    assignment.category.group.name
                                    }}</TableCell>
                                <TableCell class="text-right font-medium">{{
                                    formatCurrency(assignment.amount)
                                    }}</TableCell>
                                <TableCell class="text-right">
                                    <div class="flex justify-end gap-2">
                                        <Link :href="`/budget-assignments/${assignment.id}/edit`">
                                        <Button variant="ghost" size="sm">
                                            <Icon name="pencil" class="h-4 w-4" />
                                        </Button>
                                        </Link>
                                        <Button variant="ghost" size="sm"
                                            @click="deleteBudgetAssignment(assignment.id)">
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
