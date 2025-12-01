import { ColumnDef } from "@tanstack/vue-table"
import { h } from "vue"
import { Input } from "@/components/ui/input"

interface BudgetRow {
    id: string
    categoryGroup: string
    category: string
    assigned: number
    activity: number
    available: number

}

export const columns: ColumnDef<BudgetRow>[] = [
    {
        accessorKey: 'id',
        header: 'Id',
        cell: ({ row }) => {
            const id = row.original.id;
            return h('div', id);
        }
    },
    {
        accessorKey: 'categoryGroup',
        header: 'Category Group',
        cell: ({ row }) => {
            const group = row.original.categoryGroup;
            return h('div', group)
        }
    },
    {
        accessorKey: 'category',
        header: 'Category',
        cell: ({ row }) => {
            const category = row.original.category;
            return h('div', category);
        }
    },
    {
        accessorKey: 'assigned',
        header: 'Assigned (Editable)',
        cell: ({ row }) => {
            const assigned = row.original.assigned;
            return h(Input, { modelValue: assigned })
        }
    },
    {
        accessorKey: 'available',
        header: 'Available',
        cell: ({ row }) => {
            const availableFund = `$${Number(row.original.available).toFixed(2)}`;
            return h('div', availableFund);
        }
    },

]