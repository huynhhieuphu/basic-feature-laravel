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
                            <select name="category" id="category_filter" class="form-control">
                                <option value="">Please Category</option>
                                @if(!empty($categories))
                                    @foreach($categories as $category)
                                        <option value="{{$category->name}}" {{ request()->query('category') ? 'selected' : false }}>{{$category->name}}</option>
                                    @endforeach
                                @endif
                            </select>

                            <label for="keyword">&nbsp;&nbsp;</label>
                            <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Enter Keyword" value="{{ request()->query('keyword') ?? false }}">
                            <span>&nbsp;</span>

                            <button type="button" onclick="filter_search();" class="btn btn-primary">Search</button>
                            <span>&nbsp;</span>

                            @if(request()->query('category') || request()->query('keyword'))
                                <a href="{{ route('posts.index') }}" class="btn btn-success">Clear</a>
                            @endif
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
                                        @if(request()->query('sortByComments') && request()->query('sortByComments') == 'asc')
                                            <a href="javascript:sort('desc')"><i class="fa fa-sort-desc"></i></a>
                                        @elseif(request()->query('sortByComments') && request()->query('sortByComments') == 'desc')
                                            <a href="javascript:sort('asc')"><i class="fa fa-sort-asc"></i></a>
                                        @else
                                            <a href="javascript:sort('asc')"><i class="fa fa-sort"></i></a>
                                        @endif
                                    </th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($posts))
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>{{ $post->id }}</td>
                                            <td style="width: 35%;">{{ $post->title }}</td>
                                            <td>{{ $post->user->name }}</td>
                                            <td>{{ $post->category->name }}</td>
                                            <td align="center">{{ $post->comments_count }}</td>
                                            <td style="width: 250px;">
                                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-primary">View</a>
                                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success">Edit</a>
                                                <a href="" class="btn btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">NO DATA</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            {{ $posts->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        let query_string = <?php echo json_encode((object) request()->query()); ?>;
        /*console.log(typeof query_string);
        console.log(query_string);*/

        function filter_search() {
            Object.assign(query_string, {'category' : $('#category_filter').val()});
            Object.assign(query_string, {'keyword' : $('#keyword').val()});
            console.log(query_string);
            window.location.href = "{{ route('posts.index') }}?" + $.param(query_string);
        }

        function sort(value) {
            Object.assign(query_string, {'sortByComments' : value});
            window.location.href = "{{ route('posts.index') }}?" + $.param(query_string);
        }
    </script>
@endpush
