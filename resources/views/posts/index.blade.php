@extends('layouts.app')

@section('title')
    {{ $title ?? false }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div>Posts</div>
                            <div><a href="{{ route('posts.create') }}" class="btn btn-success">Create Post</a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="" class="form-inline mb-2">
                            <label for="category_filter">Filter By Category &nbsp;</label>
                            <select name="category_filter" class="form-control">
                                <option value="">Please Category</option>

                            </select>

                            <label for="keyword">&nbsp;&nbsp;</label>
                            <input type="text" name="keyword" class="form-control" placeholder="Enter Keyword">
                            <span>&nbsp;</span>

                            <button type="button" class="btn btn-primary">Search</button>
                            <span>&nbsp;</span>

                            <a href="" class="btn btn-success">Clear</a>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Created By</th>
                                        <th>Category</th>
                                        <th>Total Comments
                                            <a href=""><i class="fa fa-sort-desc"></i></a>
                                            <a href=""><i class="fa fa-sort-asc"></i></a>
                                            <a href=""><i class="fa fa-sort"></i></a>
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td>1</td>
                                        <td style="width: 35%;">Tieu de</td>
                                        <td>Tac gia</td>
                                        <td>The loai</td>
                                        <td align="center">2</td>
                                        <td style="width: 250px;">
                                            <a href="" class="btn btn-primary">View</a>
                                            <a href="" class="btn btn-success">Edit</a>
                                            <a href="" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
