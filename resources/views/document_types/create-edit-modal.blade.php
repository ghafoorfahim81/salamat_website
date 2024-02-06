<modal
    v-if="isModalOpen"
    @close-modal="closeModal"
    :title="isEdit ? `{{__('setting.edit_document_type')}}` : `{{__('setting.create_document_type')}}`"
    :loading="save_types_loader"
    :disabled="false"
    :show-submit="true"
    :loading_text="`{{__('setting.document_type_is_storing')}}`"
    :btn_name="`{{__('setting.document_type_stored')}}`"
    :btn_icon="'save'"
    @submit="handleSubmit"
    :cancel_text="`{{__('general_words.cancel')}}`"

/>

<form>
    <div class="grid gap-4 mb-4 md:grid-cols-1">
        <div>
            <d-input :label="`{{__('setting.document_type')}}`" :name.sync="form.name" :is-required="true"/>
        </div>
    </div>
</form>
