<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $password = $_POST["password"];
    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        echo "<h3>Password: $password</h3>";
        echo "<h3>Hash: $hash</h3>";
    } else {
        echo "<p style='color:red'>Masukkan password!</p>";
    }
}
?>

<form method="post">
    <label>Masukkan Password:</label><br>
    <input type="text" name="password" required>
    <button type="submit">Generate Hash</button>
</form>
