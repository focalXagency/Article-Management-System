<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBeAuthorRequest;
use App\Http\Requests\UpdateBeAuthorRequest;
use App\Http\Resources\BeAythorResource;
use App\Models\BeAuthorRequest;
use App\Models\RequestsData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeAuthorRequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-request', ['only' => ['store', 'show']]);
        $this->middleware('permission:edit-data-request', ['only' => ['update', 'show']]);
        $this->middleware('permission:delete-request', ['only' => ['destroy', 'show']]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBeAuthorRequest $request)
    {
        //checking if the user can make a new request
        $beAutorRequests = BeAuthorRequest::where('user_id', auth()->id())->where('status', 'pending')->count();
        if ($beAutorRequests > 0)
            return response()->json(['message' => 'you already have an active request' . $beAutorRequests]);

        //storing the request data
        $beAutorRequest = BeAuthorRequest::create(['user_id' => auth()->id()]);

        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        Storage::disk('public')->put('requestsDocumentes/' . $fileName, file_get_contents($request->file));

        RequestsData::create([
            'country' => $request->country,
            'address' => $request->address,
            'files_path' => 'storage/requestsDocumentes/' . $fileName,
            'be_author_request_id' => $beAutorRequest->id
        ]);

        return response()->json(['message' => 'request added'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $requestData = BeAuthorRequest::with('user', 'request_data')->find($id);
        return response()->json(new BeAythorResource($requestData));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBeAuthorRequest $request, string $id)
    {
        return response()->json($request);
        $requestData = BeAuthorRequest::find($id);
        if (auth()->id() != $requestData->user_id)
            return response()->json(['message' => 'you can not edit other users request']);
        else if ($requestData->status != 'pending')
            return response()->json(['message' => 'you can not edit ' . $requestData->status . ' request']);

        $data = [
            'country' => $request->country,
            'address' => $request->address,
            'request_id' => $requestData->id
        ];

        if (!$request->file)
            array_push($data, ['files_path' => $request->file]);

        $requestData->request_data->update($data);

        return response()->json(['message' => 'request updated!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $requestData = BeAuthorRequest::find($id);
        if (auth()->id() != $requestData->user_id)
            return response()->json(['message' => 'you can not delete other users request']);
        $requestData->delete();
        return response()->json(['message' => 'request deleted!']);
    }
}
