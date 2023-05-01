@extends('layouts.app')

@section('title')
    {{ $title ?? false }}
@endsection

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            {{ $title ?? false }}
                            <a href="{{ route('student.index') }}" class="btn btn-secondary float-right">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @if(!empty(session('msg')))
                            {{ session('msg') }}
                        @endif

                        @if($errors->any())
                            <ul class="alert alert-danger">
                                @foreach($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        @endif

                        <form action="{{ route('student.update', ['student' => $student]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="student_full_name">Full Name</label>
                                <input type="text" name="student_full_name" class="form-control" value="{{ old('student_full_name') ?? $student->student_full_name }}">
                                <span class="text-danger">@error('student_full_name') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="student_email">Email</label>
                                <input type="text" name="student_email" class="form-control" value="{{ old('student_email') ?? $student->student_email }}">
                                <span class="text-danger">@error('student_email') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="student_phone">Phone</label>
                                <input type="text" name="student_phone" class="form-control" value="{{ old('student_phone') ?? $student->student_phone }}">
                                <span class="text-danger">@error('student_phone') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="student_course">Course</label>
                                <input type="text" name="student_course" class="form-control" value="{{ old('student_course') ?? $student->student_course }}">
                                <span class="text-danger">@error('student_course') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="student_course">Avatar</label>
                                <input type="file" name="student_avatar" class="form-control">
                                <span class="text-danger">@error('student_avatar') {{ $message }} @enderror</span>
                                @if(!empty($student->student_avatar))
                                    <img src="{{ asset('app/uploads/'. $student->student_avatar) }}" alt="{{$student->student_course}}" width="100" height="100" class="my-2">
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Update Student</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
