@extends('layouts.app')

@section('title')
    {{ $title ?? false }}
@endsection

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-10 offset-1">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            {{ $title ?? false }}
                            <a href="{{ route('student.create') }}" class="btn btn-success float-right">Add Student</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        @if(!empty(session('msg')))
                            {{ session('msg') }}
                        @endif

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Full name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Course</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($students))
                                @php $i = 1; @endphp
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $student->student_full_name }}</td>
                                        <td>{{ $student->student_email }}</td>
                                        <td>{{ $student->student_phone }}</td>
                                        <td>{{ $student->student_course }}</td>
                                        <td class="d-flex justify-content-between">
                                            <a href="{{ route('student.show', ['student' => $student]) }}" target="_self" class="btn btn-warning">View</a>
                                            <a href="{{ route('student.edit', ['student' => $student]) }}" target="_self" class="btn btn-primary">Edit</a>
                                            <form action="{{ route('student.destroy', ['student' => $student]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
