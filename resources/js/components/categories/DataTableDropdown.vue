<script setup lang="ts">
import { EllipsisVertical } from 'lucide-vue-next'
import { Button } from '@/components/ui/button'
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { ref } from 'vue';
import { watchEffect } from 'vue';
import { router } from '@inertiajs/vue3'
import { Category } from './columns';
import { Link } from '@inertiajs/vue3'



defineProps<{
    category: Category
}>()


const copy = (id: number) => {
    navigator.clipboard.writeText(`${id}`)
}

const deleteCategory = (id: number) => {
    router.delete(`/categories/${id}`, {
        onSuccess: () => {
            console.log('Category deleted successfully');

        },
        onError: (errors) => {
            console.error(errors);
        }
    })
}

const handleDelete = (id: number) => {
    deleteCategory(id);
    dialog.value = !dialog.value;
}

const dialog = ref(false);

</script>

<template>
    <Dialog v-model:open="dialog">
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button variant="ghost" class="w-8 h-8 p-0">
                    <span class="sr-only">Open menu</span>
                    <EllipsisVertical class="w-4 h-4" />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                <DropdownMenuItem @click="copy(category.id)">
                    Copy category ID
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem as-child>
                    <Link :href="`/categories/${category.id}/edit`">View category</Link>
                </DropdownMenuItem>
                <DialogTrigger as-child>
                    <DropdownMenuItem>Delete category</DropdownMenuItem>
                </DialogTrigger>

            </DropdownMenuContent>
        </DropdownMenu>

        <DialogContent>
            <DialogHeader>
                <DialogTitle>Are you absolutely sure?</DialogTitle>
                <DialogDescription>
                    This action cannot be undone. Are you sure you want to permanently
                    delete category?
                </DialogDescription>
            </DialogHeader>
            <DialogFooter>
                <Button @click="handleDelete(category.id)">
                    Confirm
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
