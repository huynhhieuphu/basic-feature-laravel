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
                            <div>Edit Post</div>
                            <div><a href="{{ route('posts.index') }}" class="btn btn-success">Back</a></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('posts.update', $post->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title :</label>
                                <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                       value="{{ old('title') ?: $post->title }}">

                                @if($errors->any('title'))
                                    <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description">Description :</label>
                                <textarea name="description" class="form-control"
                                          placeholder="Enter Description">{{ old('description') ?: $post->description }}</textarea>

                                @if($errors->any('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-success" data-toggle="collapse" data-target="#showImage">View Image</button>
                                <div class="collapse" id="showImage">
                                    <img src="{{ asset('uploads/post_image/'.$post->image)  }}" alt="{{ $post->image }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="image">Image :</label>
                                <input type="file" name="image" class="form-control" placeholder="Choose an image">

                                @if($errors->any('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="category">Category :</label>
                                <select name="category" id="category" class="form-control">
                                    <option value="">Please a Category</option>
                                    @if(!empty($categories))
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}"

                                                @if(old('category') && old('category') == $category->id)
                                                    {{ 'selected' }}
                                                @elseif($post->category_id == $category->id)
                                                    {{ 'selected' }}
                                                @endif

                                            >{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if($errors->any('category'))
                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="tags">Tags :</label>
                                <select name="tags[]" id="tags" class="form-control" multiple>
                                    <option value="">Please Tags</option>
                                    @if(!empty($tags))
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}"

                                                @if(old('tags') && in_array($tag->id, old('tags')))
                                                    {{ 'selected' }}
                                                @elseif(in_array($tag->id, $post->getTagsIdArr()))
                                                    {{ 'selected' }}
                                                @endif

                                            >{{ $tag->name }}</option>
                                        @endforeach
                                    @endif
                                </select>

                                @if($errors->any('tags'))
                                    <span class="text-danger">{{ $errors->first('tags') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('/app/css/select2.min.css') }}">
@endpush

@push('script')
    <script src="{{ asset('app/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        $("#category").select2({
            placeholder: "Select a category",
            allowClear: true
        });

        $("#tags").select2({
            placeholder: "Select tags",
            allowClear: true
        });
    </script>
@endpush
