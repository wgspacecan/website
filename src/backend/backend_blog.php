<?php
class Blog

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

    private function find_entry() {

    }

    public function create_entry() {

    }

    public function return_entry($postID) {
        $conn = $this->_connect_sql();

        $sql = $conn->prepare("SELECT POST FROM posts WHERE ID = ?");
        $sql->bind_param("s", $postID);
        $sql->execute();
        $result = $sql->get_result();

        $conn->close();
        $this->display_entry($result);
        return $result;
    }

    public function display_entry($entry) {
        if ($entry->num_rows > 0) {
            $row = $entry->fetch_assoc();
            echo $row['POST'];
        }
    }

    public function find_entries() {
        #
        # find_entry();
    }

}

?>