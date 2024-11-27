<?php

namespace App\Http\Controllers;

use App\Models\media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Session\Session;

class mediaController extends Controller
{
  public function index() {
    $mediaFiles = media::all();
    return view('media' , compact('mediaFiles'));
  }

  public function store(Request $request)
    {
        // Validate file
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,gif,webp,svg|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            
            // Get the original extension of the uploaded file
            $extension = $file->getClientOriginalExtension();
            
            // Generate a unique filename including the extension
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Define the destination path
            $destinationPath = base_path('assets/uploads'); // Custom directory for file storage

            // Ensure the directory exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true); // Create the directory if it doesn't exist
            }

            // Move the uploaded file to the assets/uploads directory
            $file->move($destinationPath, $filename);

            // Generate the file URL
            $fileUrl = url('assets/uploads/' . $filename);

            // Save file info to database
            $media = media::create([
                'title' => $filename,
                'url' =>  $fileUrl,
                'alt_text' => $filename,
                'name' => $filename
            ]);

            // Return response with the file URL, ID, and filename
            return response()->json([
                'url' =>  $fileUrl,
                'alt_text' => $media->title,
                'id' => $media->id,
                'title' => $media->title
            ]);
        }

        return response()->json(['success' => false, 'message' => 'File upload failed'], 500);
    }

    public function getMedia($id)
{
    $media = media::find($id);

    if (!$media) {
        return response()->json(['error' => 'Media not found'], 404);
    }

    return response()->json($media);
}
public function update(Request $request)
{
    // Validate the incoming request
    $validator = Validator::make($request->all(),[
        'id' => 'required|exists:media,id', // Media ID must exist in the database
        'title' => 'required|string|max:255', // Title is required
        'alt_text' => 'nullable|string|max:255', // Alt text is nullable
        'caption' => 'nullable|string|max:255', // Caption is nullable
        'description' => 'nullable|string|max:255', // Description is nullable
    ]);

    // If validation fails, return a JSON response with detailed error messages
    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator);
    }

    // Find the media by ID
    $media = media::find($request->id);

    // Update the media fields
    $media->title = $request->title;
    $media->alt_text = $request->alt_text; // Nullable
    $media->caption = $request->caption; // Nullable
    $media->description = $request->description; // Nullable

    // Save the updated media
    $media->save();
    return redirect()->back()->with('success' ,'updated successfully');
}

public function destroy($id) {
    $media = media::find($id);
    if (!$media) {
        return redirect()->back()->with('error','Media Not Found');
    }
    File::delete(base_path('assets/uploads/'.$media->name));
        File::delete(base_path('assets/uploads/'.$media->name));
    $media->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'file deleted successfully'
        ]);
}


public function handleDisplay(Request $request)
{
    // Retrieve the parameters from the request
    $start = $request->input('start', 0);
    $limit = $request->input('limit', 6);
    $query = $request->input('query', '');
    $column = $request->input('column');
    $selectableType = $request->input('selectable_type', 'radio');

    // Build the query to fetch media items
    $mediaQuery = media::query(); // Ensure 'Media' is the correct model name

    // If there is a search query, filter the results
    if (!empty($query)) {
        $mediaQuery->where('name', 'like', '%' . $query . '%'); // Assuming your media has a 'name' field
    }

    // Log the SQL query
    Log::info($mediaQuery->toSql());

    // Paginate the results based on the start and limit
    $mediaItems = $mediaQuery->skip($start)->take($limit)->get();

    // Check if any media items were found
    if ($mediaItems->isEmpty()) {
        return response()->json(['error' => 'Media not found'], 404);
    }

    // Prepare the HTML response data
    $html = '';
    foreach ($mediaItems as $mediaItem) {
        $mediaId = $mediaItem->id;
        $mediaUrl = $mediaItem->url; // Assuming you have a 'url' field
        $mediaName = $mediaItem->name; // Assuming you have a 'name' field
        $backgroundImageUrl = url($mediaUrl); // Generating the full URL

        $inputType = ($selectableType === 'radio') ? 'radio' : 'checkbox'; // Determine input type
        $nameAttribute = ($selectableType === 'radio') ? 'media_id' : 'media_id[]'; 
        $html .= '
        <div class="col-sm-2 col-md-2 col-lg-2 col-6 mb-3 media-item" for="media_id' . $mediaId . '" id="media-item' . $mediaId . '">
            <style>
                .media-image' . $mediaId . ' {
                    background-image: url("' . $backgroundImageUrl . '");
                    min-height: 20vh;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-size: cover;
                    border: 1px solid #dddddd;
                }
            </style>
            <a href="javascript:void(0);" class="btn-media-item form-check-label" data-id="' . $mediaId . '" title="' . $mediaName . '">
                <div class="card thumbnail h-100 media-image' . $mediaId . '">
                    <div class="text-left p-1">
                         <input type="' . $inputType . '" name="' . $nameAttribute . '" class="select-media" id="media_id' . $mediaId . '" 
                        value="' . $mediaUrl . '" data-column="' . $column . '" data-media-url="' . $backgroundImageUrl . '">
                    </div>
                </div>
            </a>
        </div>';
    }

    // Return the HTML to be appended to the media list
    return response()->json(['html' => $html]);
}


}
