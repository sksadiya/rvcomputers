<!-- JAVASCRIPT -->
<script src="{{ URL::asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    // Function to initialize and show the toast with auto-dismiss
    function showToast(toastId, delay) {
        var toastElement = document.getElementById(toastId);
        if (toastElement) {
            var toast = new bootstrap.Toast(toastElement, {
                delay: delay // Auto-dismiss delay in milliseconds
            });
            toast.show();
        }
    }

    // Show success toast with 6000ms (6 seconds) delay
    showToast('toast-success', 6000);

    // Show error toast with 6000ms (6 seconds) delay
    showToast('toast-danger', 6000);
});
</script>

@yield('script')

<!-- App js -->
<script src="{{ URL::asset('assets/js/app.js')}}"></script>
<script src="{{ URL::asset('assets/libs/dropzone/dropzone-min.js') }}"></script>
<script>
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

		
    // Variables for tracking state
    var start = 0;
    var limit = 23; 
    var index = 0; 
    var selectable_type = '';
    var column_name = '';

    // Open modal and load media when the "btn-select-logo" button is clicked
    $('#btn-select-logo').click(function() { 
        column_name = $(this).attr('data-column'); // Get the column name from the button
        start = 0; // Reset starting index
        selectable_type = 'radio'; // Set selectable type
        $("#search_media").val(""); // Clear search input
        loadMediaList(start, selectable_type, false, column_name); // Load media items
        $("#modal-select-media").modal('show'); // Show the modal
    });
    
    $('#btn-select-banner').click(function() { 
        column_name = $(this).attr('data-column'); // Get the column name from the button
        start = 0; // Reset starting index
        selectable_type = 'radio'; // Set selectable type
        $("#search_media").val(""); // Clear search input
        loadMediaList(start, selectable_type, false, column_name); // Load media items
        $("#modal-select-media").modal('show'); // Show the modal
    });
    $("body").on("click", ".btn-select-variantimage", function() {
            column_name = $(this).attr('data-column');
            start = index = 0;
            selectable_type = 'radio';
            $("#search_media").val("");
            loadMediaList(start, selectable_type, false, column_name);
            $("#modal-select-media").modal('show');
        });
    

    $('#btn-select-gallery-image').click(function() {
            selectable_type = 'checkbox';
            column_name = $(this).attr('data-column');
            start = index = 0;
            $("#search_media").val("");
            loadMediaList(start, selectable_type, false, column_name);
            $("#modal-select-media").modal('show');
        });

    // Function to load media list with pagination or search
    function loadMediaList(start, selectable_type, append = false, column_name) {
        $.ajax({
            url: '{{ route('media.load') }}', // Update with your URL
            type: 'POST',
            data: {
                start: start,
                limit: limit,
                query: $('#search_media').val(),
                selectable_type: selectable_type
            },
            success: function (response) {
                if (!append) {
                    $('.media-list-result').html(response.html); // Load new media items
                } else {
                    $('.media-list-result').append(response.html); // Append more media items
                }
            }
        });
    }

    $("body").on("click", ".media-item", function (e) {
        // Prevent triggering the click on the actual input itself
        if (!$(e.target).is("input")) {
            const input = $(this).find("input");
            if (input.attr("type") === "radio") {
                input.prop("checked", true).trigger("change"); // For radio
            } else if (input.attr("type") === "checkbox") {
                input.prop("checked", !input.prop("checked")).trigger("change"); // For checkbox
            }
        }
    });
    // "Add Selected Image" Button Click Handler
    $('#selectImage').click(function() {
        let selectedMediaId = $('input[name="media_id"]:checked').val();
        let selectedMediaUrl = $('input[name="media_id"]:checked').attr('data-media-url');
        
        if (selectable_type === "radio") {
            // Set the selected media ID to the input field
            $("#" + column_name).val(selectedMediaId);
            
            // Set the image preview (if needed)
            $("#img-" + column_name).attr('src', selectedMediaUrl);
            
            // Show the remove button for the selected image
            $('#btn-remove-' + column_name).show();
        } else {
                var images = '';
                $('input[name="media_id[]"]:checked').each(function(index) {
                    images += `
                    <div id="galleryimage${index}" class="col-sm-6 mb-2 text-center">
                        <div class="img-div">
                            <img src="${$(this).attr('data-media-url')}" alt="image" class="logo-display mx-auto img-fluid" style="height: 48px;">
                            <input type="hidden" value="${$(this).val()}" name="gallery_image_url[]">
                            <button type="button" onClick="removeImage(${index})" style="position: absolute;" class="btn btn-sm btn-danger btn-rounded"><i class="bx bx-trash-alt"></i></button>
                        </div> 
                    </div>` 
                });
                $("#previews").append(images);
            }

        // Close the modal
        $("#modal-select-media").modal('hide');
    });

    // Load more media when the "Load More" button is clicked
    $('#load-more').click(function() {
        start += limit; // Increment the start index
        loadMediaList(start, selectable_type, true, column_name); // Load more media items
    });

    // Form submission handler for the media form (if needed)
    $("body").on("submit", "#form-add-media", function(e) {
        e.preventDefault();
        
        let selectedMediaId = $('input[name="media_id"]:checked').val();
        let selectedMediaUrl = $('input[name="media_id"]:checked').attr('data-media-url');

        if (selectable_type === "radio") {
            $("#" + $(".select-media").attr('data-column')).val(selectedMediaId);
            $("#img-" + column_name).attr('src', selectedMediaUrl);
            $('#btn-remove-' + column_name).show();
        }

        // Hide modal after selecting the image
        $("#modal-select-media").modal('hide');
    });

const dropzone = $("#mediaDropzone").dropzone({ 
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
        window.removeImage = function(index) {
    const element = document.getElementById("galleryimage" + index);
    if (element) {
        element.remove();
    } else {
        console.warn("Element with ID galleryimage" + index + " not found.");
    }
};
    });

</script>

@yield('script-bottom')