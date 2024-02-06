<template>
    <div class="relative">
        <input
            :type="type || 'text'"
            :value="name"
            :placeholder="placeholder"
            :readonly="readonly ?? false"
            @input="updateName"
            @blur="validateInput"
            autocomplete="off"
            :id="label"
            :class="showError ? 'border-1 border-red-400 focus:border-red-400' : ''"
            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border-1 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
            placeholder=" "
        />
        <label
            :for="label"
            :class="showError ? 'text-red-400 peer-focus:text-red-600' : ''"
            class="absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform
             -translate-y-3 scale-75 top-1 z-10 origin-[0] bg-white dark:bg-gray-900 px-2 peer-focus:px-2
              peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100
               peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-1
               peer-focus:scale-75 peer-focus:-translate-y-3 start-1 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto"
        >
            {{
                label
            }}
        </label>
        <div v-show="isRequired && showError" class="text-sm text-red-600 dark:text-red-500">
            <span class="font-medium">Oh, snapp!</span> this field is required.
        </div>
    </div>
</template>

<script>
export default {
    props: ["label", "icon", "placeholder", "name", "type", "readonly", "isRequired",'showMessage'],
    data() {
        return {
            showError: false,
        };
    },
    methods: {
        updateName(event) {
            if (this.isRequired) {
                this.showError = event.target.value.trim() === '';
            }
            this.$emit('update:name', event.target.value);
        },

        validateInput(event) {
            this.showError = this.isRequired && (event.target.value.trim() === '');
        },
    },
};
</script>

<style>
</style>
