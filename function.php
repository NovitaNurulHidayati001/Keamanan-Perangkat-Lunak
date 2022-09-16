<?php

//koneksi
$koneksi = mysqli_connect('localhost', 'root', '', 'keamanan_perangkat-lunak');

//daftar
if(isset($_POST['register']))
{
    //jika register diklik

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password']; // belum di enkripsi

    //fungsi enkripsi
    $epassword = password_hash($password, PASSWORD_DEFAULT);

    //insert to database
    $insert = mysqli_query($koneksi, "INSERT INTO user (username, email, password) values ('$username', '$email', '$epassword')");

    if($insert)
    {
        //jika berhasil
        header('location:index.php');
    }
    else
    {
        //jika gagal
        echo '
        <script>
        alert("Registrasi Gagal");
        window.location.href="register.php";
        </script>
        ';
    }
}

//login
if(isset($_POST['login']))
{
    //jika login diklik

    $username = $_POST['username'];
    $password = $_POST['password']; // belum di enkripsi

    //insert to database
    $cekdb = mysqli_query($koneksi, "SELECT * FROM user where username='$username'");
    $hitung = mysqli_num_rows($cekdb);
    $pw = mysqli_fetch_array($cekdb);
    $passwordsekarang = $pw['password'];

    if($hitung>0)
    {
        //jika ada
        //verifikasi password
        if(password_verify($password, $passwordsekarang))
        {
            //jika password benar
            header('location:home.php');
        }
        else
        {
            //jika password salah
            echo'
            <script>
            alert("Password Salah!");
            window.location.href="register.php";
            </script>
            ';
        }
    }
    else
    {
        //jika gagal
        echo '
        <script>
        alert("Login Gagal");
        window.location.href="register.php";
        </script>
        ';
    }
}

?>