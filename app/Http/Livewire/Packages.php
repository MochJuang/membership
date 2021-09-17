<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \App\Models\Package;

class Packages extends Component
{
	public $packages, $packageId, $name, $durationNumber, $durationType, $price;
	public $isModal = 0;
    public function render()
    {
    	$this->packages = Package::orderBy('created_at', 'ASC')->get();
        return view('livewire.package.packages');
    }
	public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function closeModal()
    {
        $this->isModal = false;
    }

    public function openModal()
    {
        $this->isModal = true;
    }

    public function resetFields()
    {
        $this->packageId = '';
        $this->name = '';
        $this->durationNumber = '';
        $this->durationType = '';
        $this->price = '';
    }

    public function store()
    {
        $this->validate([
            'name' 				=> 'required|string',
            'durationNumber' 	=> 'required|numeric',
            'durationType' 		=> 'required',
            'price' 			=> 'required|numeric'
        ]);

        Package::updateOrCreate(['id' => $this->packageId], [
            'name' 				=> $this->name,
            'duration_number' 	=> $this->durationNumber,
            'duration_type' 	=> $this->durationType,
            'price' 			=> $this->price,
        ]);

        session()->flash('message', $this->packageId ? $this->name . ' updated': $this->name . ' added');
        $this->closeModal(); //TUTUP MODAL
        $this->resetFields(); //DAN BERSIHKAN FIELD
    }

    public function edit($id)
    {
        $package = Package::find($id); //BUAT QUERY UTK PENGAMBILAN DATA
        $this->packageId = $id;
        $this->name = $package->name;
        $this->durationNumber = $package->durationNumber;
        $this->durationType = $package->durationType;
        $this->price = $package->price;

        $this->openModal(); //LALU BUKA MODAL
    }

    public function delete($id)
    {
        $package = Package::find($id); //BUAT QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        $package->delete(); //LALU HAPUS DATA
        session()->flash('message ', $package->name . ' deleted'); //DAN BUAT FLASH MESSAGE UNTUK NOTIFIKASI
    }
}
