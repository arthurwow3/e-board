<template>
    <GuestLayout>
        <Card style="width: 100%; max-width: 400px" class="shadow-4 border-round-xl">
            <template #title>
                <div class="text-center text-xl font-semibold text-gray-900">
                    Criar conta no E-Board
                </div>
            </template>

            <template #content>
                <form @submit.prevent="submit" class="flex flex-col gap-4 text-gray-900">
                    <div>
                        <label for="name" class="block mb-1 text-sm">Nome</label>
                        <InputText id="name" v-model="form.name" class="w-full" />
                        <small v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</small>
                    </div>

                    <div>
                        <label for="email" class="block mb-1 text-sm">Email</label>
                        <InputText id="email" v-model="form.email" type="email" class="w-full" />
                        <small v-if="form.errors.email" class="text-red-500">{{ form.errors.email }}</small>
                    </div>

                    <div>
                        <label for="password" class="block mb-1 text-sm">Senha</label>
                        <Password
                            id="password"
                            v-model="form.password"
                            toggleMask
                            :feedback="false"
                            autocomplete="new-password"
                            inputClass="w-full pr-10"
                            class="w-full"
                        />
                        <small v-if="form.errors.password" class="text-red-500">{{ form.errors.password }}</small>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block mb-1 text-sm">Confirmar senha</label>
                        <Password
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            toggleMask
                            feedback="false"
                            autocomplete="new-password"
                            inputClass="w-full pr-10"
                            class="w-full"
                        />
                        <small v-if="form.errors.password_confirmation" class="text-red-500">
                            {{ form.errors.password_confirmation }}
                        </small>
                    </div>

                    <Button type="submit" label="Registrar" class="w-full mt-2" />

                    <div class="text-center mt-3 text-sm">
                        <Link :href="route('login')" class="text-blue-500 hover:underline">
                            Já tem uma conta? Entrar
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
import Button from 'primevue/button'
import Card from 'primevue/card'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: ''
})

function submit() {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation')
    })
}
</script>
