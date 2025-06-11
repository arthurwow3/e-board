<template>
    <AuthenticatedLayout>
        <template #default>
            <div>
                <div class="mb-4 flex flex-wrap gap-4 items-end">
                    <InputText v-model="filters.name" placeholder="Nome do Jogo" class="w-64" />
                    <Select v-model="filters.publisher_id" showClear :options="publisherOptions" optionLabel="label" optionValue="value" placeholder="Editora" class="w-64" />
                    <Select v-model="filters.genre_id" showClear :options="genreOptions" optionLabel="label" optionValue="value" placeholder="Gênero" class="w-64" />
                    <Calendar v-model="filters.purchase_date" dateFormat="dd/mm/yy" placeholder="Data de Aquisição" class="w-64" />
                    <Button label="Filtrar" icon="pi pi-filter" @click="() => loadGames(1)" />
                    <Button
                        label="Limpar"
                        icon="pi pi-times"
                        severity="secondary"
                        outlined
                        @click="resetFilters"
                    />
                    <Button
                        label="Adicionar Jogo"
                        icon="pi pi-plus"
                        @click="goToCreate"
                    />
                </div>

                <DataTable
                    :value="games"
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
                    <Column header="Ícone" style="width: 80px">
                        <template #body="slotProps">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-100 rounded overflow-hidden">
                                <template v-if="slotProps.data.icon_url">
                                    <img
                                        :src="slotProps.data.icon_url"
                                        alt="Ícone do Jogo"
                                        class="w-full h-full object-contain"
                                        @error="event => event.target.style.display = 'none'"
                                    />
                                </template>
                                <template v-else>
                                    <i class="pi pi-image text-gray-400 text-xl"></i>
                                </template>
                            </div>
                        </template>
                    </Column>

                    <Column field="title" header="Nome" />
                    <Column field="publisher" header="Editora" />
                    <Column field="genre" header="Categoria" />
                    <Column field="purchase_price" header="Preço de Compra">
                        <template #body="slotProps">
                            R$ {{ (slotProps.data.purchase_price ?? 0) }}
                        </template>
                    </Column>
                    <Column header="Ações" style="width: 100px; text-align: center;">
                        <template #body="slotProps">
                            <div class="flex justify-center gap-2">
                                <!-- Botão Editar -->
                                <Button
                                    icon="pi pi-pencil"
                                    severity="secondary"
                                    outlined
                                    rounded
                                    size="small"
                                    @click="editGame(slotProps.data.id)"
                                />

                                <!-- Botão Excluir -->
                                <Button
                                    icon="pi pi-trash"
                                    severity="danger"
                                    outlined
                                    rounded
                                    size="small"
                                    @click="confirmDelete(slotProps.data.id)"
                                />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </template>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage,router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputText from 'primevue/inputtext'
import Button from 'primevue/button'
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import ConfirmDialog from 'primevue/confirmdialog';
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast';

const confirm = useConfirm();
const toast = useToast();


const page = usePage();
const games = computed(() => page.props.games?.data || []);
const totalRecords = computed(() => page.props.games?.meta?.total || 0);
const first = computed(() => (page.props.games?.meta?.current_page - 1) * page.props.games?.meta?.per_page || 0);
const user = page.props.auth.user
const loading = ref(false)
const rows = 10

const defaultFilters = {
    name: '',
    publisher_id: null,
    genre_id: null,
    purchase_date: null,
};

const filters = ref({ ...defaultFilters });

const resetFilters = () => {
    filters.value = { ...defaultFilters };
    router.visit(route('games.index'), {
        preserveScroll: true,
        replace: true,
    });
};
const confirmDelete = (id) => {
    confirm.require({
        message: 'Tem certeza que deseja excluir este jogo?',
        header: 'Confirmação',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Sim',
            severity: 'danger'
        },
        accept: () => {
            router.delete(route('games.destroy', id), {
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Sucesso',
                        detail: 'Jogo excluído com sucesso.',
                        life: 3000
                    });
                },
                onError: () => {
                    toast.add({
                        severity: 'error',
                        summary: 'Erro',
                        detail: 'Não foi possível excluir o jogo.',
                        life: 3000
                    });
                }
            });
        }
    });
};

const publisherOptions = page.props.publishers.map(p => ({ label: p.name, value: p.id }));
const genreOptions = page.props.genres.map(g => ({ label: g.name, value: g.id }));

const goToCreate = () => {
    router.visit(route('games.create'))
}

const loadGames = (page = 1) => {
    router.get(route('games.index'), {
        page,
        ...filters.value
    }, {
        preserveState: true,
        replace: true,
    });
};

const onPage = (event) => {
    const pageNumber = event.page + 1;
    loadGames(pageNumber);
};

const editGame = (id) => {
    router.visit(route('games.edit', id));
};

</script>
