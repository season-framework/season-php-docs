<?php

class index_controller extends framework\interfaces\base_controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function main($segment)
    {
        $menu = $segment->get(0, True);
        $lang = $this->lang();
        $this->ui->set_view("doc", "docs/$lang/$menu");
        $this->ui->set_view("content", "docs/layout");
        $this->response->render();
    }
}
