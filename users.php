<?php
class Users {

    private function _connect_sql() {
        $servername = "localhost";
        $username = "webuser";
        $password = "Tb5T9eRvC2qTODYMMF";
        $dbname = "mydb";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
            return;
        } return $conn;
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
        setcookie("wg_login", $code, time() + (85400), "/"); // 86400 = 1 day
    }

    private function _check_code($conn, $code) {
        $sqlt = $conn->prepare("SELECT USER FROM users WHERE CODE = ? AND LASTLOGIN >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)");
        $sqlt->bind_param("s", $code);
        $sqlt->execute();
        $result = $sqlt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['USER'];
        } return False;
    }

    #################################################

    public function logout() {
        if(isset($_COOKIE["wg_login"])) {
            setcookie("wg_login", $_COOKIE["wg_login"], time() - (3600), "/"); // 86400 = 1 day
            return True;
        } return False;
    }

    public function display_current_users() {
        $conn = $this->_connect_sql();
        $this->_list_users($conn);
        $conn->close();
    }

    public function verify() {
        if(isset($_COOKIE["wg_login"])) {
            $code = $_COOKIE["wg_login"];
            $conn = $this->_connect_sql();
            $user = $this->_check_code($conn, $code);
            $conn->close();
            return $user;
        } return False;
    }

    public function process() {
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fuser = $_REQUEST['usr'];
            $fpass = $_REQUEST['pswd'];
            $conn = $this->_connect_sql();

            if(isset($_POST['create'])) {
                # validate user and password standards TODO
                if ($this->_check_existing_user($conn, $fuser) == False) {
                    $this->_create_new_user($conn, $fuser, $this->_create_encrypt_pass($fpass));
                    $this->_login($fuser, $conn);
                    return "user created";
                } else {
                    return "user already exists";
                }
            }

            if(isset($_POST['login'])) {
                
                $hash = $this->_check_existing_user($conn, $fuser);
                if ($hash) {
                    if ($this->_login_verify_pass($fpass, $hash)) {
                        $this->_login($fuser, $conn);
                    } else {
                        return "incorrect password";
                    }
                } else {
                    return "entered user does not exist";
                }
            }

            $conn->close();
        }
    }
}

?>