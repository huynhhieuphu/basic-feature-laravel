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

                        <form action="{{ route('student.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="student_full_name">Full Name</label>
                                <input type="text" name="student_full_name" class="form-control" value="{{ old('student_full_name') ?? false }}">
                                <span class="text-danger">@error('student_full_name') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="student_email">Email</label>
                                <input type="text" name="student_email" class="form-control" value="{{ old('student_email') ?? false }}">
                                <span class="text-danger">@error('student_email') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="student_phone">Phone</label>
                                <input type="text" name="student_phone" class="form-control" value="{{ old('student_phone') ?? false }}">
                                <span class="text-danger">@error('student_phone') {{ $message }} @enderror</span>
                            </div>
                            <div class="form-group">
                                <label for="student_course">Course</label>
                                <input type="text" name="student_course" class="form-control" value="{{ old('student_course') ?? false }}">
                                <span class="text-danger">@error('student_course') {{ $message }} @enderror</span>
                            </div>
                            <button type="submit" class="btn btn-success">Save Student</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
