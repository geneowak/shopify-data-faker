<template>
    <Banner :title="title" tone="critical" @dismiss="onDismiss">
        <Text as="p">
            <ul>
                <li v-for="(error, i) in errors" :key="i">{{ error }}</li>
            </ul>
        </Text>
    </Banner>
</template>

<script setup>
defineProps({
    title: { type: String, default: "Error messages" },
    onDismiss: { type: Function, default: () => {} },
    errors: { type: Array, required: true },
});
</script>
