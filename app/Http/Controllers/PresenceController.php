<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PresenceDetail;
use App\DataTables\PresencesDataTable;
use Illuminate\Support\Facades\Storage;
use App\DataTables\PresenceDetailsDataTable;

class PresenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PresencesDataTable $dataTable)
    {
        return $dataTable->render('pages.presence.index');
    

        // $presences = Presence::all();
        // return view('pages.presence.index', compact('presences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.presence.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'waktu_mulai' => 'required',
        ]);
        $presence = new Presence();
        
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug = Str::slug($request->nama_kegiatan);
        $presence->tgl_kegiatan = $request->tgl_kegiatan . ' ' . $request->waktu_mulai;
        $presence->save();

        return redirect()->route('presence.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, PresenceDetailsDataTable $dataTable)
    {
        $presence= Presence::findOrFail($id);
      
        return $dataTable->render ('pages.presence.detail.index', compact('presence'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $presence = Presence::findOrFail($id);
        return view('pages.presence.edit', compact('presence'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_kegiatan' => 'required',
            'tgl_kegiatan' => 'required',
            'waktu_mulai' => 'required',
        ]);

        $presence=Presence::findOrFail($id);
        $presence->nama_kegiatan = $request->nama_kegiatan;
        $presence->slug = Str::slug($request->nama_kegiatan);
        $presence->tgl_kegiatan = $request->tgl_kegiatan . ' ' . $request->waktu_mulai;
        $presence->save();

       

        

        return redirect()->route('presence.index')->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete data detail absen
        $presenceDetail=PresenceDetail::where('presence_id', $id)->get();
        foreach($presenceDetail as $pd) {
            if($pd->tanda_tangan){
                Storage::disk('public_uploads')->delete($pd->tanda_tangan);
            }
            $pd->delete();
        }

                    Presence::destroy($id);
                    return response()->json([
                        'status' => 'success','message' => 'Data berhasil dihapus.'
                    ]);
                    //return redirect()->route('presence.index')->with('success', 'Data berhasil dihapus.');
    }
}
