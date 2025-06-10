<template>
    <AuthenticatedLayout>
        <template #default>
            <div>
                <div class="mb-4 flex flex-wrap gap-4 items-end">
                    <InputText v-model="filters.name" placeholder="Nome do Jogo" class="w-64" />
                    <Select
                        v-model="filters.category"
                        :options="categories"
                        optionLabel="label"
                        placeholder="Categoria"
                        class="w-64"
                    />
                    <Button label="Filtrar" icon="pi pi-filter" @click="loadProducts" />
                    <Button
                        label="Adicionar Jogo"
                        icon="pi pi-plus"
                        @click="goToCreate"
                    />
                </div>

                <DataTable
                    :value="products"
                    :paginator="true"
                    :rows="rows"
                    :totalRecords="totalRecords"
                    :lazy="true"
                    :loading="loading"
                    :first="first"
                    @page="onPage"
                    dataKey="id"
                    responsiveLayout="scroll"
                >
                    <Column field="image" header="Imagem" style="width: 120px">
                        <template #body="slotProps">
                            <img :src="slotProps.data.image" alt="Produto" class="w-24 h-24 object-cover rounded shadow" />
                        </template>
                    </Column>

                    <Column field="name" header="Nome" />
                    <Column field="category" header="Categoria" />
                    <Column field="price" header="Preço">
                        <template #body="slotProps">
                            R$ {{ slotProps.data.price.toFixed(2) }}
                        </template>
                    </Column>
                    <Column field="stock" header="Estoque" />
                </DataTable>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePage,router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'

const page = usePage()
const user = page.props.auth.user

const products = ref([])
const totalRecords = ref(0)
const loading = ref(false)
const rows = 10
const first = ref(0)

const filters = ref({
    name: '',
    category: null
})

const categories = [
    {label: 'Boardgame', value: 'boardgame'},
    {label: 'Card Games', value: 'cardgame'},
    {label: 'Party Games', value: 'party'}
]

const goToCreate = () => {
    router.visit(route('games.create'))
}

const loadProducts = async (page = 1) => {
    loading.value = true
    try {
        // Simulando dados fictícios (mock)
        const mockData = [
            {
                id: 1,
                name: 'Catan',
                category: 'Boardgame',
                price: 289.90,
                stock: 12,
                image: 'https://upload.wikimedia.org/wikipedia/en/2/2d/Catan-2015-boxart.jpg'
            },
            {
                id: 2,
                name: 'Uno',
                category: 'Card Games',
                price: 29.90,
                stock: 50,
                image: 'https://upload.wikimedia.org/wikipedia/en/f/f9/UNO_Logo.png'
            },
            {
                id: 3,
                name: 'Dixit',
                category: 'Party Games',
                price: 159.90,
                stock: 8,
                image: 'https://upload.wikimedia.org/wikipedia/en/b/b0/Dixit_game.jpg'
            },
            {
                id: 4,
                name: 'Azul',
                category: 'Boardgame',
                price: 199.90,
                stock: 20,
                image: 'https://upload.wikimedia.org/wikipedia/en/0/0e/Azul_game_box.jpg'
            },
            {
                id: 5,
                name: 'Exploding Kittens',
                category: 'Card Games',
                price: 79.90,
                stock: 15,
                image: 'https://upload.wikimedia.org/wikipedia/en/a/a1/Exploding_Kittens.jpg'
            }
        ]

        // Paginação mock
        products.value = mockData.slice((page - 1) * rows, page * rows)
        totalRecords.value = mockData.length
        first.value = (page - 1) * rows
    } finally {
        loading.value = false
    }
}

const onPage = (event) => {
    const page = event.page + 1
    loadProducts(page)
}

onMounted(() => {
    loadProducts()
})
</script>
