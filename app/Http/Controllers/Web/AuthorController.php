<?php
namespace App\Http\Controllers\Web;


use App\Models\Author;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\RequestsData;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {  
    $authors = Author::with('userData', 'requestData')->get();
    // return $authors;
    return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthorRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole('Author');

        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        Storage::disk('public')->put('requestsDocumentes/' . $fileName, file_get_contents($request->file));

        $requestData = RequestsData::create([
            'country' => $request->country,
            'address' => $request->address,
            'files_path' => 'public/requestsDocumentes/' . $fileName
        ]);

        Author::create([
            'user_id' => $user->id,
            'request_data_id' => $requestData->id,
        ]);
        return redirect()->route('author.index');  
    }


    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $author = Author::findOrFail($id);
        $user= User::findOrFail($author->user_id);
        $request_data=RequestsData::findOrFail($author->request_data_id);
        return view('authors.update', compact('author','user','request_data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {   try{
        
                
        $user=User::findOrFail($author->user_id);
        $updatedData = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if(isset($request->password)){
            $updatedData['password'] = Hash::make($request->input('password'));
        }
        $user->update($updatedData);   


        $request_data=RequestsData::findOrFail($author->request_data_id);
        $updatedData2 = [
            'address' => $request->address,
            'country' => $request->country,
        ];


        if (isset($request->file)) {
            if (Storage::disk('public')->exists('authorDocs/' . $request->file)) {
                Storage::disk('public')->delete('authorDocs/' . $request->file);
            }

            $fileName = time() . '.' . $request->file->getClientOriginalExtension();
            Storage::disk('public')->put('authorDocs/' . $fileName, file_get_contents($request->file));

            $updatedData2["files_path"] = 'authorDocs/' . $fileName;
            
        }

        $request_data->update($updatedData2);  

        

       $author->update([
        'user_id' => $author->user_id,
        'request_data_id' => $author->request_data_id,
      ]);

      return redirect()->route('author.index')->with('success', 'Author updated successfully.');

    } catch (\Exception $e) {
        return back()->with('error', ' updated Author has been faild');
    }  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        try {
        
                $author->delete();
                $user=User::findOrFail($author->user_id);
                $user->delete();
                $request_data=RequestsData::findOrFail($author->request_data_id);
                $request_data->delete();
                return redirect()->route('author.index')->with('success', 'Author deleted successfully.');
            
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while deleting the author.');
        }
    }
}
