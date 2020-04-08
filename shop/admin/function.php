<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "shop";

function connect(){
    $conn = mysqli_connect("localhost", "root", "", "shop");
    if(!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function init(){
    $conn = connect();
    $sql = "SELECT id, name FROM goods";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    $out = array();
        while($row = mysqli_fetch_assoc($result)) {
           $out[$row["id"]] = $row;
        }
        echo json_encode($out);
    } else {
        echo "0";
    }
    mysqli_close($conn);
}

function selectOneGoods(){
    $conn = connect();
    $id = $_POST['gid'];
    $sql = "SELECT * FROM goods WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo "0";
    }
    mysqli_close($conn);
}

function updateGoods(){
    $conn = connect();
    $id = $_POST['id'];
    $name = $_POST['gname'];
    $cost = $_POST['gcost'];
    $desc = $_POST['gdesc'];
    $ord = $_POST['gorder'];
    $img = $_POST['gimg'];

    $sql = "UPDATE goods SET name='$name', cost='$cost', description='$desc', ord='$ord', img='$img'  WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    mysqli_close($conn);
    writeJSON();
}

function newGoods(){
    $conn = connect();
    $name = $_POST['gname'];
    $cost = $_POST['gcost'];
    $desc = $_POST['gdesc'];
    $ord = $_POST['gorder'];
    $img = $_POST['gimg'];

    $sql = "INSERT INTO goods(name, cost, description, ord, img)
    VALUES ('$name', '$cost', '$desc', '$ord', '$img')";

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    mysqli_close($conn);
    writeJSON();
}

function writeJSON(){
    $conn = connect();
    $sql = "SELECT * FROM goods";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
    $out = array();
        while($row = mysqli_fetch_assoc($result)) {
           $out[$row["id"]] = $row;
        }
        file_put_contents ('../goods.json', json_encode($out));
    } else {
        echo "0";
    }
    mysqli_close($conn);
}

function loadGoods(){
    $conn = connect();
    $sql = "SELECT * FROM goods";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $out = array();
            while($row = mysqli_fetch_assoc($result)) {
               $out[$row["id"]] = $row;
            }
            echo json_encode($out);
        } else {
            echo "0";
        }
    mysqli_close($conn);
}

function loadSingleGoods(){
    $id = $_POST['id'];
    $conn = connect();
    $sql = "SELECT * FROM goods WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            echo json_encode($row);
        } else {
            echo "0";
        }
    mysqli_close($conn);
}