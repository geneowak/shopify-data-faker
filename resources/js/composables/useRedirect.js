import { initAppBridge } from "@/plugins/appBridge";
import { Redirect } from "@shopify/app-bridge/actions";

const app = initAppBridge();
const redirect = Redirect.create(app);

export default function useRedirect(url) {
    return redirect.dispatch(Redirect.Action.REMOTE, url);
}
