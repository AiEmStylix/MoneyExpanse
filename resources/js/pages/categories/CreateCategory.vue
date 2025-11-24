<script setup lang="ts">
import { Button } from '@/components/ui/button'
import {
    Field,
    FieldDescription,
    FieldError,
    FieldGroup,
    FieldLabel,
} from '@/components/ui/field'
import { Input } from '@/components/ui/input'

import AppLayout from '@/layouts/AppLayout.vue'

import { useForm } from '@inertiajs/vue3'
const form = useForm({
    name: '',
})

const submit = () => {
    form.post('/categories', {
        onSuccess: () => {
            form.reset()
        },

    })
}
</script>

<template>
    <AppLayout>
        <div class="mx-auto my-auto w-full max-w-md ">
            <form @submit.prevent="submit">
                <FieldGroup>
                    <Field>
                        <FieldLabel for="name">Category Name</FieldLabel>
                        <Input v-model="form.name" id="name" placeholder="Enter category name" type="text" />
                        <FieldDescription>
                            Adding new category to manage your expenses better.
                        </FieldDescription>
                    </Field>
                    <FieldError>{{ form.errors.name }}</FieldError>
                    <Field orientation="horizontal">
                        <Button type="submit">
                            Submit
                        </Button>
                        <Button variant="outline" type="button">
                            Cancel
                        </Button>
                    </Field>
                </FieldGroup>
            </form>
        </div>
    </AppLayout>
</template>
