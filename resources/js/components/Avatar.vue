<template>
    <div class="relative mt-3 inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
        <template v-if="!profilePhotoPath">
            <span class="font-medium text-gray-600 dark:text-gray-300">{{ firstCharacter }}</span>
        </template>
        <template v-else>
            <!-- Render profile photo here -->
            <img :src="profilePhotoPath" alt="Profile Photo" class="w-full h-full object-cover rounded-full">
        </template>
    </div>
</template>

<script>
export default {
    props: ['user', 'profilePhotoPath'],
    computed: {
        firstCharacter() {
            return this.user;
            const words = this.user.split(' ');
            const initials = words.map(word => word.charAt(0)).join('');
            return initials.toUpperCase();
        }
    }
};
</script>

<style>
/* Add any styling as needed */
</style>
