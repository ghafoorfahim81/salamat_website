<div class="col">
    <!-- Modal -->
    <div class="modal fade" id="AddHeiatModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="AddItemModalLabel">{{__('settings.add_heiat')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row p-5">
                  
                <div class="col-md-4 select2-sm mb-3">
                        <div class="form-floating">
                            <label class="label">{{ __('general_words.employee') }}</label>
                            <v-select :options="employees" @search="employeeSearch"
                                  label="full_name" v-model="selected_employee"
                                  placeholder="@lang('general_words.employee')"></v-select>
                            <p>
                                @{{ selected_employee?selected_employee.name:null }}
                                <span v-show="selected_employee">{{ __('general_words.son') }}</span>
                                @{{ selected_employee?selected_employee.father_name:null
                                }}
                                <span v-show="selected_employee">-</span>
                                @{{ selected_employee?selected_employee.position:null }}
                                <span v-show="selected_employee">-</span>
                                @{{ selected_employee?selected_employee.directorate_name:null }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="row mb-3">
                            <div class="form-floating">
                                <label for="inputEmailAddress2"
                                class="label">{{__('general_words.start_date')}}:</label>
                                <mof-date-picker :disabled="disable" v-model="form.start_date"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row mb-3">
                            <div class="form-floating">
                                <label for="inputEmailAddress2"
                                class="label">{{__('general_words.end_date')}}:</label>
                                <mof-date-picker :disabled="disable" v-model="form.end_date"/>
                            </div>
                        </div>
                    </div>
               
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close px-4"
                        data-bs-dismiss="modal" @click="resetForm">{{ __('general_words.close') }}
                        <i class="lni lni-close"></i>
                    </button>
                    <btn v-if="!isEdit" :label="'@lang('general_words.save')'" @click="saveItems"
                    :icon="'fadeIn animated bx bx-save'"  :disable="!selected_employee" :loading="save_item_loader"></btn>

                   <btn v-show="isEdit" :label="'@lang('general_words.update')'" @click="updateItems"
                    :icon="'fadeIn animated bx bx-save'"  :disable="!selected_employee " :loading="save_item_loader"></btn>
                </div>
            </div>
        </div>
    </div>
</div>


