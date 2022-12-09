<?php

$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'http://cardano-wallet:8090/v2/wallets/39fcb465f58313308733a20cbc0c16d80c803e77',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'GET',
CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
),
));

$response = curl_exec($curl);

curl_close($curl);

$obj = json_decode($response);

#echo $response;

echo "wallet: " . $obj->{'name'};

$bal = $obj->{'balance'};
echo "<br>ballance: " . $bal->{'available'}->{'quantity'};

class Wallet

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