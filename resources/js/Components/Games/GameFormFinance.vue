<template>
    <Form
        v-slot="$form"
        :initialValues="initialValues"
        :resolver="resolver"
        :validateOnBlur="true"
        :validateOnValueUpdate="false"
        @submit="onSubmit"
    >
        <div class="grid md:grid-cols-4 gap-4">
            <!-- Preço de Compra -->
            <div>
                <label for="purchase_price" class="block text-sm text-gray-500 mb-1">Preço de Compra (R$)</label>
                <InputNumber
                    name="purchase_price"
                    inputId="purchase_price"
                    mode="currency"
                    currency="BRL"
                    locale="pt-BR"
                    class="w-full"
                />
                <Message
                    v-if="$form.purchase_price?.invalid"
                    severity="error"
                    size="small"
                    variant="simple"
                >{{ $form.purchase_price.error.message }}</Message>
            </div>

            <!-- Data de Compra -->
            <div>
                <label for="purchase_date" class="block text-sm text-gray-500 mb-1">Data de Compra</label>
                <Calendar
                    name="purchase_date"
                    inputId="purchase_date"
                    dateFormat="dd/mm/yy"
                    showIcon
                    class="w-full"
                />
            </div>

            <!-- Preço de Venda -->
            <div>
                <label for="sale_price" class="block text-sm text-gray-500 mb-1">Preço de Venda (R$)</label>
                <InputNumber
                    name="sale_price"
                    inputId="sale_price"
                    mode="currency"
                    currency="BRL"
                    locale="pt-BR"
                    class="w-full"
                />
            </div>

            <!-- Custo com Assets -->
            <div>
                <label for="asset_costs" class="block text-sm text-gray-500 mb-1">Custos com Assets (R$)</label>
                <InputNumber
                    name="asset_costs"
                    inputId="asset_costs"
                    mode="currency"
                    currency="BRL"
                    locale="pt-BR"
                    class="w-full"
                />
            </div>
        </div>

        <!-- Força reatividade e emissão -->
        <input type="hidden" :value="emitValid($form.valid)" />
        <input type="hidden" :value="emitValid($form.valid)" />
    </Form>
</template>

<script setup>
import InputNumber from 'primevue/inputnumber'
import Calendar from 'primevue/calendar'
import Message from 'primevue/message'
import { Form } from '@primevue/forms'
import { ref } from 'vue'

const emit = defineEmits(['valid'])

const initialValues = ref({
    purchase_price: null,
    purchase_date: '',
    sale_price: null,
    asset_costs: null
})

const onSubmit = () => {}

const resolver = ({ values }) => {
    const errors = {}

    if (!values.purchase_price) {
        errors.purchase_price = [{ message: 'Preço de compra é obrigatório.' }]
    }

    return { errors }
}

function emitValid(val) {
    emit('valid', val)
    return val
}
</script>
