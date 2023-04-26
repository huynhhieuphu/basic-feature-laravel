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
                        <input type="text" id="student_full_name" class="student_full_name form-control">
                        <span class="text-danger err_full_name err_msg"></span>
                    </div>
                    <div class="form-group">
                        <label for="student_email">Email</label>
                        <input type="text" id="student_email" class="student_email form-control">
                        <span class="text-danger err_email err_msg"></span>
                    </div>
                    <div class="form-group">
                        <label for="student_phone">Phone</label>
                        <input type="text" id="student_phone" class="student_phone form-control">
                        <span class="text-danger err_phone err_msg"></span>
                    </div>
                    <div class="form-group">
                        <label for="student_course">Course</label>
                        <input type="text" id="student_course" class="student_course form-control">
                        <span class="text-danger err_course err_msg"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary clear_student" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success add_student">Save</button>
                </div>
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
                    <button type="button" class="btn btn-secondary clear_student" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_student">Update</button>
                </div>
            </div>
        </div>
    </div>
    {{-- editStudentModal --}}

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
            fetchData();

            function fetchData() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('student.fetch') }}',
                    dataType: 'JSON',
                    beforeSend: function () {
                        $('tbody').html('');
                    },
                    success: function (response) {
                        if (response.status == 200) {
                            $.each(response.data, function (key, value) {
                                $('tbody').append('<tr>\n' +
                                    '<td>' + (key + 1) + '</td>\n' +
                                    '<td>' + value.student_full_name + '</td>\n' +
                                    '<td>' + value.student_email + '</td>\n' +
                                    '<td>' + value.student_phone + '</td>\n' +
                                    '<td>' + value.student_course + '</td>\n' +
                                    '<td><button type="button" data-id="' + value.student_id + '" class="btn btn-primary btn-sm edit_student">Edit</button></td>\n' +
                                    '<td><button type="button" data-id="' + value.student_id + '" class="btn btn-danger btn-sm delete_student">Delete</button></td>\n' +
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
                    beforeSend: function () {
                        clearMessage();
                    },
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

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
                    dataType: 'JSON',
                    beforeSend: function () {
                        clearMessage();
                    },
                    success: function (response) {
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

                        if (response.status === 200) {
                            $('#message').addClass('alert alert-success').text(response.message);
                            $('#editStudentModal').modal('hide');
                            fetchData();
                        }
                    }
                });
            });

            $(document).on('click', '.delete_student', function (e) {
                e.preventDefault();
                let student_id = $(this).data('id');
                let url = '{{ route("student.delete", ["id" => ":id"]) }}';
                url = url.replace(':id', student_id);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'DELETE',
                    url: url,
                    beforeSend: function () {
                        clearMessage();
                    },
                    success: function (response) {
                        if (response.status == 400) {
                            $('#message').addClass('alert alert-danger').text(response.message);
                        }

                        if (response.status == 200) {
                            $('#message').addClass('alert alert-success').text(response.message);
                            fetchData();
                        }
                    }
                });
            });

            $(document).on('click', '.add_student', function (e) {
                e.preventDefault();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{ route("student.store") }}',
                    data: {
                        student_full_name: $('.student_full_name').val(),
                        student_email: $('.student_email').val(),
                        student_phone: $('.student_phone').val(),
                        student_course: $('.student_course').val()
                    },
                    dataType: 'JSON',
                    beforeSend: function () {
                        clearAddStudentModal();
                        clearMessage();
                    },
                    success: function (response) {
                        if (response.status === 400) {
                            $('#saveForm_errList').addClass('alert alert-danger');
                            $.each(response.message, function (key, value) {
                                $('#saveForm_errList').append(`<li>${value}</li>`);
                            });

                            $('.err_full_name').text(response.message.student_full_name);
                            $('.err_email').text(response.message.student_email);
                            $('.err_phone').text(response.message.student_phone);
                            $('.err_course').text(response.message.student_course);
                        }

                        if (response.status === 200) {
                            $('#message').addClass('alert alert-success').text(response.message);
                            $('#addStudentModal').modal('hide').find('input').val('');
                            fetchData();
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

            function clearMessage() {
                $('#message').html('').removeClass('alert alert-danger');
            }
        });
    </script>
@endpush
