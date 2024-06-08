<template>
    <AppProvider :i18n="locales">
        <MissingApiKey v-if="!hasApiKey" />
        <FakeDataCreator :hasPremium="hasPremium" v-else />
    </AppProvider>
</template>

<script setup>
import FakeDataCreator from "./FakeDataCreator";

defineProps({
    hasApiKey: Boolean,
    hasPremium: Boolean,
});
</script>
