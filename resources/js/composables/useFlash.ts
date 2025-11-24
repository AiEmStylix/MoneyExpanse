// composables/useFlash.ts
import { usePage } from '@inertiajs/vue3'
import { onMounted } from 'vue'
import { toast } from 'vue-sonner'

export function useFlash() {
    const page = usePage()

    const showFlash = () => {
        const flash = page.props.flash
        if (!flash) return

        if (flash.success) toast.success(flash.success)
        if (flash.error) toast.error(flash.error)
        if (flash.warning) toast.warning(flash.warning)

    }
    showFlash()

    return { showFlash }
}