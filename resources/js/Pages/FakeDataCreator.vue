<template>
    <Page title="Generate Fake Data" fullWidth>
        <template #primaryAction>
            <InlineStack direction="row" align="center" gap="400">
                <ManagePremiumButton :hasPremium="hasPremium" />

                <DeleteFakeDataButton />
            </InlineStack>
        </template>
        <Layout>
            <LayoutSection>
                <LegacyCard sectioned>
                    <FormLayout>
                        <RangeSlider
                            output
                            :label="`Number of Products (${productsCount})`"
                            :min="0"
                            :max="100"
                            :step="5"
                            v-model="productsCount"
                        />
                        <RangeSlider
                            output
                            :min="0"
                            :max="100"
                            :step="5"
                            v-model="customersCount"
                        >
                            <template #label>
                                <InlineStack
                                    direction="row"
                                    align="center"
                                    gap="100"
                                >
                                    Number of Customers ({{ customersCount }})
                                    <Tooltip
                                        v-if="!hasPremium"
                                        content="This feature is only available for premium plan."
                                        dismissOnMouseOut
                                    >
                                        <Text fontWeight="bold" as="span">
                                            <Icon
                                                :source="StarFilledIcon"
                                                tone="success"
                                            />
                                        </Text>
                                    </Tooltip>
                                </InlineStack>
                            </template>
                        </RangeSlider>
                        <Button
                            variant="primary"
                            size="large"
                            class="mt-4"
                            :loading="isLoading"
                            @click="generate({ customersCount, productsCount })"
                        >
                            Generate Data
                        </Button>
                        <ValidationErrorBanner
                            v-if="errors.length"
                            :errors="errors"
                            title="Failed to generate fake data"
                            :onDismiss="() => dismissErrors()"
                        />
                    </FormLayout>
                </LegacyCard>
            </LayoutSection>
        </Layout>
    </Page>
</template>

<script setup>
import { ref } from "vue";
import ValidationErrorBanner from "@/Components/ValidationErrorBanner";
import DeleteFakeDataButton from "@/Components/DeleteFakeDataButton";
import ManagePremiumButton from "@/Components/ManagePremiumButton";
import useGenerateFakeData from "@/composables/useGenerateFakeData";
import StarFilledIcon from "@icons/StarFilledIcon.svg";

defineProps({
    hasPremium: Boolean,
});

const customersCount = ref(0);
const productsCount = ref(0);
const { isLoading, errors, dismissErrors, generate } = useGenerateFakeData();

// const premiumIcon = <Icon :source="PlusCircleIcon"></Icon>
</script>
