<?php

namespace framework\interfaces;

class base_controller extends Controller
{

    protected function status($code = 200, $message = null)
    {
        if ($code == 200) {
            $this->response->json(array("status" => true, "code" => $code, "data" => $message));
        }

        $this->response->json(array("status" => false, "code" => $code, "message" => $message));
    }

    protected function lang()
    {
        $lang = $this->request->language();
        $supported = array();
        if (in_array($lang, $supported)) {
            return $lang;
        }
        return "default";
    }

    public function __construct()
    {
        parent::__construct();
    }
}
