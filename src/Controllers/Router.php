<?php

namespace Controllers;

use Exception;
use Http\Request;

class Router
{
    private $request;
    private $isRequest;
    private $pages;

    public function __construct()
    {
        $this->request = Request::getURI();
        $this->isRequest = (new Request)->handleRequest();
        $this->pages = $this->getPages();
        $this->isRequest && $this->backendRoutes();
    }

    /** ----------------------------
     *? Redirect URI
     * -----------------------------
     * Capture & clean URI to filter 
     *  through accepted pages.
     * 
     * @return string url
     */
    public function route()
    {
        // Get url var
        $uri = trim($this->request, "/");
        $uri = explode(".php", $uri);
        $uri = explode("/", $uri[0]);

        // If var empty set to index
        if (empty($uri[0])) {
            $uri[0] = 'index';
        } else if (preg_match('./$.', $this->request)) {
            $i = count($uri);
            $uri[$i - 1] .= '/index';
        }

        // Check for deep roots
        if (isset($uri[1])) {
            $uris = "";
            foreach ($uri as $i) {
                $uris .= $i . "/";
            }
            $uri[0] = substr($uris, 0, -1);
        }

        // Check if site exist
        if (in_array(strtolower($uri[0]), $this->pages)) {
            return '/' . VIEWS . $uri[0] . '.php';
        } else {
            return '/' . VIEWS . '404.php';
        }
    }

    /** ------------------------------
     *? Allow access to backend files
     * -------------------------------
     *  - Get available routes
     *  - Check with URI request
     *  - Verify header matches token
     */
    private function backendRoutes()
    {
        // Get url var
        $uri = trim($this->request, "/");
        $uri = explode(".php", $uri);
        $uri = explode("/", $uri[0]);

        // Check if file exist
        if (in_array(strtolower($uri[1]), $this->pages)) {
            Request::verify_header();
        } else {
            die('Not allowed!');
        }
    }

    /** ----------------------------
     *? Filter Pages
     * -----------------------------
     * Look through folders in 
     *  received path & build array 
     *  of pages to return.
     * 
     * @param string path to page directory
     * @return array pages
     */
    private function getPages()
    {
        try {
            // Build for backend/frontend accessible files
            $this->isRequest
                ? $root = Request::getRoot() . "/" . SCRIPTS
                : $root = Request::getRoot() . "/" . VIEWS;

            $pages = array();
            $directories = array();
            $last_letter  = $root[strlen($root) - 1];
            $root  = ($last_letter == '\\' || $last_letter == '/') ? $root : $root . '/';

            $directories[]  = $root;

            // Get multilevel pages
            while (sizeof($directories)) {
                $dir  = array_pop($directories);
                if ($handle = opendir($dir)) {
                    while (false !== ($file = readdir($handle))) {
                        // Avoid these directories
                        if ($file == '.' || $file == '..') {
                            continue;
                        }
                        // Remove these directories
                        if ($file !== "components" && $file !== "views") {
                            $file  = $dir . $file;
                            if (!$this->isRequest && is_dir($file)) {
                                $directory_path = $file . '/';
                                array_push($directories, $directory_path);
                            } elseif (is_file($file)) {

                                // Remove root
                                $file = str_replace($root, "", $file);
                                // Remove extension
                                $page = explode(".php", $file);
                                array_push($pages, $page[0]);
                            }
                        }
                    }
                    closedir($handle);
                }
            }
            return $pages;
        } catch (Exception $e) {
            print_r($e);
        }
    }

    /** ----------------------------
     *? Format URI
     * -----------------------------
     * Return clean uri as path OR
     *  as page name.
     * 
     * @param string $uri
     * @param boolean $returnName
     * @return string uri or name
     */
    public static function trimURI($returnName = false)
    {
        $page = explode(".php", Request::getURI());
        $page = explode("/", $page[0]);
        $pageName = array_pop($page);
        $root = "";
        foreach ($page as $i) {
            $root .= $i . "/";
        }
        // Return page name
        if ($returnName) {
            empty($pageName) && $pageName = "index";
            $root = $pageName;
        }
        return $root = trim($root, "/");
    }
}
