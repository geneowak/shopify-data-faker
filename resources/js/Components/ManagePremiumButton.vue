<template>
    <Button
        v-bind="btnScheme()"
        @click="togglePremium"
        size="large"
        :loading="loading"
    >
        <template #icon>
            <Icon :source="StarFilledIcon" tone="success" />
        </template>
        {{ hasPremium ? "Downgrade to FREE" : "Upgrade to Premium" }}
    </Button>
</template>

<script setup>
import { ref } from "vue";
import http from "@/plugins/http";
import useToast from "@/composables/useToast";
import useRedirect from "@/composables/useRedirect";
import StarFilledIcon from "@icons/StarFilledIcon.svg";

const props = defineProps({
    hasPremium: Boolean,
});

const loading = ref(false);

function btnScheme() {
    const btn = {};
    if (!props.hasPremium) btn.variant = "primary";

    return btn;
}

const togglePremium = () => {
    loading.value = true;

    const promise = props.hasPremium
        ? http.delete("/premium")
        : http.post("/premium");

    promise
        .then((response) => {
            if (response.data.redirectUrl) {
                useRedirect(response.data.redirectUrl);
            }
        })
        .catch(() => {
            useToast("Failed to upgrade to premium", { isError: true });
        })
        .finally(() => (loading.value = false));
};
</script>
