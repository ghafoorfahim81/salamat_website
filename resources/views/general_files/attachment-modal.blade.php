 <div class="modal fade" id="attachment-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0 fc-title" id="exampleModalLabel"><i class="fadeIn animated bx bx-menu"></i>{{__('general_words.attachment_modal')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div v-if="upload_permission">
                <form>
                    <div class="row py-5 pb-0">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <label for="formFileSm" class="label">File</label>
                                <input class="form-control form-control-sm" v-on:change="onFileChange" type="file">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <label for="formFileSm" class="label">{{__('general_words.file_name')}}</label>
                                <input class="form-control form-control-sm" v-model="file_name" type="text" placeholder="@lang('general_words.file_name')">
                            </div>
                        </div>
                    </div>
                </form>
                <button class="btn btn-primary  d-flex justify-content-center" type="button" disabled v-if="loading">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{__('general_words.file_is_uploading')}}
                </button>
                <button v-if="!loading" type="button" class="btn btn-primary px-4 mb-1" @click="upload"><i class="fadeIn animated bx bx-upload"></i> {{__('general_words.upload')}}</button>
            </div>

                <div>
                    <table class="table">
                        <thead class="table-light">
                        <th>{{__('general_words.number')}}</th>
                        <th>{{__('general_words.file_name')}}</th>
                        <th>{{__('general_words.original_name')}}</th>
                        <th>{{__('general_words.download')}}</th>
                        </thead>
                        <tbody class="table-light">
                        <tr v-for="(attachment,index) in attachmentList">
                            <td>@{{ index+1 }}</td>
                            <td>@{{ attachment.assign_name }}</td>
                            <td>@{{ attachment.original_name }}</td>
                            <td><a :href="`{{url('/download')}}/${attachment.id}`" class="btn btn-outline-light"><i class="bx bx-cloud-download me-1" style="color: #000;"></i>
                                </a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close px-4" data-bs-dismiss="modal">{{__('general_words.close')}}</button>
                <!-- <button type="button" class="btn btn-primary" @click="upload">{{__('general_words.upload')}}</button> -->
            </div>
        </div>
    </div>
</div>
