<div class="" >
    <!-- Modal -->
    <div class="modal fade" id="change-modal" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0 fc-title"><i class="fadeIn animated bx bx-menu"></i>{{ __('general_words.change_password') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
                </div>
                <div class="modal-body row p-5">
                                            <div class="col-md-4">
                                                <div class="row mb-3">
                                                    <div class="form-floating">
                                                        <label for="email" class="label">{{__('general_words.email')}}</label>
                                                        <input type="email" required v-model="form.email"
                                                        placeholder="{{__('general_words.email')}}" class="form-control"
                                                        id="email">
                                                        <div v-if="duplicateEmail"
                                                        style="color:red">{{__('general_words.email_already_exist')}}</div>
                                                    </div>
                                                </div>
                                            </div>
                                    <div class="col-md-4">
                                        <div class="row mb-3">
                                            <div class="form-floating">
                                                <label for="password"
                                                class="label">{{__('general_words.new_password')}}</label>
                                                <input type="password" @input="checkPassword" v-model="form.password"
                                                autocomplete="new-password"
                                                placeholder="{{__('general_words.password')}}" required
                                                class="form-control" id="password">
                                                <div v-show="lengthFlag"
                                                style="color:red">{{__('general_words.password_constraint')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row mb-3">
                                            <div class="form-floating">
                                                <label for="repeat-password"
                                                class="label">{{__('general_words.repeat_password')}}</label>
                                                <input @input="checkCurrentPassword" required type="password"
                                                v-model="form.repeat_password"
                                                placeholder="{{__('general_words.repeat_password')}}"
                                                class="form-control" id="repeat-password">
                                                <div v-show="flag"
                                                style="color:red">{{__('general_words.password_not_match')}}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary px-4 close" 
                                                data-bs-dismiss="modal" >{{__('general_words.close')}} <i class="lni lni-close"></i></button>
                                                <button type="button" @click="updateUser"
                                                    class="btn btn-primary px-5 d-flex justify-content-end">{{__('general_words.update')}}
                                                </button>

                                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
