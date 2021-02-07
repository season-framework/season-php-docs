<?php

class IndexFilter extends \framework\interfaces\Filter
{

    public function process()
    {
        $this->config->load();

        if (isset($_GET['lang'])) {
            $uri = $this->request->uri();
            $this->response->language($_GET['lang']);
            $this->response->redirect($uri);
        }

        if ($this->config->get('maintenance', False) && $this->request->match('/user/auth/load/*') == False) {
            $this->ui->set_layout("/theme/stop");
            $this->response->render();
        }

        if ($this->request->match("/")) {
            $this->response->redirect("/docs/intro");
        }

        $this->ui->set_error_layout("/theme/error");
        $this->ui->set_layout("/theme/layout");
        $this->ui->set_view("notice", "/theme/components/notice");
        $this->ui->set_view("head", "/theme/components/head");
        $this->ui->set_view("nav", "/theme/components/nav");
        $this->ui->set_view("footer", "/theme/components/footer");
    }
}
