<?php
//memulai session atau melanjutkan session yang sudah ada
session_start();

//menyertakan code dari file koneksi
include "koneksi.php";

//check jika sudah ada user yang login arahkan ke halaman admin
if (isset($_SESSION['username'])) { 
	header("location:admin.php"); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    
  //menggunakan fungsi enkripsi md5 supaya sama dengan password  yang tersimpan di database
    $password = md5($_POST['pass']);

	//prepared statement
    $stmt = $conn->prepare("SELECT username 
                            FROM user 
                            WHERE username=? AND password=?");

	//parameter binding 
    $stmt->bind_param("ss", $username, $password);//username string dan password string
    
  //database executes the statement
    $stmt->execute();
    
  //menampung hasil eksekusi
    $hasil = $stmt->get_result();
    
     //mengambil baris dari hasil sebagai array asosiatif
    $row = $hasil->fetch_array(MYSQLI_ASSOC);

  //check apakah ada baris hasil data user yang cocok
    if (!empty($row)) {
    //jika ada, simpan variable username pada session
    $_SESSION['username'] = $row['username'];

    //mengalihkan ke halaman admin
    header("location:admin.php");
    } else {
	  //jika tidak ada (gagal), alihkan kembali ke halaman login
    header("location:login.php");
    }

	//menutup koneksi database
    $stmt->close();
    $conn->close();
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap");

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url('img/img.JPG') no-repeat center center;
            background-size: cover;
            font-family: "Poppins", sans-serif;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            color: #fff;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .card h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .form-control {
            background: transparent;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 30px;
            color: #fff;
        }

        .form-control::placeholder {
            color: #fff;
        }

        .btn {
            background: #fff;
            color: #333;
            border-radius: 30px;
            font-weight: bold;
            margin-top: 10px;
        }

        .btn:hover {
            background: #ddd;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin: 15px 0;
        }

        .remember-forgot a {
            color: #fff;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .register-link {
            text-align: center;
            margin-top: 15px;
        }

        .register-link a {
            color: #fff;
            font-weight: bold;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="card">
        <form method="POST" action="">
            <h1>Welcome to My git add .Daily Journal</h1>
            <div class="mb-3">
                <input type="text" class="form-control" name="user" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="pass" placeholder="Password" required>
            </div>
            <div class="remember-forgot">
                <label>
                    <input type="checkbox"> Remember me
                </label>
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
            $username = $_POST['user'];
            $password = $_POST['pass'];

            // Hardcoded credentials
            $valid_user = "admin";
            $valid_pass = "12345";

            if ($username === $valid_user && $password === $valid_pass) {
                echo "<p style='color:lime; text-align:center; margin-top:10px;'>Login Successful!</p>";
            } else {
                echo "<p style='color:red; text-align:center; margin-top:10px;'>Invalid Username or Password</p>";
            }
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
?>  