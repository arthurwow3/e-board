<template>
    <AuthenticatedLayout :user="$page.props.auth.user" appName="E-Board">
        <h1 class="text-xl font-bold">Bem-vindo(a) à sua dashboard</h1>
        <!-- Conteúdo aqui -->
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
</script>
