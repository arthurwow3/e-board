<template>
    <div class="p-6">
        <h2 class="text-2xl mb-4">🎨 PrimeVue com tema Aura</h2>

        <div class="p-fluid grid formgrid">
            <div class="field col-12 md:col-6">
                <label for="nome">Nome</label>
                <InputText id="nome" v-model="form.nome" />
            </div>

            <div class="field col-12 md:col-6">
                <label for="email">Email</label>
                <InputText id="email" type="email" v-model="form.email" />
            </div>

            <div class="field col-12 md:col-6">
                <label for="data">Data</label>
                <Calendar id="data" v-model="form.data" showIcon />
            </div>

            <div class="field col-12 md:col-6">
                <label for="opcao">Opção</label>
                <Dropdown
                    id="opcao"
                    v-model="form.opcao"
                    :options="opcoes"
                    optionLabel="label"
                    placeholder="Selecione"
                />
            </div>

            <div class="field col-12">
                <Button label="Enviar" icon="pi pi-check" @click="enviar" />
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';

const form = ref({
    nome: '',
    email: '',
    data: null,
    opcao: null
});

const opcoes = [
    { label: 'Opção A', value: 'A' },
    { label: 'Opção B', value: 'B' },
    { label: 'Opção C', value: 'C' }
];

function enviar() {
    console.log('Form enviado:', form.value);
}
</script>
