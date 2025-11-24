import { h } from 'vue'
import type { ColumnDef } from '@tanstack/vue-table'
import DropdownAction from '@/components/categories/DataTableDropdown.vue'

export interface Category {
    id: number
    name: string
    user_id: number | null
    is_system: boolean
    created_at: string
}

export const columns: ColumnDef<Category>[] = [
    {
        accessorKey: 'id',
        header: 'ID',
        cell: ({ row }) => h('div', {}, row.getValue('id')),

    },
    {
        accessorKey: 'name',
        header: () => h('div', { class: 'font-semibold' }, 'Category Name'),
        cell: ({ row }) =>
            h('div', { class: 'font-medium' }, row.getValue('name')),
    },

    {
        accessorKey: 'is_system',
        header: 'System?',
        cell: ({ row }) =>
            row.getValue('is_system')
                ? h('span', { class: 'text-green-600' }, 'Yes')
                : h('span', { class: 'text-gray-500' }, 'No'),
    },

    {
        accessorKey: 'created_at',
        header: 'Created',
        cell: ({ row }) => {
            const date = new Date(row.getValue('created_at'))
            return h('span', new Intl.DateTimeFormat('en-US').format(date))
        },
    },
    {
        id: 'actions',
        header: 'Actions',
        enableHiding: true,
        cell: ({ row }) => {
            const category = row.original
            return !category.is_system
                ? h('div', { class: 'relative' }, h(DropdownAction, { category }))
                : h('div')
        }
    }

]
