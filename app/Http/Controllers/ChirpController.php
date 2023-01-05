<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChirpRequest;
use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChirpRequest $request)
    {
        /*$validated = $request->validate([
            'message' => 'required|string|max:255|min:15',
        ]);*/
        $validated = $request->validated();
        $request->user()->chirps()->create($validated);
        return redirect(route('chirps.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Chirp $chirp
     * @return \Illuminate\Http\Response
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Chirp $chirp
     * @return \Illuminate\Http\Response
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        return view('chirps.edit', [
            'chirp' => $chirp,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Chirp $chirp
     * @return \Illuminate\Http\Response
     */
    public function update(ChirpRequest $request, Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        /*$validated = $request->validate([
            'message' => 'required|string|max:255|min:15',
        ]);*/
        $validated = $request->validated();
        $chirp->update($validated);
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Chirp $chirp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize('delete', $chirp);
        $chirp->delete();
        return redirect(route('chirps.index'));
    }

    public function sendmail()
    {
        $data = array('name'=>"Virat Gandhi");
        Mail::send(['text' => 'emails.test'], $data, function ($message) {
            $message->to('mamun1214@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
            $message->from('mamun@localhost', 'Virat Gandhi');
        });
        echo "Basic Email Sent. Check your inbox.";
    }
}
