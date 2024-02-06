<modal
    v-if="isModalOpen"
    @close-modal="closeModal"
    :title="isEdit ? `{{__('setting.edit_followup_type')}}` : `{{__('setting.create_followup_type')}}`"
    :show-submit="true"
    :loading="save_followup_loader"
    :disabled="false"
    :loading_text="`{{__('setting.followup_is_storing')}}`"
    :btn_name="`{{__('setting.followup_stored')}}`"
    :btn_icon="'save'"
    @submit="handleSubmit"
    :cancel_text="`{{__('general_words.cancel')}}`"

/>

<form>
    <div class="grid gap-4 mb-4 md:grid-cols-1">
        <div>
            <d-input :label="`{{__('setting.followup_type')}}`" :name.sync="form.name" :is-required="true"/>
        </div>
    </div>
</form>
