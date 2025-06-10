<template>
    <Form
        ref="formRef"
        v-slot="$form"
        :initialValues="initialValues"
        :resolver="resolver"
        :validateOnValueUpdate="false"
        :validateOnBlur="true"
    >
        <div class="grid gap-4">
            <!-- Primeira Linha: Título e Editora -->
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label for="title" class="block text-sm text-gray-500 mb-1">Título - {{ $form.valid }}</label>
                    <InputText id="title" name="title" class="w-full" />
                    <Message
                        v-if="$form.title?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                    >{{ $form.title.error.message }}</Message>
                </div>

                <div>
                    <label for="publisher_id" class="block text-sm text-gray-500 mb-1">Editora</label>
                    <Select
                        id="publisher_id"
                        name="publisher_id"
                        :options="publisherOptions"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="Selecione a Editora"
                        class="w-full"
                    />
                    <Message
                        v-if="$form.publisher_id?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                    >{{ $form.publisher_id.error.message }}</Message>
                </div>
            </div>

            <!-- Segunda Linha: Gênero e Jogadores -->
            <div class="grid md:grid-cols-2 gap-4 items-end">
                <div>
                    <label for="genre_id" class="block text-sm text-gray-500 mb-1">Gênero</label>
                    <Select
                        id="genre_id"
                        name="genre_id"
                        :options="genreOptions"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="Selecione um Gênero"
                        class="w-full"
                    />
                    <Message
                        v-if="$form.genre_id?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                    >{{ $form.genre_id.error.message }}</Message>
                </div>

                <div>
                    <label for="players_range" class="block text-sm text-gray-500 mb-2">Número de Jogadores</label>
                    <Slider
                        id="players_range"
                        name="players_range"
                        :min="0"
                        :max="10"
                        range
                        class="w-full"
                    />
                    <div class="flex justify-between text-sm text-gray-400 mt-1">
                        <span>Mín: {{ $form.players_range?.value?.[0] ?? 0 }}</span>
                        <span>Máx: {{ $form.players_range?.value?.[1] ?? 0 }}</span>
                    </div>
                    <Message
                        v-if="$form.players_range?.invalid"
                        severity="error"
                        size="small"
                        variant="simple"
                    >{{ $form.players_range.error.message }}</Message>
                </div>
            </div>
            <input type="hidden" :value="emitValid($form.valid)" />
            <!-- Descrição -->
            <div>
                <label for="description" class="block text-sm text-gray-500 mb-1">Descrição</label>
                <Textarea id="description" name="description" autoResize rows="4" class="w-full" />
                <Message
                    v-if="$form.description?.invalid"
                    severity="error"
                    size="small"
                    variant="simple"
                >{{ $form.description.error.message }}</Message>
            </div>
        </div>
    </Form>
</template>

<script setup>
import {ref, onMounted, watch} from 'vue'
import InputText from 'primevue/inputtext'
import Select from 'primevue/select'
import Slider from 'primevue/slider'
import Textarea from 'primevue/textarea'
import Message from 'primevue/message'
import { Form } from '@primevue/forms'

const emit = defineEmits(['form-mounted', 'valid'])
const wasTouched = ref(false)
const formRef = ref()

const initialValues = ref({
    title: '',
    description: '',
    players_range: [1, 4],
    publisher_id: null,
    genre_id: null
})

onMounted(async () => {
    emit('form-mounted', formRef.value)
    emit('valid', false) // estado inicial validado
})

const publisherOptions = [
    { id: 1, name: 'Galápagos' },
    { id: 2, name: 'Devir' },
    { id: 3, name: 'Meeple BR' }
]

const genreOptions = [
    { id: 1, name: 'Estratégia' },
    { id: 2, name: 'Party Game' },
    { id: 3, name: 'Família' },
    { id: 4, name: 'Cooperativo' }
]

const resolver = ({ values }) => {
    const errors = {}

    if (!values.title) {
        errors.title = [{ message: 'Título é obrigatório.' }]
    }

    if (!values.publisher_id) {
        errors.publisher_id = [{ message: 'Editora é obrigatória.' }]
    }

    if (!values.genre_id) {
        errors.genre_id = [{ message: 'Gênero é obrigatório.' }]
    }

    if (
        !values.players_range ||
        values.players_range.length !== 2 ||
        values.players_range[0] === values.players_range[1]
    ) {
        errors.players_range = [{ message: 'Defina um intervalo válido de jogadores.' }]
    }

    if (!values.description) {
        errors.description = [{ message: 'Descrição é obrigatória.' }]
    }

    return { errors }
}

function emitValid(val) {
    console.log('emitvalid', val)
    emit('valid', val)
    return val // necessário para atualizar o DOM reativamente
}

</script>
