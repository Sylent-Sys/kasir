<?php

namespace App\Http\Livewire\Transaksi;

use App\Models\Pembayaran;
use App\Models\TransaksiDetail;
use Livewire\Component;

class FormPembayaran extends Component
{
    public TransaksiDetail $transaksiDetail;
    public $membayar = 0;
    public function render()
    {
        return view('livewire.transaksi.form-pembayaran');
    }
    public function pembayaran($kembalian)
    {
        if (Pembayaran::create([
            'id_user'=>auth()->user()->id,
            'id_transaksi_detail' => $this->transaksiDetail->id,
            'bayar'=>$this->membayar,
            'kembalian'=>$kembalian
        ])->save()) {
            return redirect(route('transaksi.index'));
        }
    }
}
