<div class="col">
    <!-- Modal -->
    <div class="modal fade" id="AddCategoryModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddItemModalLabel">{{__('general_words.category')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row p-5">
                  
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.name_in_en')}}</label>
                            <input :disabled="disable" type="text" v-model="form.name_en"  
                             class="form-control">                        
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.name_in_prs')}}</label>
                            <input :disabled="disable" type="text" v-model="form.name_prs"  
                             class="form-control">                       
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.name_in_ps')}}</label>
                            <input :disabled="disable" type="text" v-model="form.name_ps"  
                            class="form-control"> 
                        </div>
                    </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close px-4"
                        data-bs-dismiss="modal" @click="resetForm">{{ __('general_words.close') }}
                        <i class="lni lni-close"></i>
                    </button>
                    <btn v-if="!isEdit" :label="'@lang('general_words.save')'" @click="saveItems"
                    :icon="'fadeIn animated bx bx-save'"  :disable="!form.name_prs" :loading="save_item_loader"></btn>

                   <btn v-show="isEdit" :label="'@lang('general_words.update')'" @click="updateItems"
                    :icon="'fadeIn animated bx bx-save'"  :disable="!form.name_prs " :loading="save_item_loader"></btn>
                </div>
            </div>
        </div>
    </div>
</div>


