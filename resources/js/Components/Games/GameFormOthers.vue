<template>
    <Form
        v-slot="$form"
        :initialValues="initialValues"
        :resolver="resolver"
        :validateOnBlur="true"
        :validateOnValueUpdate="false"
        @submit="onSubmit"
    >
        <div class="grid gap-4">
            <!-- Linha: Sleeves -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="sleeves" class="block text-sm text-gray-500 mb-1">Quantidade de Sleeves</label>
                    <InputNumber
                        name="sleeves"
                        inputId="sleeves"
                        :min="0"
                        class="w-full"
                    />
                    <Message
                        v-if="$form.sleeves?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                    >{{ $form.sleeves.error.message }}</Message>
                </div>

                <div>
                    <label for="sleeve_size" class="block text-sm text-gray-500 mb-1">Tamanho da Sleeve</label>
                    <Select
                        name="sleeve_size"
                        inputId="sleeve_size"
                        :options="sleeveSizes"
                        placeholder="Selecione o Tamanho"
                        class="w-full"
                    />
                    <Message
                        v-if="$form.sleeve_size?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                    >{{ $form.sleeve_size.error.message }}</Message>
                </div>
            </div>

            <!-- Imagens do jogo -->
            <div>
                <label for="images" class="block text-sm text-gray-500 mb-1">Imagens do Jogo</label>
                <input
                    type="file"
                    id="images"
                    multiple
                    accept="image/*"
                    @change="handleMultipleImages"
                    class="block w-full text-sm text-gray-600
               file:mr-4 file:py-2 file:px-4
               file:rounded file:border-0
               file:text-sm file:font-semibold
               file:bg-gray-100 file:text-gray-700
               hover:file:bg-gray-200"
                />
            </div>

            <!-- Ícone do jogo -->
            <div>
                <label for="icon" class="block text-sm text-gray-500 mb-1">Ícone do Jogo</label>
                <input
                    type="file"
                    id="icon"
                    accept="image/*"
                    @change="handleIconUpload"
                    class="block w-full text-sm text-gray-600
               file:mr-4 file:py-2 file:px-4
               file:rounded file:border-0
               file:text-sm file:font-semibold
               file:bg-gray-100 file:text-gray-700
               hover:file:bg-gray-200"
                />
            </div>
        </div>

        <!-- Força reatividade e emite validade -->
        <input type="hidden" :value="emitValid($form.valid)" />
    </Form>
</template>

<script setup>
import InputNumber from 'primevue/inputnumber'
import Select from 'primevue/select'
import Message from 'primevue/message'
import { Form } from '@primevue/forms'
import { ref } from 'vue'

const emit = defineEmits(['valid'])

const sleeveSizes = ['P', 'M', 'G', 'GG']

const initialValues = ref({
    sleeves: null,
    sleeve_size: null,
    images: [],
    icon: null
})

const onSubmit = () => {}

const resolver = ({ values }) => {
    const errors = {}

    if (values.sleeves === null || values.sleeves < 0) {
        errors.sleeves = [{ message: 'Informe uma quantidade válida de sleeves.' }]
    }

    if (!values.sleeve_size) {
        errors.sleeve_size = [{ message: 'Selecione o tamanho da sleeve.' }]
    }

    return { errors }
}

function emitValid(val) {
    emit('valid', val)
    return val
}

function handleMultipleImages(event) {
    initialValues.value.images = Array.from(event.target.files)
}

function handleIconUpload(event) {
    initialValues.value.icon = event.target.files?.[0] ?? null
}
</script>
