<template>
    <Button
        variant="primary"
        tone="critical"
        @click="deleteData"
        size="large"
        :loading="isDeleting"
    >
        Delete Fake data
    </Button>
</template>

<script setup>
import { ref } from "vue";
import http from "@/plugins/http";
import useToast from "@/composables/useToast";

const isDeleting = ref(false);

const deleteData = () => {
    isDeleting.value = true;

    http.delete("/products")
        .then(() => {
            useToast("Started deleting fake products...");
        })
        .catch((error) => {
            console.log(error);
        })
        .finally(() => (isDeleting.value = false));
};
</script>
