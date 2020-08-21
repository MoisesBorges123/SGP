<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardHeader extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public $headerText;
    public $headerNumber;
    public $bodyIcon;
    public $footerNumber;
    public $footerIcon;
    public $footerText;
    public $color;
    public $url;

    public function __construct($headerText,$headerNumber,$bodyIcon,$footerNumber,$footerIcon,$footerText,$color,$url)
    {
        //
        $this->headerText   =   $headerText;
        $this->headerNumber =   $headerNumber;
        $this->bodyIcon     =   $bodyIcon;
        $this->footerNumber =   $footerNumber;
        $this->footerIcon   =   $footerIcon;
        $this->footerText   =   $footerText;
        $this->color        =   $color;
        $this->url          =   $url;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.card-header');
    }
}
