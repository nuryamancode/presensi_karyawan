<?php

namespace App\Http\Controllers\Human;

use App\Http\Controllers\Controller;
use App\Models\DivisiModel;
use App\Models\HumanResourcesM;
use App\Models\NotifikasiM;
use Illuminate\Http\Request;

class DivisiC extends Controller
{
    public function index(){
        $user_id = auth()->id();
        $hr = HumanResourcesM::where('user_id', $user_id)->first();
        $divisi = DivisiModel::all();
        $notifikasi = NotifikasiM::where('hr_id', $hr->id)->latest()->take(5)->get();
        $notif_false = NotifikasiM::where('hr_id', $hr->id)->where('dibaca', false)->get();
        $jumlah_notif = $notif_false->count();
        $data = [
            'hr'=>$hr,
            'divisi'=>$divisi,
            'notifikasi'=>$notifikasi,
            'jumlah_notif'=>$jumlah_notif,
        ];
        return view('human.v-kelola-divisi', $data);
    }

    public function post(Request $request){
        $divisi = new DivisiModel([
            'nama_divisi'=> $request->input('nama_divisi'),
        ]);
        if ($divisi->save()) {
            alert()->toast('Divisi berhasil dibuat', 'success');
            return redirect()->back();
        }else{
            alert()->toast('Divisi tidak berhasil dibuat', 'error');
            return redirect()->back();
        }
    }

    public function edit(Request $request, $id){
        $divisi = DivisiModel::findOrFail($id);
        $divisi->nama_divisi = $request->input('nama_divisi');
        if ($divisi->update()) {
            alert()->toast('Divisi berhasil diubah', 'success');
            return redirect()->back();
        }else{
            alert()->toast('Divisi tidak berhasil diubah', 'error');
            return redirect()->back();
        }
    }

    public function delete($id){
        $divisi = DivisiModel::findOrFail($id);
        $divisi->delete();
        alert()->toast('Divisi berhasil dihapus', 'success');
        return redirect()->back();
    }
}
