<?php

namespace Hirudo\Impl\StandAlone;

use Hirudo\Core\Context\Session as Session;

/**
 * @Hirudo\Core\Annotations\Export(id="session")
 */
class SASession implements Session {

    public function id() {
        return session_id();
    }

    public function &get($key, $default = null) {
        $result = $default;
        if ($this->has($key)) {
            $result = $_SESSION[$key];
        }
        return $result;
    }

    public function put($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function remove($key) {
        $oldValue = $this->get($key);
        unset($_SESSION[$key]);

        return $oldValue;
    }

    public function has($key) {
        return isset($_SESSION[$key]);
    }

    public function state() {
        $result = SessionStates::DESTROYED;

        if ($this->alive) {
            $result = SessionStates::ACTIVE;
        }

        return $result;
    }

    private $alive = true;

//    private $dbc = NULL;

    function __construct() {
//        session_set_save_handler(
//                array(&$this, 'open'), array(&$this, 'close'), array(&$this, 'read'), array(&$this, 'write'), array(&$this, 'destroy'), array(&$this, 'clean'));
//        if (!isset($_COOKIE[ini_get('session.name')])) {
//            session_start();
//        }
    }

    function __destruct() {
        if ($this->alive) {
            session_write_close();
            $this->alive = false;
        }
    }

    function delete() {
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']
            );
        }

        session_destroy();

        $this->alive = false;
    }

//    private function open() {
//        Loader::using("underscore::libs::impl::standalone::JSON");
//        $json = file_get_contents(Loader::toSinglePath("config", ".json"));
//        $config = JSON::Decode($json, true);
//        
//        $connection = $config["dbConnection"];
//        
//        $this->dbc = new MYSQLi($connection["host"], $connection["user"], $connection["pass"], $connection["db"]);
//        
//        return !$this->dbc->connect_error;
//    }
//
//    private function close() {
//        return $this->dbc->close();
//    }
//
//    private function read($sid) {
//        $q = "SELECT `data` FROM `sessions` WHERE `id` = '" . $this->dbc->real_escape_string($sid) . "' LIMIT 1";
//        $r = $this->dbc->query($q);
//
//        if ($r->num_rows == 1) {
//            $fields = $r->fetch_assoc();
//
//            return $fields['data'];
//        } else {
//            return '';
//        }
//    }
//
//    private function write($sid, $data) {
//        $q = "REPLACE INTO `sessions` (`id`, `data`) VALUES ('" . $this->dbc->real_escape_string($sid) . "', '" . $this->dbc->real_escape_string($data) . "')";
//        $this->dbc->query($q);
//
//        return $this->dbc->affected_rows;
//    }
//
//    private function destroy($sid) {
//        $q = "DELETE FROM `sessions` WHERE `id` = '" . $this->dbc->real_escape_string($sid) . "'";
//        $this->dbc->query($q);
//
//        $_SESSION = array();
//
//        return $this->dbc->affected_rows;
//    }
//
//    private function clean($expire) {
//        $q = "DELETE FROM `sessions` WHERE DATE_ADD(`last_accessed`, INTERVAL " . (int) $expire . " SECOND) < NOW()";
//        $this->dbc->query($q);
//
//        return $this->dbc->affected_rows;
//    }
}

?>
