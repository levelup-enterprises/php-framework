<?php

namespace Controllers;

use Http\request;
use Controllers\Router;

class Link
{

    function __construct()
    {
        $this->views = VIEWS;
        $router = new Router;
        $this->uri = $router->trimURI();
        $this->page = $router->trimURI(true);
        $this->root = request::getRoot();
    }

    public function public($path)
    {
        return "/public/${path}/";
    }

    public function get($path)
    {
        return "/$this->root/$this->views/${path}/";
    }

    public function page($path)
    {
        return "/$this->root/$this->views$this->uri/views/${path}/";
    }

    /** -------------------------
     *? Return current view path
     * --------------------------
     * Includes current page view
     */
    public function getView()
    {
        isset($this->uri) ? $page = "/" . $this->uri : "";
        return "/$this->root/$this->views$page/views/$this->page.view.php";
    }

    /** -------------------------
     *? Return Component path 
     * --------------------------
     * Return requested component path
     */
    public function getComponent($component)
    {
        return "/$this->root/$this->views/components/$component.php";
    }
}
