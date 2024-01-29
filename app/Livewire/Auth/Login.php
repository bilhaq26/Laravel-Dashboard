<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Login extends Component
{
    use LivewireAlert;
    public $username, $password, $status;
    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.auth.app')->layoutData([
            'title' => 'Login',
        ]);
    }

    public function loginAttemp()
    {

        $validate = $this->validate([
            'username' => 'required',
            'password' => [
                'required',
                // custom validation if username is dev set validation min:6
                function ($attribute, $value, $fail) {
                    if ($this->username != 'dev') {
                        if (strlen($value) < 6) {
                            $fail('Password minimal 6 karakter!');
                        }
                    }
                },

            ],
        ],[
            'username.required' => 'Username tidak boleh kosong!',
            'password.required' => 'Password tidak boleh kosong!',
        ]);

        if($validate){
            if(Auth::attempt(['username' => $this->username, 'password' => $this->password])){
                $user = User::where('username', $this->username)->first();
                if($user->status == 'active'){
                    return redirect()->route('admin.dashboard.index');
                }else{
                    $this->alert('error', 'Akun anda tidak aktif!', [
                        'position' =>  'center',
                        'timer' =>  3000,
                        'toast' =>  false,
                        'text' =>  '',
                        'confirmButtonText' =>  'OK',
                        'cancelButtonText' =>  'Cancel',
                        'showCancelButton' =>  false,
                        'showConfirmButton' =>  true,
                    ]);
                }
            }else{
                $this->alert('error', 'Username atau Password salah!', [
                    'position' =>  'center',
                    'timer' =>  3000,
                    'toast' =>  false,
                    'text' =>  '',
                    'confirmButtonText' =>  'OK',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  true,
                ]);
            }
        }
    }
}
