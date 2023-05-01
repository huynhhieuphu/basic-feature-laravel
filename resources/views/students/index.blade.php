@extends('layouts.app')

@section('title')
    {{ $title ?? false }}
@endsection

@section('content')

    {{-- addStudentModal --}}
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="javascript:void(0)" id="formCreate" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul id="saveForm_errList"></ul>

                        <div class="form-group">
                            <label for="student_full_name">Full name</label>
                            <input type="text" id="student_full_name" name="student_full_name"
                                   class="student_full_name form-control">
                            <span class="text-danger err_full_name err_msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="student_email">Email</label>
                            <input type="text" id="student_email" name="student_email"
                                   class="student_email form-control">
                            <span class="text-danger err_email err_msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="student_phone">Phone</label>
                            <input type="text" id="student_phone" name="student_phone"
                                   class="student_phone form-control">
                            <span class="text-danger err_phone err_msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="student_course">Course</label>
                            <input type="text" id="student_course" name="student_course"
                                   class="student_course form-control">
                            <span class="text-danger err_course err_msg"></span>
                        </div>
                        <div class="form-group">
                            <label for="student_avatar">Avatar</label>
                            <input type="file" id="student_avatar" name="student_avatar"
                                   class="student_avatar form-control">
                            <span class="text-danger err_avatar err_msg"></span>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success add_student">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- addStudentModal --}}

    {{-- editStudentModal --}}
    <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <ul id="saveForm_errList"></ul>
                    <input type="hidden" class="student_id_edit">
                    <div class="form-group">
                        <label for="student_full_name_edit">Full name</label>
                        <input type="text" id="student_full_name_edit" class="student_full_name_edit form-control">
                        <span class="text-danger err_full_name_edit err_msg_edit"></span>
                    </div>
                    <div class="form-group">
                        <label for="student_email_edit">Email</label>
                        <input type="text" id="student_email_edit" class="student_email_edit form-control">
                        <span class="text-danger err_email_edit err_msg_edit"></span>
                    </div>
                    <div class="form-group">
                        <label for="student_phone_edit">Phone</label>
                        <input type="text" id="student_phone_edit" class="student_phone_edit form-control">
                        <span class="text-danger err_phone_edit err_msg_edit"></span>
                    </div>
                    <div class="form-group">
                        <label for="student_course_edit">Course</label>
                        <input type="text" id="student_course_edit" class="student_course_edit form-control">
                        <span class="text-danger err_course_edit err_msg_edit"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_student">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- editStudentModal --}}

    {{-- deleteStudentModal --}}
    <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="deleteStudentModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteStudentModal">Delete Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" class="student_id_delete">
                    Are you Sure ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger destroy_student">Destory</button>
                </div>
            </div>
        </div>
    </div>
    {{-- deleteStudentModal --}}

    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            {{ $title ?? false }}
                            <a href="" class="btn btn-success btn-sm float-right" data-toggle="modal"
                               data-target="#addStudentModal">Add Student</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="message"></div>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Avatar</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchData();

            function fetchData() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('student.fetch') }}',
                    dataType: 'json',
                    beforeSend: function () {
                        $('tbody').html('');
                    },
                    success: function (response) {
                        if (response.status == 200) {
                            let public_path = '{{ asset("app/uploads/") }}';
                            $.each(response.data, function (key, value) {
                                $('tbody').append('<tr>\n' +
                                    '<td>' + (key + 1) + '</td>\n' +
                                    '<td>' + value.student_full_name + '</td>\n' +
                                    '<td>' + value.student_email + '</td>\n' +
                                    '<td>' + value.student_phone + '</td>\n' +
                                    '<td>' + value.student_course + '</td>\n' +
                                    '<td><img src="' + public_path + '/' + value.student_avatar + '" alt="' + value.student_avatar + '" width="70" height="70"></td>\n' +
                                    '<td><button type="button" data-id="' + value.student_id + '" class="btn btn-primary btn-sm edit_student" data-toggle="modal" data-target="#editStudentModal">Edit</button></td>\n' +
                                    '<td><button type="button" data-id="' + value.student_id + '" class="btn btn-danger btn-sm delete_student" data-toggle="modal" data-target="#deleteStudentModal">Delete</button></td>\n' +
                                    '</tr>');
                            });
                        }

                        if (response.status == 400) {
                            $('tbody').append('<tr>\n' +
                                '<td colspan="7" class="text-center">' + response.message + '</td>\n' +
                                '</tr>');
                        }
                    }
                });
            }

            $(document).on('click', '.edit_student', function (e) {
                e.preventDefault();

                $('#editStudentModal').modal('show');
                let student_id = $(this).data('id');
                let url = '{{route("student.edit", ["id" => ":id"])}}';
                url = url.replace(':id', student_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 200) {
                            $('.student_id_edit').val(response.data.student_id);
                            $('.student_full_name_edit').val(response.data.student_full_name);
                            $('.student_email_edit').val(response.data.student_email);
                            $('.student_phone_edit').val(response.data.student_phone);
                            $('.student_course_edit').val(response.data.student_course);
                        }

                        if (response.status === 400) {
                            $('#message').addClass('alert alert-danger').text(response.message);
                        }
                    }
                });
            });

            $(document).on('click', '.update_student', function (e) {
                e.preventDefault();

                let student_id = $('.student_id_edit').val();
                let url = '{{ route("student.update", ["id" => ":id"]) }}';
                url = url.replace(':id', student_id);

                let data = {
                    student_full_name: $('.student_full_name_edit').val(),
                    student_email: $('.student_email_edit').val(),
                    student_phone: $('.student_phone_edit').val(),
                    student_course: $('.student_course_edit').val()
                };

                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: data,
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 200) {
                            $('#message').addClass('alert alert-success').text(response.message);
                            $('#editStudentModal').modal('hide');
                            fetchData();
                        }

                        if (response.status === 400) {
                            $('#saveForm_errList_edit').addClass('alert alert-danger');
                            $.each(response.message, function (key, value) {
                                $('#saveForm_errList_edit').append(`<li>${value}</li>`);
                            });

                            $('.err_full_name_edit').text(response.message.student_full_name);
                            $('.err_email_edit').text(response.message.student_email);
                            $('.err_phone_edit').text(response.message.student_phone);
                            $('.err_course_edit').text(response.message.student_course);
                        }
                    }
                });
            });

            $(document).on('click', '.delete_student', function (e) {
                e.preventDefault();
                let student_id = $(this).data('id');
                let url = '{{ route("student.delete", ["id" => ":id"]) }}';
                url = url.replace(':id', student_id);

                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function (response) {
                        if (response.status === 200) {
                            $('.student_id_delete').val(response.data.student_id);
                        }

                        if (response.status === 400) {
                            $('#message').addClass('alert alert-danger').text(response.message);
                        }
                    }
                });
            });

            $(document).on('click', '.destroy_student', function (e) {
                e.preventDefault();
                let student_id = $('.student_id_delete').val();
                let url = '{{ route("student.destroy", ["id" => ":id"]) }}';
                url = url.replace(':id', student_id);

                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function (response) {
                        if (response.status === 200) {
                            $('#message').addClass('alert alert-danger').text(response.message);
                            $('#deleteStudentModal').modal('hide');
                            fetchData();
                        }

                        if (response.status === 400) {
                            $('#message').addClass('alert alert-danger').text(response.message);
                        }
                    }
                });
            });

            $(document).on('submit', '#formCreate', function (e) {
                e.preventDefault();
                let data = new FormData(this);

                console.log(data);

                // for(var pair of data) {
                //     console.log(pair[0]+ ', '+ pair[1]);
                // }

                $.ajax({
                    type: 'POST',
                    url: '{{ route("student.store") }}',
                    data: data,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        clearAddStudentModal();
                    },
                    success: function (response) {
                        if (response.status === 200) {
                            $('#message').addClass('alert alert-success').text(response.message);
                            $('#addStudentModal').modal('hide').find('input').val('');
                            fetchData();
                        }

                        if (response.status === 400) {
                            $('#saveForm_errList').addClass('alert alert-danger');
                            $.each(response.message, function (key, value) {
                                $('#saveForm_errList').append(`<li>${value}</li>`);
                            });

                            $('.err_full_name').text(response.message.student_full_name);
                            $('.err_email').text(response.message.student_email);
                            $('.err_phone').text(response.message.student_phone);
                            $('.err_course').text(response.message.student_course);
                            $('.err_avatar').text(response.message.student_avatar);
                        }
                    }
                });
            });

            $('#addStudentModal').on('hidden.bs.modal', function () {
                clearAddStudentModal();
                $('#addStudentModal').find('input').val('');
            });

            $('#editStudentModal').on('hidden.bs.modal', function () {
                clearEditStudentModal();
            });

            function clearAddStudentModal() {
                $('#saveForm_errList').html('').removeClass('alert alert-danger');
                $('.err_msg').text('');
            }

            function clearEditStudentModal() {
                $('#saveForm_errList_edit').html('').removeClass('alert alert-danger');
                $('.err_msg_edit').text('');
            }
        });
    </script>
@endpush
