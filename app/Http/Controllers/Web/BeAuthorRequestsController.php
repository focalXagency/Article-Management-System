<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use App\Mail\DemoMail;
use App\Models\Author;
use App\Models\RequestsData;
use Illuminate\Http\Request;
use App\Models\BeAuthorRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class BeAuthorRequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:accept-request', ['only' => ['index']]);
    }

    public function index()
    {
        $requests = BeAuthorRequest::with('user', 'request_data')->where('status', 'pending')->get();
        return view('requests.list', compact('requests'));
    }

    public function indexDone()
    {
        $requests = BeAuthorRequest::with('user', 'request_data')->where('status', '!=', 'pending')->get();
        return view('requests.list', compact('requests'));
    }

    public function show(string $id)
    {
        $request = BeAuthorRequest::where('id', $id)->with('user', 'request_data')->get();
        $request = $request[0];
        return view('requests.show', compact('request'));
    }

    public function reject(BeAuthorRequest $id)
    {
        $id->update([
            'status' => 'rejected'
        ]);
        return redirect()->route('requests.index');
    }

    public function accept(string $id)
    {
        //getting the request
        $request = BeAuthorRequest::where('id', $id)->with('user', 'request_data')->get();
        $request = $request[0];

        //changinf the role of the user
        $user = User::find($request->user->id);
        $user->removeRole('Member');
        $user->assignRole('Author');

        //link the requsts data to the author
        $request_data = RequestsData::find($request->request_data->id);
        $authors = Author::create([
            'user_id' => $user->id,
         

            'request_data_id' => $request_data->id,
        ]);

        //updating the request status to accepted
        $request->update([
            'status' => 'accepted'
        ]);

        $this->sendAcceptanceEmail($request->user);

        return redirect()->route('requests.index')->with('success', 'Request accepted and email sent.');
    } 

    private function sendAcceptanceEmail($user)
    {
        $mailData = [
            'title' => 'Your Author Request Has Been Accepted',
            'body' => 'Congratulations! Your request to become an author has been accepted.'
        ];
        Mail::to($user->email)->send(new DemoMail($mailData));
    }
    }
   
