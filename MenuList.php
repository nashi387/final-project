<?php

namespace App\Livewire\Menu;

use Livewire\Component;
use App\Models\Menu;

class Menulist extends Component
{
    public $name, $price, $category, $menuId;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required',
        'price' => 'required|numeric|min:1',
        'category' => 'nullable|string'
    ];

    public function save()
    {
        $this->validate();

        Menu::create([
            'name' => $this->name, 
            'price' => $this->price, 
            'category' => $this->category, 
        ]);

        $this->resetForm();
    }

    public function edit($id)
    {
        $menu = Menu::find($id);

        $this->menuId = $menu->id;
        $this->name = $menu->name;
        $this->price = $menu->price;
        $this->category = $menu->category;
        $this->isEdit = true;
    }

    public function update()
    {
        $this->validate();
        Menu::find($this->menuId)->update([ 
            'name' => $this->name, 
            'price' => $this->price, 
            'category' => $this->category, 
        ]);

        $this->resetForm();
    }

    public function delete($id)
    {
        Menu::find($id)->delete();
    }

    public function resetForm()
    {
        $this->reset(['name', 'price', 'category', 'menuId', 'isEdit']);
    }

    public function render()
    {
        return view('livewire.menu.menu-list', [ 
            'menus' => Menu::orderBy('name')->get() 
        ])->layout('layouts.app');
    }
}