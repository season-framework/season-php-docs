<?php

class Nav extends \framework\interfaces\Filter
{

    public function process()
    {
        $this->data->subnav = array();
        
        $this->data->subnav[] = array("title" => "Introduction", "link" => "/docs/intro", "pattern" => "/docs/intro", "icon" => "fas fa-home");

        $sub = array("title" => "Getting Started", "icon" => "fas fa-play-circle", "item" => array());
        $sub["item"][] = array("title" => "Installation", "link" => "/docs/starter/install", "pattern" => "/docs/starter/install");
        $sub["item"][] = array("title" => "Concepts", "link" => "/docs/starter/concept", "pattern" => "/docs/starter/concept");
        $sub["item"][] = array("title" => "Structure", "link" => "/docs/starter/structure", "pattern" => "/docs/starter/structure");
        $this->data->subnav[] = $sub;

        $sub = array("title" => "The Basics", "icon" => "fas fa-book", "item" => array());
        $sub["item"][] = array("title" => "\$segment", "link" => "/docs/basics/segment", "pattern" => "/docs/basics/segment");
        $sub["item"][] = array("title" => "\$this->config", "link" => "/docs/basics/config", "pattern" => "/docs/basics/config");
        $sub["item"][] = array("title" => "\$this->request", "link" => "/docs/basics/request", "pattern" => "/docs/basics/request");
        $sub["item"][] = array("title" => "\$this->response", "link" => "/docs/basics/response", "pattern" => "/docs/basics/response");
        $sub["item"][] = array("title" => "\$this->ui", "link" => "/docs/basics/ui", "pattern" => "/docs/basics/ui");
        $sub["item"][] = array("title" => "\$this->lib('database')", "link" => "/docs/basics/database", "pattern" => "/docs/basics/database");
        $this->data->subnav[] = $sub;

        $sub = array("title" => "Skeleton", "icon" => "fas fa-building", "item" => array());
        $sub["item"][] = array("title" => "Overview", "link" => "/docs/skeleton/overview", "pattern" => "/docs/skeleton/overview");
        $sub["item"][] = array("title" => "base_controller.php", "link" => "/docs/skeleton/_controller", "pattern" => "/docs/skeleton/_controller");
        $sub["item"][] = array("title" => "base_model.php", "link" => "/docs/skeleton/_model", "pattern" => "/docs/skeleton/_model");
        $this->data->subnav[] = $sub;

    }
}
