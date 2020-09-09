<?php

namespace Http;

use Http\Session;

class Request
{

    /** ----------------------------
     *? Redirect browser
     * -----------------------------
     * @return string $query
     */
    public static function redirect($page)
    {
        try {
            $page === "/" && $page = "";
            header("Location: /${page}");
        } catch (Exception $e) {
            $session->set('errors', [$e]);
        }
    }

    /** ----------------------------
     *? Get GET query
     * -----------------------------
     * Get & clean query
     * @return string $query
     */
    public static function get($query)
    {
        try {
            if (isset($_GET[$query])) {
                return htmlspecialchars($_GET[$query]);
            } else {
                return '';
            }
        } catch (Exception $e) {
            $session->set('errors', [$e]);
        }
    }

    /** ----------------------------
     *? Get POST query
     * -----------------------------
     * Get & clean query
     * @return string $query
     */
    public static function post($query)
    {
        if (isset($_POST[$query])) {
            return htmlspecialchars($_POST[$query]);
        } else {
            return '';
        }
    }

    /** ----------------------------
     *? Get All GET queries
     * -----------------------------
     * Get & clean GET queries
     * @return array $form
     */
    public static function allGet()
    {
        try {
            $form = [];
            foreach ($_GET as $name => $value) {
                $form[htmlspecialchars($name)] = htmlspecialchars($value);
            }
            return $form;
        } catch (Exception $e) {
            $session->set('errors', [$e]);
        }
    }

    /** ----------------------------
     *? Get All POST queries
     * -----------------------------
     * Get & clean POST queries
     * @return array $form
     */
    public static function allPost()
    {
        try {
            $form = [];
            foreach ($_POST as $name => $value) {
                $form[htmlspecialchars($name)] = htmlspecialchars($value);
            }
            return $form;
        } catch (Exception $e) {
            $session->set('errors', [$e]);
        }
    }



    public static function getHost()
    {
        if ($_SERVER['HTTP_HOST']) {
            return urldecode(parse_url($_SERVER['HTTP_HOST'], PHP_URL_PATH));
        } else {
            return null;
        }
    }

    public static function getURI()
    {
        if (isset($_SERVER['REQUEST_URI'])) {
            return urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        } else {
            return '/';
        }
    }

    public static function getReferer()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            return urldecode(parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH));
        } else {
            return null;
        }
    }

    /** ----------------------------
     ** Get & return document root
     * -----------------------------
     */
    public static function getRoot()
    {
        if (isset($_SERVER['DOCUMENT_ROOT'])) {
            return urldecode(parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH));
        } else {
            return null;
        }
    }
}
