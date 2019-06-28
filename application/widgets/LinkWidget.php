<?php

class LinkWidget extends Widget implements IWidget
{
    public function render()
    {
        return $this->view->make('link', [])->render();
    }
}