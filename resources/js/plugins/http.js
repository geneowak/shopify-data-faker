import axios from "axios";
import { inject } from "vue";
import { getSessionToken } from "@shopify/app-bridge/utilities";
import { initAppBridge } from "./appBridge";
import useRedirect from "@/composables/useRedirect";

const app = initAppBridge();

axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

axios.interceptors.request.use(function (config) {
    return getSessionToken(app).then((token) => {
        config.headers.Authorization = `Bearer ${token}`;
        config.params = { ...config.params, host: window.__SHOPIFY_HOST };

        return config;
    });
});

axios.interceptors.response.use(
    (response) => response,
    (error) => {
        if (
            error?.response?.status === 403 &&
            error?.response?.data?.forceRedirectUrl
        ) {
            useRedirect(error.response.data.forceRedirectUrl);
        }

        return Promise.reject(error);
    },
);

export default axios;
