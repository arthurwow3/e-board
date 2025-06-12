<template>
    <AuthenticatedLayout>
        <Card>
            <template #title>{{ isEditMode ? 'Editar Jogo' : 'Cadastro de Jogo' }}</template>

            <template #content>
                <hr class="mb-4 border-gray-300"/>
                <Form
                    ref="formRef"
                    v-slot="$form"
                    :initialValues="form"
                    :validateOnBlur="true"
                    :resolver="resolver"

                    @submit="onFormSubmit"
                >
                    <!-- Características -->
                    <section class="mb-8">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="pi pi-info-circle text-gray-600"></i>
                            <h2 class="text-lg font-semibold text-gray-700">Características</h2>
                        </div>

                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="title" class="block text-sm text-gray-500 mb-1">Título</label>
                                <InputText id="title" name="title" class="w-full"/>
                                <Message v-if="$form.title?.invalid" severity="error" size="small" variant="simple">
                                    {{ $form.title.error.message }}
                                </Message>
                            </div>

                            <div>
                                <label for="publisher_id" class="block text-sm text-gray-500 mb-1">Editora</label>
                                <Select id="publisher_id" name="publisher_id" :options="publisherOptions"
                                        optionLabel="name" optionValue="id" placeholder="Selecione a Editora"
                                        class="w-full"/>
                                <Message v-if="$form.publisher_id?.invalid" severity="error" size="small"
                                         variant="simple">
                                    {{ $form.publisher_id.error.message }}
                                </Message>
                            </div>

                            <div>
                                <label for="genre_id" class="block text-sm text-gray-500 mb-1">Gênero</label>
                                <Select id="genre_id" name="genre_id" :options="genreOptions" optionLabel="name"
                                        optionValue="id" placeholder="Selecione um Gênero" class="w-full"/>
                                <Message v-if="$form.genre_id?.invalid" severity="error" size="small" variant="simple">
                                    {{ $form.genre_id.error.message }}
                                </Message>
                            </div>

                            <div>
                                <label for="players_range" class="block text-sm text-gray-500 mb-2">Número de
                                    Jogadores</label>
                                <Slider id="players_range" name="players_range" :min="0" :max="10" range
                                        class="w-full"/>
                                <div class="flex justify-between text-sm text-gray-400 mt-1">
                                    <span>Mín: {{ $form.players_range?.value?.[0] ?? 0 }}</span>
                                    <span>Máx: {{ $form.players_range?.value?.[1] ?? 0 }}</span>
                                </div>
                                <Message v-if="$form.players_range?.invalid" severity="error" size="small"
                                         variant="simple">
                                    {{ $form.players_range.error.message }}
                                </Message>
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm text-gray-500 mb-1">Descrição</label>
                                <Textarea id="description" name="description" autoResize rows="4" class="w-full"/>
                                <Message v-if="$form.description?.invalid" severity="error" size="small"
                                         variant="simple">
                                    {{ $form.description.error.message }}
                                </Message>
                            </div>
                        </div>
                    </section>

                    <!-- Financeiro -->
                    <section class="mb-8">
                        <hr class="mb-4 border-gray-300"/>
                        <div class="flex items-center gap-2 mb-4">
                            <i class="pi pi-dollar text-gray-600"></i>
                            <h2 class="text-lg font-semibold text-gray-700">Financeiro</h2>
                        </div>

                        <div class="grid md:grid-cols-4 gap-4">
                            <div>
                                <label for="purchase_price" class="block text-sm text-gray-500 mb-1">Preço de Compra
                                    (R$)</label>
                                <InputNumber id="purchase_price" name="purchase_price" mode="currency" currency="BRL"
                                             locale="pt-BR" class="w-full"/>
                                <Message v-if="$form.purchase_price?.invalid" severity="error" size="small"
                                         variant="simple">
                                    {{ $form.purchase_price.error.message }}
                                </Message>
                            </div>
                            <div>
                                <label for="purchase_date" class="block text-sm text-gray-500 mb-1">Data de
                                    Compra</label>
                                <Calendar id="purchase_date" name="purchase_date" dateFormat="dd/mm/yy" showIcon
                                          class="w-full"/>
                            </div>
                            <div>
                                <label for="sale_price" class="block text-sm text-gray-500 mb-1">Preço de Venda
                                    (R$)</label>
                                <InputNumber id="sale_price" name="sale_price" mode="currency" currency="BRL"
                                             locale="pt-BR" class="w-full"/>
                            </div>
                            <div>
                                <label for="asset_costs" class="block text-sm text-gray-500 mb-1">Custos com Assets
                                    (R$)</label>
                                <InputNumber id="asset_costs" name="asset_costs" mode="currency" currency="BRL"
                                             locale="pt-BR" class="w-full"/>
                            </div>
                        </div>
                    </section>

                    <!-- Outros -->
                    <section>
                        <hr class="mb-4 border-gray-300"/>
                        <div class="flex items-center gap-2 mb-4">
                            <i class="pi pi-cog text-gray-600"></i>
                            <h2 class="text-lg font-semibold text-gray-700">Outros</h2>
                        </div>


                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label for="sleeves" class="block text-sm text-gray-500 mb-1">Quantidade de
                                    Sleeves</label>
                                <InputNumber id="sleeves" name="sleeves" :min="0" class="w-full"/>
                            </div>
                            <div>
                                <label for="sleeve_size" class="block text-sm text-gray-500 mb-1">Tamanho da
                                    Sleeve</label>
                                <Select id="sleeve_size" name="sleeve_size" :options="sleeveSizes"
                                        placeholder="Selecione o Tamanho" class="w-full"/>
                            </div>
                            <div class="md:col-span-2">
                                <label for="images" class="block text-sm text-gray-500 mb-1">Imagens do Jogo</label>
                                <input type="file" id="images" name="images" multiple accept="image/*"
                                       @change="handleFileChange($event, 'images')"
                                       class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"/>
                            </div>
                            <div v-if="form.image_previews.length" class="grid grid-cols-2 gap-4 my-4">
                                <div v-for="(img, index) in form.image_previews" :key="img.id" class="relative">
                                    <img :src="img.url" class="w-full h-32 object-cover rounded shadow" />
                                    <Button icon="pi pi-times"
                                            class="absolute top-1 right-1 p-button-rounded p-button-danger p-button-sm"
                                            @click="removeImagePreview(index)" />
                                </div>
                            </div>
                            <div class="md:col-span-2">
                                <label for="icon" class="block text-sm text-gray-500 mb-1">Ícone do Jogo</label>
                                <input type="file" id="icon" name="icon" accept="image/*"
                                       @change="handleFileChange($event, 'icon')"
                                       class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"/>
                            </div>
                            <div v-if="form.icon_preview" class="mb-4">
                                <img :src="form.icon_preview" alt="Ícone atual" class="w-32 h-32 object-cover rounded" />
                                <Button label="Remover Ícone" icon="pi pi-times" severity="danger" outlined class="mt-2"
                                        @click="form.icon_preview = null" />
                            </div>
                        </div>
                    </section>

                    <div class="flex justify-end mt-8">
                        <Button label="Salvar" icon="pi pi-save" type="submit"
                                class="w-full md:w-auto bg-green-600 text-white"/>
                    </div>
                </Form>

                <Toast/>
            </template>
        </Card>
    </AuthenticatedLayout>
</template>


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref, computed, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import { useConfirm } from 'primevue/useconfirm';

const toast = useToast();
const confirm = useConfirm();
const page = usePage();

const props = defineProps({
    game: Object
});

const isEditMode = computed(() => !!props.game);

// Combos fixos
const publisherOptions = [
    { id: 1, name: 'Galápagos' },
    { id: 2, name: 'Devir' },
    { id: 3, name: 'Meeple BR' }
];

const genreOptions = [
    { id: 1, name: 'Estratégia' },
    { id: 2, name: 'Party Game' },
    { id: 3, name: 'Família' },
    { id: 4, name: 'Cooperativo' }
];

const sleeveSizes = ['P', 'M', 'G', 'GG'];

const form = useForm({
    title: props.game?.title ?? '',
    description: props.game?.description ?? '',
    players_range: props.game ? [props.game.players_min ?? 0, props.game.players_max ?? 0] : [2, 6],
    publisher_id: props.game?.publisher_id ?? null,
    genre_id: props.game?.genre_id ?? null,
    purchase_price: props.game?.purchase_price ?? null,
    purchase_date: props.game?.purchase_date ?? '',
    sale_price: props.game?.sale_price ?? null,
    sleeves: props.game?.sleeves ?? null,
    asset_costs: props.game?.asset_costs ?? null,
    sleeve_size: props.game?.sleeve_size ?? null,
    icon: null,
    icon_preview: props.game?.icon_url ?? null,
    images: [],
    image_previews: props.game?.images ?? [] // array de { id, url }
});

const removeImagePreview = (index) => {
    form.image_previews.splice(index, 1);
};

const handleFileChange = (event, field) => {
    const files = event.target.files;
    if (field === 'images') {
        form.images = Array.from(files);
    } else if (field === 'icon') {
        form.icon = files[0] || null;
    }
};

const resolver = ({ values }) => {
    const errors = {};
    if (!values.title) errors.title = [{ message: 'Título é obrigatório.' }];
    if (!values.publisher_id) errors.publisher_id = [{ message: 'Editora é obrigatória.' }];
    if (!values.genre_id) errors.genre_id = [{ message: 'Gênero é obrigatório.' }];
    if (!values.description) errors.description = [{ message: 'Descrição é obrigatória.' }];
    if (!values.purchase_price) errors.purchase_price = [{ message: 'Preço de compra é obrigatório.' }];
    if (!values.players_range || values.players_range[0] === values.players_range[1]) {
        errors.players_range = [{ message: 'Defina um intervalo válido de jogadores.' }];
    }
    return { errors };
};

const onFormSubmit = (e) => {
    if (e.valid && e.states) {
        const values = Object.fromEntries(
            Object.entries(e.states).map(([key, state]) => [key, state.value])
        );
        Object.entries(values).forEach(([key, val]) => {
            form[key] = val;
        });
        confirmarSave();
    } else {
        toast.add({
            severity: 'error',
            summary: 'Formulário inválido',
            detail: 'Por favor, corrija os erros antes de salvar.',
            life: 3000
        });
    }
};

const confirmarSave = () => {
    confirm.require({
        message: isEditMode.value
            ? 'Deseja realmente atualizar este jogo?'
            : 'Deseja realmente salvar este jogo?',
        header: isEditMode.value ? 'Atualizar Jogo' : 'Salvar Jogo',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: isEditMode.value ? 'Atualizar' : 'Salvar'
        },
        accept: () => {
            postGame();
        },
        reject: () => {
            toast.add({
                severity: 'warn',
                summary: 'Cancelado',
                detail: isEditMode.value ? 'Atualização cancelada' : 'Cadastro cancelado',
                life: 3000
            });
        }
    });
};

const postGame = async () => {
    const options = {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Sucesso',
                detail: isEditMode.value
                    ? 'Jogo atualizado com sucesso!'
                    : 'Jogo cadastrado com sucesso!',
                life: 3000
            });

            if (!isEditMode.value) {
                form.reset();
            }
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Erro',
                detail: isEditMode.value
                    ? 'Erro ao atualizar o jogo.'
                    : 'Erro ao cadastrar o jogo.',
                life: 3000
            });
        }
    };

    if (isEditMode.value) {
        form.image_previews.forEach((img, index) => {
            form[`image_previews[${index}][id]`] = img.id;
            form[`image_previews[${index}][url]`] = img.url;
        });
        await form.post(route('games.update', props.game.id), options);

        form.image_previews.forEach((img, index) => {
            delete form[`image_previews[${index}][id]`];
            delete form[`image_previews[${index}][url]`];
        });

    } else {
        await form.post(route('games.store'), options);
    }
};
</script>

