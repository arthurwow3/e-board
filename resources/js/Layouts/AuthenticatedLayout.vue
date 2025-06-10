<template>
    <div class="flex h-screen bg-gray-900 text-white">
        <!-- Sidebar -->
        <Sidebar :user="user" :is-collapsed="isCollapsed" @toggle="toggleSidebar" />

        <!-- Conteúdo -->
        <div class="flex-1 flex flex-col">
            <Navbar :user="user" :app-name="appName" />
            <main class="p-6 overflow-auto flex-1 bg-gray-900 text-white">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import Sidebar from '@/components/DefaulComponents/Sidebar.vue'
import Navbar from '@/components/DefaulComponents/Navbar.vue'

const isCollapsed = ref(false)
const toggleSidebar = () => {
    isCollapsed.value = !isCollapsed.value
}

const page = usePage()
const user = page.props.auth.user
const appName = 'e-Board'
</script>
