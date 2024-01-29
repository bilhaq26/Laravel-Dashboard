<?php

namespace App\Livewire\Admin\Component;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Topbar extends Component
{
    use LivewireAlert;
    public function render()
    {
        $user = auth()->user();
        return view('livewire.admin.component.topbar',[
            'user' => $user
        ]);
    }

    public function leaveImpersonation()
    {
        if (auth()->user()->isImpersonated()) {
            auth()->user()->leaveImpersonation();
            $this->flash('success','Anda berhasil kembali ke akun Developer',[],route('admin.dashboard.index'));
        }
    }
}
