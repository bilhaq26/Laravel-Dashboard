<?php

namespace App\Livewire\Admin\Component;

use App\Models\Setting\Identity;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        $menus = [
            [
                'header' => 'Dashboard',
                'name' => 'Dashboard',
                'icon' => 'ti ti-home-2',
                'active' => request()->routeIs('admin.dashboard.*'),
                'url' => 'javascript:;',
                'can' => ['developer', 'admin', 'user'],
                'sub_menu' => [
                    [
                        'name' => 'Dashboard',
                        'icon' => '',
                        'active' => request()->routeIs('admin.dashboard.*'),
                        'url' => route('admin.dashboard.index'),
                        'can' => ['developer', 'admin', 'user'],
                    ],
                ]
            ],
            [   'header' => 'Setting Application',
                'name' => 'Setting',
                'icon' => 'ti ti-settings',
                'active' => request()->routeIs('admin.setting.*'),
                'url' => 'javascript:;',
                'can' => ['developer', 'admin'],
                'sub_menu' => [
                    [
                        'name' => 'User',
                        'icon' => '',
                        'active' => request()->routeIs('admin.setting.user'),
                        'url' => route('admin.setting.user'),
                        'can' => ['developer', 'admin','user'],
                    ],
                ]
            ],
        ];

        $user = auth()->user();
        return view('livewire.admin.component.navbar',[
            'menus' => $menus,
            'user' => $user,
        ]);
    }
}
