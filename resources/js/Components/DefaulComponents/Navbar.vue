<template>
    <header class="flex justify-between items-center px-4 py-3 bg-gray-800 text-white shadow">
        <span class="text-lg font-bold">{{ appName }}</span>
        <div class="flex items-center gap-3">
            <span class="text-sm">{{ user.name }}</span>
            <img :src="user.profile_photo_url" alt="Avatar" class="w-8 h-8 rounded-full" />
        </div>
    </header>
</template>

<script setup>
defineProps({
    user: Object,
    appName: String
})
</script>
