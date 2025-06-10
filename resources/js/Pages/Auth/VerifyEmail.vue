<template>
    <GuestLayout>
        <Card style="width: 100%; max-width: 480px" class="shadow-4 border-round-xl">
            <template #title>
                <div class="text-center text-xl font-semibold text-gray-900">
                    Verificação de E-mail
                </div>
            </template>

            <template #content>
                <p class="mb-4 text-gray-800">
                    Enviamos um link de verificação para seu endereço de e-mail.
                    Por favor, clique no link para ativar sua conta.
                </p>

                <p v-if="status === 'verification-link-sent'" class="text-green-600 mb-3">
                    ✅ Um novo link foi enviado para o seu e-mail.
                </p>

                <form @submit.prevent="resend">
                    <Button type="submit" label="Reenviar e-mail de verificação" class="w-full" />
                </form>

                <form @submit.prevent="logout" class="mt-3 text-center">
                    <Button type="submit" label="Sair" severity="secondary" class="w-full" />
                </form>
            </template>
        </Card>
    </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

import Button from 'primevue/button'
import Card from 'primevue/card'

defineProps({
    status: String
})

const resendForm = useForm()
const logoutForm = useForm()

function resend() {
    resendForm.post(route('verification.send'))
}

function logout() {
    logoutForm.post(route('logout'))
}
</script>
