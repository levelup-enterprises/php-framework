<?php

namespace Http;

use Utilities\Request;

class Session
{

    /** ---------------------------------
     ** Initialize session with login
     *  ---------------------------------
     * @param bool login default true
     */
    function __construct($login = true)
    {
        $this->start();
        $this->requireLogin = $login;
    }

    /** ---------------------------
     *? Start session
     * ----------------------------
     * Start new session with 
     *  timeout counter.
     */
    private function start()
    {
        session_start();
        $this->timeout();
    }

    /** ---------------------------
     *? Create session
     * ----------------------------
     * Create session from value 
     * @param string $session
     * @param string $value
     * @param bool $override replace value
     */
    public function set($session, $value, $override = false)
    {
        if (!$override && isset($_SESSION[$session])) {
            is_array($value) && $value = $value[0];
            array_push($_SESSION[$session], $value);
        } else {
            $_SESSION[$session] = $value;
        }
    }

    /** ---------------------------
     *? Get session
     * ----------------------------
     * Get requested session
     * Optional clear after use
     * @param string $session
     * @param bool $clear get and clear
     * @return mixed array OR string
     */
    public function get($session, $clear = null)
    {
        if (isset($_SESSION) && isset($_SESSION[$session])) {
            $return = $_SESSION[$session];
            $clear !== null && $this->clear($session);
            return $return;
        }
    }

    /** ---------------------------
     *? Clear session data
     * ----------------------------
     * - Destroy session
     */
    public function clear($session = null)
    {
        if ($session === null) {
            if (isset($_SESSION)) {
                unset($_SESSION['errors']);
                unset($_SESSION['success']);
                unset($_SESSION['info']);
                unset($_SESSION['warnings']);
            }
        } else {
            if (isset($_SESSION)) {
                unset($_SESSION[$session]);
            }
        }
    }

    /** ---------------------------
     *? Check for user session
     * ----------------------------
     * Redirect to login if session
     *  not set.
     * @param string $session
     */
    public function active($session)
    {
        if (isset($_SESSION) && isset($_SESSION[$session])) {
            return $_SESSION[$session];
        } else {
            request::redirect('login');
        }
    }

    /** ---------------------------
     *? Logout current user
     * ----------------------------
     * - Destroy session
     * - Redirect to login page
     */
    public function logout()
    {
        if (isset($_SESSION)) {
            session_unset();
            session_destroy();

            $this->requireLogin
                ? request::redirect('login')
                : request::redirect('/');
        }
    }

    /** ---------------------------
     *? Set timeout
     * -----------------------------
     * Set timeout counter for 
     *   session.
     * @param string $session
     */
    private function timeout()
    {
        if (
            !empty($this->get('LAST_ACTIVITY'))
            && (time() - $this->get('LAST_ACTIVITY') > TIMEOUT)
        ) {
            $this->logout();
        }
        $this->set('LAST_ACTIVITY', time(), true);
    }

    /** ---------------------------
     *? Set CSRF Token
     * -----------------------------
     * Set token if it doesn't 
     *  exist, get token.
     * @return string token
     */
    public function csrf_token()
    {
        if (empty($this->get('auth_token'))) {
            $this->set('auth_token', bin2hex(random_bytes(20)));
        }
        return $this->get('auth_token');
    }

    /** ---------------------------
     *? Verify CSRF Token
     * -----------------------------
     * Compare session token with
     *  post token.
     * @param POST csrf-token
     * @return bool
     */
    public function verify_token($token = false)
    {
        !$token && $token = Helper::post('csrf-token');
        if (!empty($this->get('auth_token')) && !empty($token)) {
            if (hash_equals($this->get('auth_token'), $token)) {
                return true;
            }
        }
        return false;
    }

    /** ---------------------------
     *? Verify Header Token
     * -----------------------------
     * Compare session token with
     *  header token to 
     *  validate ajax.
     * 
     * @param HTTP header
     * @return bool
     */
    public function verify_header()
    {
        if ($_SERVER['HTTP_X_AUTH_TOKEN'] !== $this->get('auth_token')) {
            $this->logout();
        }
    }
}
