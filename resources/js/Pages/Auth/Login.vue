<template>
    <GuestLayout>
        <Card style="width: 100%; max-width: 400px" class="shadow-4 border-round-xl">
            <template #title>
                <div class="text-center text-xl font-semibold text-gray-900">
                    Entrar no e-Board
                </div>
            </template>

            <template #content>
                <Form
                    as="form"
                    v-slot="$form"
                    :initial-values="form"
                    :resolver="resolver"
                    @submit="onSubmit"
                    class="flex flex-col gap-4 text-gray-900"
                >
                    <div>
                        <label for="email" class="block mb-1 text-sm">Email</label>
                        <InputText
                            id="email"
                            name="email"
                            type="email"
                            autocomplete="username"
                            class="w-full"
                        />
                        <Message v-if="$form.email?.invalid" severity="error" size="small" variant="simple">
                            {{ $form.email.error.message }}
                        </Message>
                    </div>

                    <div>
                        <label for="password" class="block mb-1 text-sm">Senha</label>
                        <Password
                            id="password"
                            name="password"
                            toggleMask
                            :feedback="false"
                            autocomplete="current-password"
                            inputClass="w-full pr-10"
                            class="w-full"
                        />
                        <Message v-if="$form.password?.invalid" severity="error" size="small" variant="simple">
                            {{ $form.password.error.message }}
                        </Message>
                    </div>

                    <div class="flex items-center gap-2">
                        <Checkbox v-model="form.remember" :binary="true" inputId="remember" />
                        <label for="remember" class="text-sm">Lembrar de mim</label>
                    </div>

                    <Button type="submit" label="Entrar" class="w-full mt-2" />

                    <Message v-if="errors.email" severity="error" class="text-center mt-2">
                        {{ errors.email }}
                    </Message>

                    <div class="mb-4" v-if="Object.keys(form.errors).length">
                        <p class="text-sm text-red-500">Something went wrong!</p>
                        <ul class="ml-4 list-disc list-inside">
                            <li
                                v-for="(error, i) in errors"
                                :key="i"
                                class="text-sm text-red-500"
                            >
                                {{ error }}
                            </li>
                        </ul>
                    </div>

                    <div class="flex justify-between mt-3 text-sm">
                        <Link v-if="canResetPassword" :href="route('password.request')" class="text-blue-500 hover:underline">
                            Esqueceu a senha?
                        </Link>
                        <Link :href="route('register')" class="text-blue-500 hover:underline">
                            Me registrar
                        </Link>
                    </div>
                </Form>
            </template>
        </Card>
    </GuestLayout>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, Link } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue'

import InputText from 'primevue/inputtext'
import Password from 'primevue/password'
import Checkbox from 'primevue/checkbox'
import Button from 'primevue/button'
import Card from 'primevue/card'
import Message from 'primevue/message'

defineProps({
    canResetPassword: Boolean,
    status: String,
    errors: Object
})

const form = useForm({
    email: '',
    password: '',
    remember: false
})

const backendError = ref(null)

// Validação manual (sem yup)
const resolver = ({ values }) => {
    const errors = {}

    if (!values.email) {
        errors.email = [{ message: 'O e-mail é obrigatório.' }]
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(values.email)) {
        errors.email = [{ message: 'O e-mail informado é inválido.' }]
    }

    if (!values.password) {
        errors.password = [{ message: 'A senha é obrigatória.' }]
    }

    return { errors }
}


function onSubmit(e) {
    if (!e.valid || !e.states) return

    form.email = e.states.email.value
    form.password = e.states.password.value
    console.log(form)
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>
