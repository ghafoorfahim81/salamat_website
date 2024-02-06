{{-- Add Modal --}}
<div class="modal fade" id="Additems" tabindex="-1" role="dialog" aria-labelledby="AdditemsLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AdditemsLabel">{{__('settings.add_item_status')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="save_items"></ul>

                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_en')}}</label>
                    <input type="text" required  class="items_name_en form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_ps')}}</label>
                    <input type="text" required id="name_ps" class="items_name_ps form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_prs')}}</label>
                    <input type="text" required id="name_prs" class="items_name_prs form-control">
                </div>
                <!-- <div class="form-group mb-3">
                    <label for="">Phone No</label>
                    <input type="text" required class="phone form-control">
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('general_words.close')}}</button>
                <button type="button" class="btn btn-primary add_items">{{__('general_words.save')}}</button>
            </div>

        </div>
    </div>
</div>


{{-- Edit Modal --}}
<div class="modal fade" id="edititemsmodal" tabindex="-1" aria-labelledby="edititemsmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edititemsmodalLabel">{{__('general_words.edit')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <ul id="update_items"></ul>

                <input type="hidden" id="itemstatus_id" />

                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_en')}}</label>
                    <input type="text" id="items_name_en" required class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_ps')}}</label>
                    <input type="text" id="items_name_ps" required class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_prs')}}</label>
                    <input type="text" id="items_name_prs" required class="form-control">
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('general_words.close')}}</button>
                <button type="submit" class="btn btn-primary update_items">{{__('general_words.update')}}</button>
            </div>

        </div>
    </div>
</div>
{{-- Edn- Edit Modal --}}


{{-- Delete Modal --}}
<div class="modal fade" id="DeleteStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('general_words.delete')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>{{__('general_words.confirm_delete')}}</h4>
                <input type="hidden" id="deletestatus_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('general_words.close')}}</button>
                <button type="button" class="btn btn-primary delete_itemstatus">{{__('general_words.yes')}}</button>
            </div>
        </div>
    </div>
</div>
{{-- End - Delete Modal --}}

<!-- <div class="col-auto float-right ml-auto">

                        <a href="#" class="btn add-btn"><i class="fa fa-plus"></i> Create Estimate</a>
                    </div> -->
                    <div class="item-list">
                  <div class="table-responsive table-style">
                  <h4>
                        
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#Additems">{{__('settings.add_item_status')}}</button>
                    </h4>
</div>
<div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('general_words.name_in_en')}}</th>
                                <th>{{__('general_words.name_in_ps')}}</th>
                                <th>{{__('general_words.name_in_prs')}}</th>
                                <th>{{__('general_words.edit')}}</th>
                                <th>{{__('general_words.delete')}}</th>
                            </tr>
                        </thead>
                        <tbody id="items">
                        </tbody>
                    </table>
                </div>

                 </div>

@section('scripts5')
<script>
    $(document).ready(function () {

       
        fetchitemstatus();

function fetchitemstatus() {
    $.ajax({
        type: "GET",
        url: "/fetch-itemstatus",
        dataType: "json",
        success: function (response) {
            $('#items').html("");
            $.each(response.itemstatus, function (key, item) {
                $('#items').append('<tr>\
                    <td>' + item.id + '</td>\
                    <td>' + item.name_en + '</td>\
                    <td>' + item.name_ps + '</td>\
                    <td>' + item.name_prs + '</td>\
                    <td><button type="button" value="' + item.id + '" class="btn btn-primary edititemsbtn btn-sm">Edit</button></td>\
                    <td><button type="button" value="' + item.id + '" class="btn btn-danger deletestatubtn btn-sm">Delete</button></td>\
                \</tr>');
            });
        }
    });
}


        $(document).on('click', '.add_items', function (e) {
            e.preventDefault();
            $(this).text('Sending..');

            var data = {
                'name_en': $('.items_name_en').val(),
                'name_ps': $('.items_name_ps').val(),
                'name_prs': $('.items_name_prs').val(),
               
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/add_itemstatus",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status == 400) {
                        $('#save_items').html("");
                        $('#save_items').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_items').append('<li>' + err_value + '</li>');
                        });
                        $('.add_items').text('Save');
                    } else {
                        $('#save_items').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#Additems').find('input').val('');
                        $('.add_items').text('Save');
                        $('#Additems').modal('hide');
                        fetchitemstatus();
                      
                    }
                }
            });

        });

        $(document).on('click', '.edititemsbtn', function (e) {
            e.preventDefault();
            var itemstatus_id  = $(this).val();
            $('#edititemsmodal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-itemstatus/" + itemstatus_id ,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#edititemsmodal').modal('hide');
                    } else {
                        $('#items_name_en').val(response.itemstatus.name_en);
                        $('#items_name_ps').val(response.itemstatus.name_ps);
                        $('#items_name_prs').val(response.itemstatus.name_prs);
                        $('#itemstatus_id ').val(itemstatus_id );
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_items', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
            var id = $('#itemstatus_id ').val();
            // alert(id);

            var data = {
                'name_en': $('#items_name_en').val(),
                'name_ps': $('#items_name_ps').val(),
                'name_prs': $('#items_name_prs').val(),
                
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "/update-itemstatus/" + id,
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status == 400) {
                        $('#update_items').html("");
                        $('#update_items').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_items').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_items').text('Update');
                    } else {
                        $('#update_items').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#edititemsmodal').find('input').val('');
                        $('.update_items').text('Update');
                        $('#edititemsmodal').modal('hide');
                        fetchitemstatus();
                    }
                }
            });

        });

        $(document).on('click', '.deletestatubtn', function () {
            var itemstatus_id = $(this).val();
            $('#DeleteStatusModal').modal('show');
            $('#deletestatus_id').val(itemstatus_id);
        });

        $(document).on('click', '.delete_itemstatus', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var id = $('#deletestatus_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-itemstatus/" + id,
                dataType: "json",
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_itemstatus').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_itemstatus').text('Yes Delete');
                        $('#DeleteStatusModal').modal('hide');
                        fetchitemstatus();
                    }
                }
            });
        });

    });

</script>
@endsection