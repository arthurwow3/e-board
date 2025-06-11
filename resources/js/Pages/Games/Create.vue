<template>
    <AuthenticatedLayout>
        <Card>
            <template #title>Cadastro de Jogo</template>

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
                            <div class="md:col-span-2">
                                <label for="icon" class="block text-sm text-gray-500 mb-1">Ícone do Jogo</label>
                                <input type="file" id="icon" name="icon" accept="image/*"
                                       @change="handleFileChange($event, 'icon')"
                                       class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200"/>
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
import {ref} from 'vue'
import {useForm} from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import Card from 'primevue/card'
import Button from 'primevue/button'
import InputText from 'primevue/inputtext'
import Textarea from 'primevue/textarea'
import Select from 'primevue/select'
import Slider from 'primevue/slider'
import Calendar from 'primevue/calendar'
import InputNumber from 'primevue/inputnumber'
import Message from 'primevue/message'
import {Form} from '@primevue/forms'
import ConfirmDialog from 'primevue/confirmdialog'
import Toast from 'primevue/toast'
import {useToast} from 'primevue/usetoast'
import {useConfirm} from 'primevue/useconfirm'
import {onMounted} from 'vue';
import {usePage} from '@inertiajs/vue3';

const toast = useToast()
const confirm = useConfirm()
const page = usePage();

const activeTab = ref(0)
const tabs = [
    {label: 'Características', icon: 'pi pi-info-circle'},
    {label: 'Financeiro', icon: 'pi pi-dollar'},
    {label: 'Outros', icon: 'pi pi-cog'}
]

const publisherOptions = [
    {id: 1, name: 'Galápagos'},
    {id: 2, name: 'Devir'},
    {id: 3, name: 'Meeple BR'}
]

const genreOptions = [
    {id: 1, name: 'Estratégia'},
    {id: 2, name: 'Party Game'},
    {id: 3, name: 'Família'},
    {id: 4, name: 'Cooperativo'}
]

const sleeveSizes = ['P', 'M', 'G', 'GG']

const form = useForm({
    title: null,
    description: null,
    players_range: [2, 6],
    publisher_id: null,
    genre_id: null,
    purchase_price: null,
    purchase_date: '',
    sale_price: null,
    sleeves: null,
    asset_costs: null,
    sleeve_size: null,
    icon: null,
    images: []
})

const handleFileChange = (event, field) => {
    const files = event.target.files
    if (field === 'images') {
        form.images = Array.from(files)
    } else if (field === 'icon') {
        form.icon = files[0] || null
    }
}
const resolver = ({values}) => {
    const errors = {}
    if (!values.title) errors.title = [{message: 'Título é obrigatório.'}]
    if (!values.publisher_id) errors.publisher_id = [{message: 'Editora é obrigatória.'}]
    if (!values.genre_id) errors.genre_id = [{message: 'Gênero é obrigatório.'}]
    if (!values.description) errors.description = [{message: 'Descrição é obrigatória.'}]
    if (!values.purchase_price) errors.purchase_price = [{message: 'Preço de compra é obrigatória.'}]
    if (!values.players_range || values.players_range[0] === values.players_range[1]) {
        errors.players_range = [{message: 'Defina um intervalo válido de jogadores.'}]
    }
    return {errors}
}


onMounted(() => {
    const flash = page.props?.flash || {};

    if (flash.success) {
        toast.add({severity: 'success', summary: 'Sucesso', detail: flash.success, life: 3000});
    }

    if (flash.error) {
        toast.add({severity: 'error', summary: 'Erro', detail: flash.error, life: 4000});
    }
});

const onFormSubmit = (e) => {
    console.log('valid:', e.valid);
    console.log('states:', e.states);

    if (e.valid && e.states) {
        const values = Object.fromEntries(
            Object.entries(e.states).map(([key, state]) => [key, state.value])
        );
        console.log('extracted values:', values);

        // Atribui valores diretamente ao objeto `form`
        Object.entries(values).forEach(([key, val]) => {
            form[key] = val;
        });

        confirmarSave(); // segue para confirmação e post
    } else {
        toast.add({
            severity: 'error',
            summary: 'Formulário inválido',
            detail: 'Por favor, corrija os erros antes de salvar.',
            life: 3000
        });
    }
}


const confirmarSave = () => {
    console.log(123);
    confirm.require({
        message: 'Deseja realmente salvar esse jogo?',
        header: 'Confirmação',
        icon: 'pi pi-exclamation-triangle',
        rejectProps: {
            label: 'Cancelar',
            severity: 'secondary',
            outlined: true
        },
        acceptProps: {
            label: 'Sim'
        },
        accept: () => {
            postGame()
        },
        reject: () => {
            toast.add({severity: 'warn', summary: 'Cancelado', detail: 'Cadastro cancelado', life: 3000})
        }
    })
}


const postGame = () => {
    console.log('Dados enviados:', form.data())
    form.post(route('games.store'), {
        preserveScroll: true,
        forceFormData: true,
        onSuccess: () => {
            toast.add({
                severity: 'success',
                summary: 'Sucesso',
                detail: 'Jogo cadastrado com sucesso!',
                life: 3000
            })
            form.reset()
        },
        onError: () => {
            toast.add({
                severity: 'error',
                summary: 'Erro',
                detail: 'Erro ao cadastrar o jogo.',
                life: 3000
            })
        }
    })
}
</script>
