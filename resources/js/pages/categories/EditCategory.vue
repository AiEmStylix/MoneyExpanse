<!-- resources/js/Pages/categories/EditCategory.vue -->
<script setup lang="ts">
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { ArrowLeft } from 'lucide-vue-next'
import { Link } from '@inertiajs/vue3'

interface Category {
    id: number
    name: string
    user_id: number | null
    is_system: boolean
    created_at: string
}

const props = defineProps<{
    category: Category
}>()

const form = useForm({
    name: props.category.name,
})

const submit = () => {
    form.patch(`/categories/${props.category.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Category updated successfully')
        },
        onError: (errors) => {
            console.error(errors)
        }
    })
}
</script>

<template>
    <AppLayout>
        <div class="flex flex-col w-full max-w-2xl mx-auto p-6 space-y-4">
            <Button variant="ghost" size="sm" as-child class="w-fit">
                <Link href="/categories">
                <ArrowLeft class="w-4 h-4 mr-2" />
                Back to Categories
                </Link>
            </Button>

            <Card>
                <CardHeader>
                    <CardTitle>Edit Category</CardTitle>
                    <CardDescription>
                        Update the category name
                    </CardDescription>
                </CardHeader>
                <form @submit.prevent="submit">
                    <CardContent class="space-y-4">
                        <div class="space-y-2">
                            <Label for="name">Category Name</Label>
                            <Input id="name" v-model="form.name" type="text" placeholder="Enter category name"
                                :disabled="form.processing" required />
                            <p v-if="form.errors.name" class="text-sm text-red-600">
                                {{ form.errors.name }}
                            </p>
                        </div>
                    </CardContent>
                    <CardFooter class="flex justify-between mt-2">
                        <Button type="button" variant="outline" as-child>
                            <Link href="/categories">
                            Cancel
                            </Link>
                        </Button>
                        <Button type="submit" :disabled="form.processing">
                            {{ form.processing ? 'Updating...' : 'Update Category' }}
                        </Button>
                    </CardFooter>
                </form>
            </Card>
        </div>
    </AppLayout>
</template>