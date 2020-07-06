<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CheckboxCustom extends Component
{
    public $name;
    public $label;
    public $value;
    public $off;
    public $on;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $label, $off, $on, $value = '')
    {
        $this->name = $name;
        $this->label = $label;
        $this->off = $off;
        $this->on = $on;
        $this->value = $value;
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.checkbox-custom');
    }
}