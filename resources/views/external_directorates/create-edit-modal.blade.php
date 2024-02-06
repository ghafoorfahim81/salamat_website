<modal
    v-if="isModalOpen"
    @close-modal="closeModal"
    :title="isEdit ? `{{__('setting.edit_external_department')}}` : `{{__('setting.create_external_department')}}`"
    :loading="save_directorate_loader"
    :disabled="false"
    :show-submit="true"
    :loading_text="`{{__('setting.external_department_is_storing')}}`"
    :btn_name="`{{__('setting.external_department_stored')}}`"
    :btn_icon="'save'"
    @submit="handleSubmit"
    :cancel_text="`{{__('general_words.cancel')}}`"

/>

<form>
    <div class="grid gap-4 mb-4 md:grid-cols-1">
        <div>
            <d-input :label="`{{__('setting.external_department')}}`" :name.sync="form.name" :is-required="true"/>
        </div>
    </div>
</form>
