import { Toast } from "@shopify/app-bridge/actions";
import { initAppBridge } from "@/plugins/appBridge";

export default function useToast(message, options = {}) {
    const appBridge = initAppBridge();

    const { duration = 5000, isError = false, onDismiss = () => {} } = options;

    const toast = Toast.create(appBridge, {
        message: message,
        duration,
        isError,
    });

    toast.subscribe(Toast.Action.CLEAR, (data) => {
        onDismiss();
    });

    toast.dispatch(Toast.Action.SHOW);
}
