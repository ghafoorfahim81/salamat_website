<div class="col">
    <!-- Modal -->
    <div class="modal fade" id="AddEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddItemModalLabel">{{__('general_words.add_employee')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row p-5">
                  
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.name')}}</label>
                            <input :disabled="disable" type="text" v-model="form.name"  
                            class="form-control">                        
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.last_name')}}</label>
                            <input :disabled="disable" type="text" v-model="form.last_name"  
                            class="form-control">                       
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.father_name')}}</label>
                            <input :disabled="disable" type="text" v-model="form.father_name"  
                            class="form-control"> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.gender')}}</label>
                            <v-select :options="Gender" label="name" :disabled="disable"
                                                    v-model="select_gender"
                                                    placeholder="@lang('general_words.gender')"></v-select>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.position')}}</label>
                            <input :disabled="disable" type="text" v-model="form.position"  
                            class="form-control"> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.phone')}}</label>
                            <input :disabled="disable" type="text" v-model="form.phone"  
                            class="form-control"> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.email')}}</label>
                            <input :disabled="disable" type="text" v-model="form.email"  
                            class="form-control"> 
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="form-floating">
                            <label class="label">{{__('general_words.department')}}</label>
                            <input :disabled="disable" type="text" v-model="form.department"  
                            class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 select2-sm mb-3">                     
                        <div class="form-floating">
                            <label class="label">{{ __('general_words.directorate') }}: </label>
                            <v-select :options="directorates" @search="searchDirectorate"
                            label="name"  v-model="selected_dir"
                            placeholder="{{ __('general_words.directorate') }}"></v-select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close px-4"
                        data-bs-dismiss="modal" @click="resetForm">{{ __('general_words.close') }}
                        <i class="lni lni-close"></i>
                    </button>
                    <btn v-if="!isEdit" :label="'@lang('general_words.save')'" @click="saveItems"
                    :icon="'fadeIn animated bx bx-save'"  :disable="!form.name" :loading="save_item_loader"></btn>

                   <btn v-show="isEdit" :label="'@lang('general_words.update')'" @click="updateItems"
                    :icon="'fadeIn animated bx bx-save'"  :disable="!form.name " :loading="save_item_loader"></btn>
                </div>
            </div>
        </div>
    </div>
</div>


