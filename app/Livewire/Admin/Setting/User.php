<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use App\Models\User as ModelsUser;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class User extends Component
{
    use WithFileUploads, LivewireAlert;
    use WithPagination;
    public $updateMode = false;
    public $search, $photo, $name, $username, $email, $password, $password_confirmation, $role, $prevPhoto, $id, $data, $address, $phone, $jabatan;

    public function getListeners()
    {
        return [
            'onConfirmedAction' => 'onConfirmedAction',
            'changeStatusAction' => 'changeStatusAction',
            'impersonateAction' => 'impersonateAction'
        ];
    }

    public function render()
    {
        $datas = ModelsUser::where('id', '>', '1')->when($this->search, function ($query) {
            // except name developer
            $query->where('name', 'like', '%'.$this->search.'%')
            ->orWhere('username', 'like', '%'.$this->search.'%');
        })->paginate(10); //

        $roles = Role::where('name', '!=', 'developer')->get();
        return view('livewire.admin.setting.user',[
            'datas' => $datas,
            'roles' => $roles
        ])->layout('layouts.admin.app')->layoutData([
            'title' => 'Daftar User'
        ]);
    }

    public function resetInput()
    {
        $this->updateMode = false;
        $this->photo = null;
        $this->name = null;
        $this->username = null;
        $this->email = null;
        $this->address = null;
        $this->phone = null;
        $this->jabatan = null;
        $this->password = null;
        $this->password_confirmation = null;
        $this->role = null;
    }

    public function store()
    {
        $validate = $this->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'name' => 'required|min:3',
            // username tidak boleh ada spasi
            'username' => 'required|min:3|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'role' => 'required'
        ],[
            'photo.required' => 'Foto tidak boleh kosong',
            'photo.image' => 'Foto harus berupa gambar',
            'photo.mimes' => 'Foto harus berupa gambar',
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 3 karakter',
            'username.required' => 'Username tidak boleh kosong',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak sama',
            'role.required' => 'Role tidak boleh kosong',
        ]);
        if($validate && $this->updateMode == false){
            $data = new ModelsUser();
            if($this->photo){
                $photo = $this->photo;
                $photoName = $this->username.'.'.$photo->extension();
                $destinationPath = public_path('storage/user');
                $img = Image::make($photo->path());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$photoName);
                $data->photo = $photoName;
            }
            $data->name = $this->name;
            // penyesuaian jika username menggunakan spasi maka tidak bisa dan harus menggunakan underscore
            $data->username = str_replace(' ', '_', $this->username);
            // role
            $data->assignRole($this->role);
            $data->email = $this->email;
            $data->address = $this->address;
            $data->phone = $this->phone;
            $data->jabatan = $this->jabatan;
            $data->password = Hash::make($this->password);
            $data->save();
            $this->dispatch('closeModal');
            $this->resetInput();
            $this->alert('success', 'User berhasil tambah',[
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  false,
            ]);
        }
    }

    public function edit($id)
    {
        $this->updateMode = true;
        $data = ModelsUser::findOrFail($id);
        $this->id = $id;
        $this->name = $data->name;
        $this->username = $data->username;
        $this->email = $data->email;
        $this->role = $data->roles->pluck('name');
        $this->prevPhoto = $data->photo;
    }

    public function update()
    {
       $validate = $this->validate([
        'username' => 'required|min:3|unique:users,username,'.$this->id,
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email,'.$this->id,
        'role' => 'required'
         ],[
            'username.required' => 'Username tidak boleh kosong',
            'username.min' => 'Username minimal 3 karakter',
            'username.unique' => 'Username sudah digunakan',
            'name.required' => 'Nama tidak boleh kosong',
            'name.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'role.required' => 'Role tidak boleh kosong',
       ]);

       if($validate && $this->updateMode == true){
            $data = ModelsUser::findOrFail($this->id);
            if($this->photo){
                $photo = $this->photo;
                $photoName = $this->username.'.'.$photo->extension();
                $destinationPath = public_path('storage/user');
                $img = Image::make($photo->path());
                $img->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$photoName);
                $data->photo = $photoName;
            }else{
                $data->photo = $this->prevPhoto;
            }
            $data->name = $this->name;
            $data->username = $this->username;
            // role
            $data->syncRoles($this->role);
            $data->email = $this->email;
            $data->address = $this->address;
            $data->phone = $this->phone;
            $data->jabatan = $this->jabatan;
            $data->save();
            $this->dispatch('closeModal');
            $this->resetInput();
            $this->alert('success', 'User berhasil diupdate',[
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  false,
            ]);
        }
    }

    public function destroy($id)
    {
        $this->confirm('Apakah anda yakin?', [
            'text' => 'Menghapus Pengguna ini akan menghapus semua data yang berhubungan dengan pengguna ini!',
            'icon' => 'warning',
            'showCancelButton' => true,
            'onConfirmed' => 'onConfirmedAction',
            'onCancelled' => 'cancelled'
         ]);

         $this->data = ModelsUser::query()->findOrFail($id);
    }

    public function onConfirmedAction()
    {
        if($this->data->photo){
            File::delete('storage/user/'.$this->data->photo);
        }
        $this->data->delete();
        $this->alert('success', 'User berhasil dihapus',[
            'position' =>  'center',
            'timer' =>  3000,
            'toast' =>  false,
        ]);
    }

    public function changeStatus($id)
    {
        $this->confirm('Apakah anda yakin?',[
            'text' => 'Mengubah status pengguna ini akan mengubah status semua data yang berhubungan dengan pengguna ini!',
            'icon' => 'warning',
            'showCancelButton' => true,
            'onConfirmed' => 'changeStatusAction',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = ModelsUser::query()->findOrFail($id);
    }

    public function changeStatusAction()
    {
        if($this->data->status == 'active'){
            $this->data->status = 'inactive';
            $this->data->save();
            $this->alert('success','Status penggunah ini berhasil diubah menjadi inactive');
        }else{
            $this->data->status = 'active';
            $this->data->save();
            $this->alert('success','Status penggunah ini berhasil diubah menjadi active');
        }
    }

    public function impersonate($id)
    {
        $this->confirm('Apakah anda yakin?',[
            'text' => 'Mengimpersonate pengguna ini akan mengubah status semua data yang berhubungan dengan pengguna ini!',
            'icon' => 'warning',
            'showCancelButton' => true,
            'onConfirmed' => 'impersonateAction',
            'onCancelled' => 'cancelled'
        ]);

        $this->data = ModelsUser::query()->findOrFail($id);
    }

    public function impersonateAction()
    {
        if(auth()->user()->id == $this->data->id){
            $this->alert('error','Anda tidak bisa mengimpersonate akun anda sendiri');
         }elseif(auth()->user()->id != $this->data->id){
            auth()->user()->impersonate($this->data);
            $this->flash('success','Anda berhasil mengimpersonate akun '.$this->data->name,[],route('admin.dashboard.index'));
         }
    }


}
