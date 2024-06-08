module.exports = {
    env: {
        node: true,
    },
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-essential',
        'plugin:vue/vue3-strongly-recommended',
        'plugin:prettier/recommended',
    ],
    plugins: ['vue', 'unused-imports'],
    rules: {
        // override/add rules settings here, such as:
        // 'vue/no-unused-vars': 'error'
        'prettier/prettier':'error',
        'no-console': 'warn',
        'unused-imports/no-unused-imports': 'warn',
        'vue/max-attributes-per-line': 'off',
        'vue/multi-word-component-names': 'off',
        'no-undef': 'warn',
        'vue/valid-v-slot': [
            'error',
            {
                allowModifiers: true,
            },
        ],
        'vue/attributes-order': [
            'warn',
            {
                alphabetical: true,
            },
        ],
    },
};

