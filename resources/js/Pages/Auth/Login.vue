<template>
    <GuestLayout>
        <Card style="width: 100%; max-width: 400px" class="shadow-4 border-round-xl">
            <template #title>
                <div class="text-center text-xl font-semibold text-gray-900">
                    Entrar no e-Board
                </div>
            </template>

            <template #content>
                <form @submit.prevent="submit" class="flex flex-col gap-4 text-gray-900">
                    <div>
                        <label for="email" class="block mb-1 text-sm">Email</label>
                        <InputText id="email" v-model="form.email" type="email" autocomplete="username" class="w-full" />
                        <small v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</small>
                    </div>

                    <div>
                        <label for="password" class="block mb-1 text-sm">Senha</label>
                        <Password
                            id="password"
                            v-model="form.password"
                            toggleMask
                            :feedback="false"
                            autocomplete="current-password"
                            inputClass="w-full pr-10"
                            class="w-full"
                        />
                        <small v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</small>
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox v-model="form.remember" :binary="true" inputId="remember" />
                        <label for="remember" class="text-sm">Lembrar de mim</label>
                    </div>

                    <Button type="submit" label="Entrar" class="w-full mt-2" />

                    <div class="flex justify-between mt-3 text-sm">
                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-blue-500 hover:underline">
                            Esqueceu a senha?
                        </Link>
                        <Link :href="route('register')" class="text-blue-500 hover:underline">
                            Me registrar
                        </Link>
                    </div>
                </form>
            </template>
        </Card>
    </GuestLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'

import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Checkbox from 'primevue/checkbox'
import Button from 'primevue/button'
import Card from 'primevue/card'

defineProps({
    canResetPassword: Boolean,
    status: String
})

const form = useForm({
    email: '',
    password: '',
    remember: false
})

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password')
    })
}
</script>
