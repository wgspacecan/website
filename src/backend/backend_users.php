<?php
class Users

{

    private function _connect_sql() {

        $conn = new mysqli( $_SERVER["mysqli_default_host"],
                            $_SERVER["mysqli_default_user"],
                            $_SERVER["mysqli_default_pw"], "mydb");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $conn->set_charset("utf8");
        return $conn;
    }

    private function _list_users($conn) {
        $sql = $conn->prepare("SELECT USER FROM users");
        $sql->execute();
        $result = $sql->get_result();

        if ($result->num_rows > 0) {
            echo "Current Users: <br>";
            while($row = $result->fetch_assoc()) {
                echo "user: " . $row["USER"] . "<br>";
            }
        }
    }

    private function _check_existing_user($conn, $user) {
        $sqlt = $conn->prepare("SELECT USER,PASS FROM users WHERE USER = ?");
        $sqlt->bind_param("s", $user);
        $sqlt->execute();
        $result = $sqlt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['PASS'];
        } return False;
    }

    private function _create_new_user($conn, $user, $pass) {
        $sqlt = $conn->prepare("INSERT INTO users (USER, PASS, CODE, LASTLOGIN) VALUES (?, ?, 'NONE', NOW())");
        $sqlt->bind_param("ss", $user, $pass);
        $sqlt->execute();
    }

    private function _create_encrypt_pass($pass) {
        return password_hash($pass, PASSWORD_DEFAULT);
    }

    private function _login_verify_pass($pass, $hash) {
        return password_verify($pass, $hash);
    }

    private function _login($user, $conn) {
        # update login code
        $seed = rand() . $user;
        $code = password_hash($seed, PASSWORD_DEFAULT);
        $sql = $conn->prepare("UPDATE users SET CODE = ?, LASTLOGIN = NOW() WHERE USER = ?");
        $sql->bind_param("ss", $code, $user);
        $sql->execute();
        setcookie("spacepanda_login", $code, time() + (86400), "/"); // 86400 = 1 day
    }

    private function _check_code($conn, $code) {
        $sqlt = $conn->prepare("SELECT USER FROM users WHERE CODE = ? AND LASTLOGIN >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
        $sqlt->bind_param("s", $code);
        $sqlt->execute();
        $result = $sqlt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['USER'];
        } return False;
    }

    private function _verify_username($user) {
        if (strlen($user) > 3) { return True; }
        return False;
    }

    private function _verify_password($pass) { 
        $strict = False;
        $check_1 = preg_match('@[A-Z]@', $pass); # uppercase
        $check_2 = preg_match('@[a-z]@', $pass); # lowercase
        $check_3 = preg_match('@[0-9]@', $pass); # number
        $check_4 = preg_match('@[^\w]@', $pass); # special chars
        $check_5 = strlen($pass) > 3; # length
        if (!$strict and $check_2 and $check_5) { return True; }
        if ($check_1 and $check_2 and $check_3 and $check_4 and $check_5) { return True; }
        return False;
    }

    private function _process_login($fuser, $fpass) { 
        $conn = $this->_connect_sql();
        $hash = $this->_check_existing_user($conn, $fuser);
        if ($hash) {
            if ($this->_login_verify_pass($fpass, $hash)) {
                $this->_login($fuser, $conn);
                $conn->close();
                return "login successful";
            } else {
                $conn->close();
                return "incorrect password";
            }
        } else {
            $conn->close();
            return "entered user does not exist";
        }
    }

    private function _process_create($fuser, $fpass) {
        $conn = $this->_connect_sql();
        if ($this->_verify_username($fuser) == False) {
            $conn->close();
            return "invalid username";
        }
        if ($this->_verify_password($fpass) == False) {
            $conn->close();
            return "invalid password";
        }
        # validate user and password standards TODO
        if ($this->_check_existing_user($conn, $fuser) == False) {
            $this->_create_new_user($conn, $fuser, $this->_create_encrypt_pass($fpass));
            $this->_login($fuser, $conn);
            $conn->close();
            return "user created";
        } else {
            $conn->close();
            return "user already exists";
        }
    }

    #################################################

    public function logout() {
        if(isset($_COOKIE["spacepanda_login"])) {
            setcookie("spacepanda_login", $_COOKIE["spacepanda_login"], time() - (3600), "/"); // 86400 = 1 day
            return True;
        } return False;
    }

    public function display_all() {
        $conn = $this->_connect_sql();
        $this->_list_users($conn);
        $conn->close();
    }

    public function verify() {
        if(isset($_COOKIE["spacepanda_login"])) {
            $code = $_COOKIE["spacepanda_login"];
            $conn = $this->_connect_sql();
            $user = $this->_check_code($conn, $code);
            $conn->close();
            return $user;
        } return False;
    }

    public function process() {
        $return = "No method found";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fuser = $_REQUEST['usr'];
            $fpass = $_REQUEST['pswd'];
            if(isset($_POST['create'])) {
                $return = $this->_process_create($fuser, $fpass);
            } else if(isset($_POST['login'])) {
                $return = $this->_process_login($fuser, $fpass);
            }
        }
        return $return;
    }
}

?>