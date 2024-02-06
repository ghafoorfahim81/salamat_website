{{-- Add Modal --}}
<div class="modal fade" id="AddItemType" tabindex="-1" role="dialog" aria-labelledby="AddItemTypeLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddItemTypeLabel">{{__('settings.add_item_type')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <ul id="save_itemtype"></ul>

                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_en')}}</label>
                    <input type="text" required  class="item_name_en form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_ps')}}</label>
                    <input type="text" required id="name_ps" class="item_name_ps form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_prs')}}</label>
                    <input type="text" required id="name_prs" class="item_name_prs form-control">
                </div>
                <!-- <div class="form-group mb-3">
                    <label for="">Phone No</label>
                    <input type="text" required class="phone form-control">
                </div> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('general_words.close')}}</button>
                <button type="button" class="btn btn-primary add_itemtype">{{__('general_words.save')}}</button>
            </div>

        </div>
    </div>
</div>


{{-- Edit Modal --}}
<div class="modal fade" id="edititemmodal" tabindex="-1" aria-labelledby="edititemmodalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edititemmodalLabel">{{__('settings.edit_item_type')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <ul id="update_itemtype"></ul>

                <input type="hidden" id="item_id" />

                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_en')}}</label>
                    <input type="text" id="item_name_en" required class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_ps')}}</label>
                    <input type="text" id="item_name_ps" required class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="">{{__('general_words.name_in_prs')}}</label>
                    <input type="text" id="item_name_prs" required class="form-control">
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('general_words.close')}}</button>
                <button type="submit" class="btn btn-primary update_itemtype">{{__('general_words.update')}}</button>
            </div>

        </div>
    </div>
</div>
{{-- Edn- Edit Modal --}}


{{-- Delete Modal --}}
<div class="modal fade" id="DeleteItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{__('general_words.delete')}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>{{__('general_words.confirm_delete')}}</h4>
                <input type="hidden" id="deleteing_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('general_words.close')}}</button>
                <button type="button" class="btn btn-primary delete_itemtype">{{__('general_words.yes')}}</button>
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
                        <!-- Add Item Type -->
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#AddItemType">{{__('settings.add_item_type')}}</button>
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
                        <tbody id="itemtype">
                        </tbody>
                    </table>
                </div>

                 </div>
@section('scripts3')
<script>
    $(document).ready(function () {

       
        fetchitemtype();

function fetchitemtype() {
    $.ajax({
        type: "GET",
        url: "/fetch-itemtype",
        dataType: "json",
        success: function (response) {
            $('#itemtype').html("");
            $.each(response.item_type, function (key, item) {
                $('#itemtype').append('<tr>\
                    <td>' + item.id + '</td>\
                    <td>' + item.name_en + '</td>\
                    <td>' + item.name_ps + '</td>\
                    <td>' + item.name_prs + '</td>\
                    <td><button type="button" value="' + item.id + '" class="btn btn-primary edititembtn btn-sm">Edit</button></td>\
                    <td><button type="button" value="' + item.id + '" class="btn btn-danger deleteitembtn btn-sm">Delete</button></td>\
                \</tr>');
            });
        }
    });
}


        $(document).on('click', '.add_itemtype', function (e) {
            e.preventDefault();
            $(this).text('Sending..');

            var data = {
                'name_en': $('.item_name_en').val(),
                'name_ps': $('.item_name_ps').val(),
                'name_prs': $('.item_name_prs').val(),
               
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                url: "/itemtype",
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status == 400) {
                        $('#save_itemtype').html("");
                        $('#save_itemtype').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#save_itemtype').append('<li>' + err_value + '</li>');
                        });
                        $('.add_itemtype').text('Save');
                    } else {
                        $('#save_itemtype').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#AddItemType').find('input').val('');
                        $('.add_itemtype').text('Save');
                        $('#AddItemType').modal('hide');
                        fetchitemtype();
                      
                    }
                }
            });

        });

        $(document).on('click', '.edititembtn', function (e) {
            e.preventDefault();
            var item_id  = $(this).val();
            $('#edititemmodal').modal('show');
            $.ajax({
                type: "GET",
                url: "/edit-itemtype/" + item_id ,
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#edititemmodal').modal('hide');
                    } else {
                        $('#item_name_en').val(response.itemtype.name_en);
                        $('#item_name_ps').val(response.itemtype.name_ps);
                        $('#item_name_prs').val(response.itemtype.name_prs);
                        $('#item_id ').val(item_id );
                    }
                }
            });
            $('.btn-close').find('input').val('');

        });

        $(document).on('click', '.update_itemtype', function (e) {
            e.preventDefault();

            $(this).text('Updating..');
            var id = $('#item_id ').val();
            // alert(id);

            var data = {
                'name_en': $('#item_name_en').val(),
                'name_ps': $('#item_name_ps').val(),
                'name_prs': $('#item_name_prs').val(),
                
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "PUT",
                url: "/update-itemtype/" + id,
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.status == 400) {
                        $('#update_itemtype').html("");
                        $('#update_itemtype').addClass('alert alert-danger');
                        $.each(response.errors, function (key, err_value) {
                            $('#update_itemtype').append('<li>' + err_value +
                                '</li>');
                        });
                        $('.update_itemtype').text('Update');
                    } else {
                        $('#update_itemtype').html("");

                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#edititemmodal').find('input').val('');
                        $('.update_itemtype').text('Update');
                        $('#edititemmodal').modal('hide');
                        fetchitemtype();
                    }
                }
            });

        });

        $(document).on('click', '.deleteitembtn', function () {
            var item_id = $(this).val();
            $('#DeleteItemModal').modal('show');
            $('#deleteing_id').val(item_id);
        });

        $(document).on('click', '.delete_itemtype', function (e) {
            e.preventDefault();

            $(this).text('Deleting..');
            var id = $('#deleteing_id').val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: "/delete-itemtype/" + id,
                dataType: "json",
                success: function (response) {
                    if (response.status == 404) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_itemtype').text('Yes Delete');
                    } else {
                        $('#success_message').html("");
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('.delete_itemtype').text('Yes Delete');
                        $('#DeleteItemModal').modal('hide');
                        fetchitemtype();
                    }
                }
            });
        });

    });

</script>
@endsection
