<template>
    <aside
        :class="[
            'flex flex-col bg-gray-800 text-white transition-all duration-300 shadow',
            isCollapsed ? 'w-[70px]' : 'w-[240px]'
        ]"
        style="height: 100vh"
    >
        <!-- Topo -->
        <div class="p-3 border-b border-gray-700 flex justify-between items-center">
            <span v-if="!isCollapsed" class="font-bold text-white">{{ user.name }}</span>
            <button
                @click="$emit('toggle')"
                :class="[
                    'w-8 h-8 flex items-center justify-center rounded hover:bg-gray-700 transition',
                    isCollapsed ? 'mx-auto' : 'ml-auto'
                ]"
            >
                <i :class="[isCollapsed ? 'pi pi-chevron-right' : 'pi pi-chevron-left', 'text-white']"></i>
            </button>
        </div>

        <!-- Menu -->
        <nav class="flex-1 overflow-auto px-2 py-2">
            <ul class="space-y-2">
                <li v-for="(item, index) in menuItems" :key="index">
                    <Link
                        :href="item.href"
                        :class="[
                            'flex items-center gap-3 px-3 py-2 rounded hover:bg-gray-600 transition text-green-400 text-sm',
                            isCollapsed ? 'justify-center bg-gray-800' : 'justify-start bg-gray-700'
                        ]"
                    >
                        <i :class="['pi', item.icon, 'text-green-400', isCollapsed ? 'text-lg' : '']"></i>
                        <span v-if="!isCollapsed">{{ item.label }}</span>
                    </Link>
                </li>
            </ul>
        </nav>

        <!-- Botão de sair -->
        <div class="p-3 border-t border-gray-700 mt-auto">
            <button
                @click="confirmLogout"
                class="flex items-center gap-2 px-3 py-2 bg-red-600 hover:bg-red-500 rounded text-white w-full text-sm justify-start"
            >
                <i class="pi pi-sign-out"></i>
                <span v-if="!isCollapsed">Sair</span>
            </button>
        </div>

        <!-- Confirmação e toast -->
        <Toast />
        <ConfirmDialog />
    </aside>
</template>

<script setup>
import {Link, router} from '@inertiajs/vue3'
import {useToast} from 'primevue/usetoast'
import {useConfirm} from 'primevue/useconfirm'

// importações locais dos componentes

import ConfirmDialog from 'primevue/confirmdialog'
import Toast from 'primevue/toast'

defineProps({
    isCollapsed: Boolean,
    user: Object,
})

const toast = useToast()
const confirm = useConfirm()

const confirmLogout = () => {
    confirm.require({
        message: 'Deseja realmente sair?',
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
            toast.add({severity: 'info', summary: 'Saindo', detail: 'Logout confirmado', life: 3000})
            logout()
        },
        reject: () => {
            toast.add({severity: 'warn', summary: 'Cancelado', detail: 'Logout cancelado', life: 3000})
        }
    })
}

const logout = () => {
    router.post(route('logout'))
}

const menuItems = [
    {label: 'Dashboard', href: '/dashboard', icon: 'pi-home'},
    {label: 'Jogos', href: '/games', icon: 'pi-objects-column'},
    {label: 'Tabelas de dominio', href: '/games', icon: 'pi-objects-column'}
]
</script>
