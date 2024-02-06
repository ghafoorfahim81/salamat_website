<modal
    v-if="isModalOpen"
    @close-modal="closeModal"
    :title="isEdit ? `{{__('setting.edit_security_level')}}` : `{{__('setting.create_security_level')}}`"
    :loading="save_levels_loader"
    :disabled="false"
    :show-submit="true"
    :loading_text="`{{__('setting.security_level_is_storing')}}`"
    :btn_name="`{{__('setting.security_level_stored')}}`"
    :btn_icon="'save'"
    @submit="handleSubmit"
    :size="'sm'"
    :cancel_text="`{{__('general_words.cancel')}}`"

/>

<form>
    <div class="grid gap-4 mb-4 md:grid-cols-1">
        <div>
            <d-input :label="`{{__('setting.security_level')}}`" :name.sync="form.name" :is-required="true"/>
        </div>
    </div>
</form>
