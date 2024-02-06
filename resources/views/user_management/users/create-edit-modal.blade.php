<modal
    v-if="isModalOpen"
    @close-modal="closeModal"
    :title="isEdit ?  `{{__('user_management.user_edit')}}` : `{{__('user_management.user_create')}}`"
    :loading="save_users_loader"
    :disabled="false"
    :loading_text="`{{__('user_management.user_is_saving')}}`"
    :btn_name="`{{__('user_management.user_save')}}`"
    :show-submit="true"
    :btn_icon="'save'"

    :size="'large'"
    @submit="handleSubmit"
    :cancel_text="`{{__('general_words.cancel')}}`"
    :submit_text="`{{__('general_words.save')}}`"
>

    <form>
        <div class="grid gap-4 mb-4 md:grid-cols-3">
            <div>
                <div class="relative" v-show="!showDSkeleton">
                    <v-select :options="directorates" class="text-sm" label="name"
                              @input="filterEmployeeByDirectorate(selected_directorate.id)"
                              v-model="selected_directorate"></v-select>
                    <floating-label :id="'selected_directorate'" label="{{__('document.directorate')}}"/>
                </div>
                <validation-message :message="errors.directorate" v-show="!selected_directorate"/>
            </div>
            <skeleton :show="showDSkeleton"></skeleton>
            <div>
                <div class="relative" v-show="!showEmpSkeleton">
                    <v-select :options="employees" class="text-sm" id="employee" label="full_name"
                              v-model="selected_employee"></v-select>
                    <floating-label :id="'employee'" label="{{__('user_management.employee')}}"/>
                </div>
                <skeleton :show="showEmpSkeleton"></skeleton>
                <validation-message :message="errors.employee" v-show="!selected_directorate"/>
            </div>

            <div>
                <d-input label="{{__('user_management.user_name')}}" :name.sync="form.user_name"  :is-required="true"/>

                                <validation-message :message="errors.user_name" />

            </div>
{{--            <div>--}}
{{--                <validation-message :message="errors.user_name" />--}}
{{--            </div>--}}
            <div>
                <d-input label="{{__('user_management.email')}}" :name.sync="form.email"/>
            </div>
            <div>
                <div class="relative">
                    <v-select :options="roles" label="name" multiple v-model="selected_roles"></v-select>
                    <floating-label :id="'selected_roles'" label="{{__('user_management.roles')}}"/>
                </div>
                <validation-message :message="errors.role" v-show="!selected_roles"/>
            </div>

            <div>
                <d-input label="{{__('user_management.password')}}" :type="'password'" :name.sync="form.password"
                         :is-required="true"/>
            </div>
            <div>
                <d-input label="{{__('user_management.repeat_password')}}" :type="'password'"
                         :name.sync="form.repeat_password" :is-required="true"/>
                <div>
                </div>
            </div>
            <div>
                <validation-message :message="errors.repeat_password" v-show="!form.repeat_password"/>
            </div>
            <div class="mb-3">
                <validation-message :message="errors.compare_password" v-show="form.repeat_password !=form.password" />
            </div>

        </div>
    </form>

</modal>
