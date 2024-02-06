<modal
    v-if="isModalOpen"
    @close-modal="closeModal"
    :title="isEdit ? `{{__('setting.edit_document_status')}}` : `{{__('setting.create_document_status')}}`"
    :loading="save_status_loader"
    :disabled="false"
    :show-submit="true"
    :loading_text="`{{__('setting.document_status_is_storing')}}`"
    :btn_name="`{{__('setting.document_status_stored')}}`"
    :btn_icon="'save'"
    @submit="handleSubmit"
    :cancel_text="`{{__('general_words.cancel')}}`"

>

<form>
    <div class="grid gap-4 mb-4 md:grid-cols-1">
        <div>
            <d-input :label="`{{__('setting.document_status')}}`" :name.sync="form.name" :is-required="true"/>
        </div>
    </div>
</form>
