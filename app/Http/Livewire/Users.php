<?php

namespace App\Http\Livewire;

use Livewire\Component;
use \Carbon\Carbon;
use \App\Models\User;
use \App\Models\UserPackage;

class Users extends Component
{
    public $users, $user_id, $name, $email, $noHp, $packageId, $type, $number;
	public $isModalUser = 0;
	public $isModalPackage = 0;

    public function render()
    {
    	$this->users = User::with('userPackages')->get();
        return view('livewire.user.users');
    }
    
	public function create()
    {
        $this->resetFields();
        $this->openModal();
    }

    public function closeModal($type = 'user')
    {
    	if ($type == 'user') {
	        $this->isModalUser = false;
    	}else{
	        $this->isModalPackage = false;
    	}
    }

    public function openModal($type = 'user')
    {
    	if ($type == 'user') {
	        $this->isModalUser = true;
    	}else{
	        $this->isModalPackage = true;
    	}
    }

    public function resetFields()
    {
        $this->user_id = '';
        $this->name = '';
        $this->email = '';
        $this->no_hp = '';
    }

    public function store()
    {
        $this->validate([
            'name' 		=> 'required|string',
            'email' 	=> 'required|email|unique:users,email,' . $this->user_id,
            'no_hp' 	=> 'required',
            'type'		=> 'required',
            'number'	=> 'required|numeric',
            'packageId' => 'required|numeric',
        ]);

        $user = User::updateOrCreate(['id' => $this->user_id], [
            'name' 				=> $this->name,
            'duration_number' 	=> $this->durationNumber,
            'duration_type' 	=> $this->durationType,
            'price' 			=> $this->price,
        ]);
        if (!$this->user_id) {
	    	$this->StoreUpdatePackage($user);
        }

        session()->flash('message', $this->user_id ? $this->name . ' updated': $this->name . ' added');
        $this->closeModal(); //TUTUP MODAL
        $this->resetFields(); //DAN BERSIHKAN FIELD
    }

    public function openUpdatePackage($id)
    {
    	$this->user_id = $id;
    	$this->openModal('package');
    }

    public function updatePackage($id)
    {
    	$user = User::find($id);
    	$this->validate([
            'type'		=> 'required',
            'number'	=> 'required|numeric',
            'packageId' => 'required|numeric',
        ]);

        $this->StoreUpdatePackage($user);
        $this->closeModal('package'); //TUTUP MODAL
    }

    public function StoreUpdatePackage($user)
    {
    	$dueDate = new Carbon($user->due_date);
    	switch($this->type){
    		case 'days' 	: $dueDate->addDay($this->number); 	break;
    		case 'weeks' : $dueDate->addDay(7 * $this->number);break;
    		case 'months': $dueDate->addMonth($this->number); 	break;
    		case 'years' : $dueDate->addYear($this->number); 	break;
    	}

    	$lastBuy = new Carbon('now');
    	$user->userPackages()->create([
    		'package_id' => $this->packageId,
    		'due_date' => $dueDate->toDateString(),
    		'last_buy' => $lastBuy->toDateString(),
    		'status' => '1'
    	]);
    	UserPackage::where('status', '1')->update(['status' => '0']);
    }

    public function edit($id)
    {
    	$user = User::find($id);
        $this->user_id = $id;
        $this->name = $package->name;
        $this->email = $package->email;
        $this->noHp = $package->no_hp;

        $this->openModal(); //LALU BUKA MODAL
    }

    public function delete($id)
    {
        $user = User::find($id); //BUAT QUERY UNTUK MENGAMBIL DATA BERDASARKAN ID
        $user->delete(); //LALU HAPUS DATA
        session()->flash('message', $user->name . ' deleted'); //DAN BUAT FLASH MESSAGE UNTUK NOTIFIKASI
    }
}
