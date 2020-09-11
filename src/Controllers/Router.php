<?php

namespace Controllers;

use Http\request;

/*
 |----------------------------------------------------------------------------|
 | Router finds valid pages from views directory
 |----------------------------------------------------------------------------|
 - Add additional pages in views directory* 
 - Any additional directories will be validated for pages
 - EX:
 - es/
    - index.php
    - 404.php
 */

class Router
{
    private $request;
    private $pages;
    private $views;

    public function __construct()
    {
        $this->request = Request::getURI();
        $this->views = VIEWS;
        $this->pages = $this->getPages($this->views);
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
            return '/' . $this->views . $uri[0] . '.php';
        } else {
            return '/' . $this->views . '404.php';
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
    private function getPages($root)
    {
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
                        if (is_dir($file)) {
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
