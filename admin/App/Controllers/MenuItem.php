<?php

namespace App\Controllers;

class MenuItem
{
    public $title;
    public $link;
    public $submenu;

    public function __construct($title, $link, $submenu = [])
    {
        $this->title = $title;
        $this->link = $link;

        if (!empty($submenu)) {
            $this->submenu = array_filter($submenu, function ($item) {
                return !empty($item->link);
            });

            if (empty($this->submenu)) {
                $this->submenu = null;
            }
        }
    }
}
