@extends('layout.master')

@section('title') Media  @endsection
@section('css')

@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 mb-3">
        <h4 class="card-title mb-0">Manage media</h4>
    </div>
    <div class="card">
        <div class="card-body">
            <div>
                <div class="dropzone dz-clickable" id="mediaIndexDropzone">
                    <div class="dz-message needsclick">
                        <div class="mb-3">
                            <i class="display-4 text-muted bx bxs-cloud-upload"></i>
                        </div>
                        <h4>Drop files here or click to upload.</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Manage Media</h4>
        </div>
        <div class="card-footer text-center">
            <div class="row" id="media-item-list">
            @foreach ($mediaFiles as $media)
                <div class="col-sm-2 col-md-3 col-lg-2 col-6 mb-3" id="media-item{{ $media->id }}">
                    <style>
                        .media-image{{ $media->id }} {
                            background-image: url("{{ $media->url }}");
                            min-height: 20vh;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-size: cover;
                            border: 1px solid #dddddd;
                        }
                    </style>
                    <a href="javascript:void(0);" class="btn-media-item form-check-label" data-id="{{ $media->id }}" title="{{ $media->title }}">
                        <div class="card thumbnail h-100 media-image{{ $media->id }}">
                        </div>
                    </a>
                </div>
            @endforeach
            </div>
        </div>
</div>

<!-- Modal -->
<div class="modal fade show" id="modal-update-media" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form action="{{ route('media.update')}}" id="form-update-media" method="post" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control @error('id') is-invalid @enderror" name="id" id="media-id">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Update Media</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-light" style="max-height: 70vh; overflow-y: auto;"> <!-- Ensure scrollable -->
                    <div class="row">
                        <div class="col-sm-8  col-lg-8 col-md-12 col-12 bg-white mb-3">
                            <img id="media-image" src="" alt="" class="rounded" height="500px" style="opacity: .8">
                        </div>
                        <div class="col-sm-4 col-lg-4 col-md-12 col-12">
                            <div class="form-group mb-3">
                                <label>Title</label>
                                <input type="text" name="title" id="media-title" class="form-control @error('title') is-invalid @enderror" placeholder="Title">
                                @error('title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>Alternative Text</label>
                                <input type="text" name="alt_text" id="media-alt-text" class="form-control @error('alt_text') is-invalid @enderror" placeholder="Alternative Text">
                                @error('alt_text')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>Caption</label>
                                <input type="text" name="caption" id="media-caption" class="form-control @error('caption') is-invalid @enderror" placeholder="Caption">
                                @error('caption')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>Description</label>
                                <input type="text" name="description" id="media-description" class="form-control @error('description') is-invalid @enderror" placeholder="Description">
                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label>File URL</label>
                                <input type="text" id="media-url" class="form-control" readonly>
                            </div>
                            <div class="form-group mb-3 text-center">
                                <button type="submit" id="btn-update" class="btn btn-primary">Save</button> 
                                <button type="button"  id="btn-delete" class="btn btn-danger">Delete</button> 
                                <a href="" id="media-download" target="_blank" class="btn btn-success">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@include('layout.session')
@endsection
@section('script')
<script>
        $(document).ready(function() {
    Dropzone.autoDiscover = false;

    $(document).ready(function() {
        const dropzone = $("#mediaIndexDropzone").dropzone({ 
            url: "{{ route('media.upload') }}",  // Use the named route for file upload
            maxFiles: 10,
            paramName: "file",  // The name that will be used to transfer the file
            maxFilesize: 2,     // Max file size in MB
            acceptedFiles: "image/jpeg,image/png,image/webp,image/gif,image/svg+xml",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            init: function () {
                this.on("success", function (file, response) {
                    addImageToGrid(response.url, response.id, response.title);
                });
                this.on("error", function (file, response) {
                    // Handle errors if needed
                    console.error(response);
                });
            }
        });

        // Function to dynamically add the image to the grid
        function addImageToGrid(fileUrl, id, fileName) {
            var mediaContainer = document.getElementById('media-item-list'); // Container holding all media items
            var newItem = `
                <div class="col-sm-2 col-md-2 col-lg-2 col-6 mb-3" id="media-item${id}">
                    <style>
                        .media-image${id} {
                            background-image: url("${fileUrl}");
                            min-height: 20vh;
                            background-position: center;
                            background-repeat: no-repeat;
                            background-size: cover;
                            border: 1px solid #dddddd;
                        }
                    </style>
                    <a href="javascript:void(0);" class="btn-media-item form-check-label" data-id="${id}" title="${fileName}">
                        <div class="card thumbnail h-100 media-image${id}">
                        </div>
                    </a>
                </div>`;
            mediaContainer.innerHTML += newItem; // Append the new media item to the grid
        }
    });

    $(document).on('click', '.btn-media-item', function() {
        var mediaId = $(this).data('id');
        var url = `{{ route('get.media', ':ID') }}`.replace(':ID', mediaId);
            $.ajax({
                url:url, // Assuming you have a route to fetch media details
                method: 'GET',
                success: function(media) {
                    $('#media-id').val(media.id);
                    $('#media-image').attr('src', media.url);
                    $('#media-title').val(media.title);
                    $('#media-alt-text').val(media.alt_text);
                    $('#media-caption').val(media.caption);
                    $('#media-description').val(media.description);
                    $('#media-url').val(media.url);
                    $('#media-download').attr('href', media.url);
                    $('#modal-update-media').modal('show');
                    
                },
                error: function(error) {
                    console.error('Error fetching media details:', error);
                }
            });
        });

        $(document).on('click', '#btn-delete', function() {
    var mediaId = $('#media-id').val(); // Get the media ID from the hidden input field
    if (confirm('Are you sure you want to delete this media?')) {
        $.ajax({
            url: `{{ route('media.delete', ':ID') }}`.replace(':ID', mediaId), // Assuming you have a named route for deleting media
            type: 'DELETE',
            data: {
                _token: $('meta[name="_token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message); // Show success message
                    $('#modal-update-media').modal('hide'); // Close modal
                    $('#media-item' + mediaId).remove(); // Remove the media item from the UI
                } else {
                    alert('Failed to delete media.'); // Show failure message
                }
            },
            error: function(xhr) {
                alert('An error occurred while deleting the media.'); // Show error message
                console.error('Delete error:', xhr);
            }
        });
    }
});
        });
</script>

@endsection