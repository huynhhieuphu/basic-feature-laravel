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
                    <button type="button" class="btn btn-success add_student">Save Student</button>
                </div>
            </div>
        </div>
    </div>
    {{-- addStudentModal --}}

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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('script')
    <script>
        $(document).ready(function () {

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
                        student_full_name : $('.student_full_name').val(),
                        student_email : $('.student_email').val(),
                        student_phone : $('.student_phone').val(),
                        student_course : $('.student_course').val()
                    },
                    dataType : 'JSON',
                    beforeSend: function () {
                        $('#saveForm_errList').html('');
                        $('.err_msg').text('');
                    },
                    success: function (response) {
                        console.log(response);

                        if(response.status === 400) {
                            $('#saveForm_errList').addClass('alert alert-danger');
                            $.each(response.message, function (key, value) {
                                $('#saveForm_errList').append(`<li>${value}</li>`);
                            });

                            $('.err_full_name').text(response.message.student_full_name);
                            $('.err_email').text(response.message.student_email);
                            $('.err_phone').text(response.message.student_phone);
                            $('.err_course').text(response.message.student_course);
                        }

                        if(response.status === 200) {
                            $('#saveForm_errList').html('');
                            $('#message').addClass('alert alert-success');
                            $('#message').text(response.message);
                            $('#addStudentModal').modal('hide');
                            $('#addStudentModal').find('input').val('');
                        }
                    }
                });
            })

            $('.clear_student').click(function() {
                $('#saveForm_errList').removeClass('alert alert-success').html('');
                $('.err_msg').text('');
                $('#addStudentModal').find('input').val('');
            });
        });
    </script>
@endpush
