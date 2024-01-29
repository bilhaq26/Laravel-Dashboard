<?php

namespace App\Livewire\Admin\Component;

use Livewire\Component;

class Breadcrumb extends Component
{
    public $title, $auth;

    public function render()
    {
        $previous = url()->previous();

        // previous title
        $previous = explode('/', $previous);
        $previous = end($previous);
        return view('livewire.admin.component.breadcrumb',[
            'previous' => $previous
        ]);
    }

    public function mount($title)
    {
        $this->auth = auth()->user();
        $this->title = $title;
    }
}
