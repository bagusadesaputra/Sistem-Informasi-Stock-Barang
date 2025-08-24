<?php
require 'config/koneksi.php';
require 'functions/function.php';


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM login WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        if ($password === $data['password']) { // Tanpa hash
            $_SESSION['log'] = true;
            $_SESSION['username'] = $data['username'];
            $_SESSION['role'] = $data['role'];

            if ($data['role'] == 'superadmin') {
                header('Location: index.php');
            } elseif ($data['role'] == 'admin_so') {
                header('Location: index.php');
            } elseif ($data['role'] == 'admin_gudang') {
                header('Location: keluar.php');
            } elseif ($data['role'] == 'sales') {
                header('Location: index.php');
            } else {
                header('Location: index.php'); // default
            }
            exit;
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username tidak ditemukan!'); window.location='login.php';</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="post" action="login.php" autocomplete="off">
                                            <!-- Username -->
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputUsername">Username</label>
                                                <input 
                                                    class="form-control py-4" 
                                                    name="username" 
                                                    id="inputUsername" 
                                                    type="text" 
                                                    placeholder="Enter username" 
                                                    required 
                                                    autofocus
                                                />
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Password</label>
                                                <input 
                                                    class="form-control py-4" 
                                                    name="password" 
                                                    id="inputPassword" 
                                                    type="password" 
                                                    placeholder="Enter password" 
                                                    required
                                                />
                                            </div>

                                            <!-- CSRF Token (optional) -->
                                            <input type="hidden" name="csrf_token" value="<?php echo md5(uniqid()); ?>">

                                            <!-- Submit -->
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" name="login" type="submit">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>