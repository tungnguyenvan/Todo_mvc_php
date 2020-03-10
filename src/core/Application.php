<?php

class Application {
    private $controller = 'Home';
    private $action = 'all';
    private $params = [];

    function __construct() {
        $arr = $this->urlProcess();

        // controller
        if (file_exists('./src/controllers/' . $arr[0] . 'Controller.php')) {
            $this->controller = $arr[0];
            unset($arr[0]);
        }
        $this->controller .= 'Controller';
        require_once './src/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // action
        if (isset($arr[1])) {
            if (method_exists($this->controller, $arr[1])) {
                $this->action = $arr[1];
            }
            unset($arr[1]);
        }

        // params
        if (count($arr)) {
            $this->params = $arr;
        }

        // run action
        call_user_func_array([$this->controller, $this->action], $this->params);
    }

    private function urlProcess() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(trim($_GET['url'], '/')));
        }
    }
}

?>