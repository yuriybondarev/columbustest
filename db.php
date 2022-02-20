<?php
const HOST = '127.0.0.1';
const USERNAME = 'root';
const PASSWORD = NULL;
const DATABASENAME = 'columbus';
const PORT = 3306;

$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASENAME, PORT);
?>