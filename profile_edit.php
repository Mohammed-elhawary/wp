<?php
session_start();

include ("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION['id'];
$query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");
$result = mysqli_fetch_assoc($query);
$res_Uname = $result['username'];
$res_des = $result['description'];
$res_city = $result['city'];
$res_email = $result['email'];
$res_age = $result['age'];
$res_password = $result['password'];
$res_img = $result['profilepic'];
$res_imgcover = $result['coverpic'];

$userimg_query = "SELECT profilepic FROM users WHERE id = $id";
$userimg_result = mysqli_query($con, $userimg_query);
if ($userimg_result && mysqli_num_rows($userimg_result) > 0) {
    $userimg_row = mysqli_fetch_assoc($userimg_result);
    $userimg = $userimg_row['profilepic'];
} else {
    $userimg = "./img/user.png";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        @media (min-width: 768px) {
            .card {
                display: flex;
                flex-direction: row-reverse;
            }
        }
    </style>
</head>
<body>
    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black" style="border-radius: 25px;">
                        <div class="card-body">
                            <div class="container rounded bg-white mt-5 mb-5">
                                <div class="row">
                                    <div class="col-md-3 border-right">
                                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                            <img id="profile-image" class="rounded-circle mt-5" width="150px"
                                                height="150px"
                                                src="<?php echo (!empty($res_img) ? $res_img : 'img/user.png'); ?>">
                                            <input type="file" id="image-upload" style="display: none; "
                                                onchange="previewImage(this);">
                                            <label for="image-upload" class="btn btn-primary mt-3">Change Image</label>
                                        </div>
                                        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                            <img id="profile-background" class="mt-5" width="200px" height="120px"
                                                src="<?php echo (!empty($res_imgcover) ? $res_imgcover : 'https://bootdey.com/img/Content/bg1.jpg'); ?>">
                                            <input type="file" id="image-upload-background" style="display: none; "
                                                onchange="previewbackground(this);">
                                            <label for="image-upload-background" class="btn btn-primary mt-4">Change
                                                background</label>
                                        </div>
                                    </div>
                                    <div class="col-md-5 border-right">
                                        <div class="p-3 py-5">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h4 class="text-right">Profile Settings</h4>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-md-12"><label class="labels">Name</label><input
                                                        id="name" name="name" type="text" class="form-control"
                                                        placeholder="enter Name" value="<?php echo $res_Uname ?>"></div>
                                                <div class="col-md-12"><label class="labels">email</label><input
                                                        id="email" name="email" type="email" class="form-control"
                                                        placeholder="enter email" value="<?php echo $res_email ?>">
                                                </div>
                                                <div class="col-md-12"><label class="labels">password</label><input
                                                        id="password" name="passowrd" type="password"
                                                        class="form-control" placeholder="enter password"
                                                        value="<?php echo $res_password ?>"></div>
                                                <div class="col-md-12"><label class="labels">re-password</label><input
                                                        id="re-password" name="re-passowrd" type="password"
                                                        class="form-control" placeholder="enter re-password"
                                                        value="<?php echo $res_password ?>"></div>
                                                <div class="col-md-12"><label class="labels">city</label><input
                                                        id="city" name="city" type="text" class="form-control"
                                                        placeholder="enter city" value="<?php echo $res_city ?>"></div>
                                                <div class="col-md-12"><label class="labels">age</label><input id="age"
                                                        name="age" type="number" class="form-control"
                                                        placeholder="enter your age" value="<?php echo $res_age ?>">
                                                </div>

                                            </div>
                                            <div class="mt-5 text-center"><button class="btn btn-primary profile-button"
                                                    type="button" onclick="edit_profile()">Save Profile</button></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-3 py-5">
                                            <div class="form-group">
                                                <label for="">Description</label>
                                                <input type="hidden" name="post_id"
                                                    value="<?php echo "sadadsasdas"; ?>">
                                                <textarea class="form-control" id="post_content" name="post_content"
                                                    rows="3"
                                                    placeholder="What are you thinking?"><?php echo $res_des ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function edit_profile() {
            var post_content = document.getElementById("post_content").value;
            var age = document.getElementById("age").value;
            var city = document.getElementById("city").value;
            var password = document.getElementById("password").value;
            var repassword = document.getElementById("re-password").value;
            var email = document.getElementById("email").value;
            var name = document.getElementById("name").value;
            var imgSrc = document.getElementById("profile-image").src;
            var imgback = document.getElementById("profile-background").src;
            console.log(imgSrc)

            $.ajax({
                url: 'php/edit_profile.php',
                type: 'POST',
                data: {
                    post_content: post_content,
                    age: age,
                    city: city,
                    password: password,
                    repassword: repassword,
                    email: email,
                    name: name,
                    img: imgSrc,
                    imgback: imgback
                },
                success: function (response) {
                    console.log(response);
                    if (response == "Passwrods not matching!") {
                        alert(htmlspecialchars("Passwrods not matching!", ENT_QUOTES));
                        window.location.href = 'profile_edit.php';
                    }
                    else if (response == "Passwrod needs to be at least 8 characters!") {
                        alert(htmlspecialchars("Passwrod needs to be at least 8 characters!", ENT_QUOTES));
                        window.location.href = 'profile_edit.php';
                    }
                    else if (response == "success!") {
                        window.location.href = 'home.php';
                    }
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    window.location.reload(true);
                }
            });
        }
    </script>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-image').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

    </script>
    <script>
        function previewbackground(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-background').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>