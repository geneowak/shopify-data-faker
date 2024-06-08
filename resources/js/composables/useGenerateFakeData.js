import { ref } from "vue";
import http from "@/plugins/http";
import useToast from "@/composables/useToast";

export default function generateFakeData() {
    const isLoading = ref(false);
    const errors = ref("");

    const generate = (data) => {
        isLoading.value = true;

        http.post("/fake-data", data)
            .then((response) => {
                errors.value = [];

                useToast("Fake data is being created in the background.");
            })
            .catch((error) => {
                if (error?.response?.status === 422) {
                    errors.value = Object.values(
                        error.response?.data?.errors || {},
                    ).flatMap((err) => err);
                } else {
                    errors.value = [
                        "Ooops! Something went wrong, please try again.",
                    ];
                }
            })
            .finally(() => (isLoading.value = false));
    };

    const dismissErrors = () => (errors.value = false);

    return {
        generate,
        errors,
        isLoading,
        dismissErrors,
    };
}
