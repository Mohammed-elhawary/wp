<?php
session_start();
include ("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit;
}
$id = $_SESSION['id'];
$users = mysqli_query($con, "SELECT * FROM users");
$postcount = mysqli_query($con, "SELECT * FROM posts");
$commentcount = mysqli_query($con, "SELECT * FROM comments");

if ($users) {
    $numRows = mysqli_num_rows($users);
    $postRows = mysqli_num_rows($postcount);
    $commentRows = mysqli_num_rows($commentcount);

    $userimgs = [];
    $usernames = [];
    $userdecs = [];
    while ($row = mysqli_fetch_assoc($users)) {
        $username = $row['username'];
        $userimg = $row['profilepic'];
        $userdec = $row['description'];
        // Truncate username if it exceeds 8 characters
        $truncatedUsername = strlen($username) > 10 ? substr($username, 0, 10) . '...' : $username;
        $truncateduserdec = strlen($userdec) > 25 ? substr($userdec, 0, 25) . '...' : $userdec;
        $usernames[] = $truncatedUsername;
        $userimgs[] = $userimg;
        $userdecs[] = $truncateduserdec;
    }
}
$query = mysqli_query($con, "SELECT * FROM users WHERE id=$id");
$result = mysqli_fetch_assoc($query);
$res_Uname = $result['username'];
$res_des = $result['description'];
$res_city = $result['city'];
$res_email = $result['email'];
$res_age = $result['age'];
$res_imgcover = $result['coverpic'];
$userimg_query = "SELECT profilepic FROM users WHERE id = $id";
$userimg_result = mysqli_query($con, $userimg_query);
if ($userimg_result && mysqli_num_rows($userimg_result) > 0) {
    $userimg_row = mysqli_fetch_assoc($userimg_result);
    $userimg = $userimg_row['profilepic'];
}
if ($userimg == "") {
    $userimg = "./img/user.png";
}
$postimges = [];
$posts_query = mysqli_query($con, "SELECT * FROM posts WHERE img IS NOT NULL ORDER BY createdAt DESC");
while ($row = mysqli_fetch_assoc($posts_query)) {
    $postimges[] = $row['img'];
}
$posts_query = mysqli_query($con, "SELECT * FROM posts ORDER BY createdAt DESC");
$query = mysqli_query($con, "SELECT * FROM likes WHERE id = $id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/home.css">

</head>
<body>
    <div class="container">
        <div class="profile-page tx-13">
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="profile-header">
                        <div class="cover">
                            <div class="gray-shade"></div>
                            <figure>
                                <img src=<?php echo (!empty($res_imgcover) ? $res_imgcover : 'https://bootdey.com/img/Content/bg1.jpg'); ?> class="img-fluid"
                                    alt="profile cover">
                            </figure>
                            <div class="cover-body d-flex justify-content-between align-items-center">
                                <div>
                                    <img class="img-x rounded-circle" src=<?php echo $userimg ?> alt="profile">
                                    <b><?php echo $res_Uname; ?></b>
                                </div>
                                <div class="d-none d-md-block">
                                    <button class="btn btn-primary btn-icon-text btn-edit-profile">
                                        <a href="profile_edit.php?Id=<?php echo $id; ?>"
                                            class="btn btn-primary btn-icon-text btn-edit-profile">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-edit btn-icon-prepend">
                                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                </path>
                                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                </path>
                                            </svg> Edit profile
                                        </a>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="header-links">
                            <ul class="links d-flex align-items-center mt-3 mt-md-0">
                                <li class="header-link-item d-flex align-items-center active">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-columns mr-1 icon-md">
                                        <path
                                            d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7m0-18H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h7m0-18v18">
                                        </path>
                                    </svg>
                                    <a class="pt-1px d-none d-md-block" href="#">Timeline</a>
                                </li>

                                <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-users mr-1 icon-md">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="9" cy="7" r="4"></circle>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                    </svg>
                                    <a class="pt-1px d-none d-md-block" href="#">Users: <span
                                            class="text-muted tx-12"><?php echo $numRows ?></span></a>
                                </li>
                                <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-image mr-1 icon-md">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                    <a class="pt-1px d-none d-md-block" href="#">Total Posts: <span
                                            class="text-muted tx-12"><?php echo $postRows ?></span></a>
                                </li>
                                <li class="header-link-item ml-3 pl-3 border-left d-flex align-items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-chat" viewBox="0 -2 20 20">
                                        <path
                                            d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105" />
                                    </svg>
                                    <a class="pt-1px d-none d-md-block" href="#"> Total comments: <span
                                            class="text-muted tx-12"><?php echo $commentRows ?></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row profile-body">
                <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
                    <div class="card rounded">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="card-title mb-0">About</h6>
                            </div>
                            <p><?php echo $res_des ?></p>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Age:</label>
                                <p class="text-muted"><?php echo $res_age ?></p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Lives:</label>
                                <p class="text-muted"><?php echo $res_city ?></p>
                            </div>
                            <div class="mt-3">
                                <label class="tx-11 font-weight-bold mb-0 text-uppercase">Email:</label>
                                <p class="text-muted"><?php echo $res_email ?></p>
                            </div>
                            <div class="d-none d-md-block">
                                <a href="php/logout.php" class="btn btn-primary btn-icon-text btn-edit-profile">Logout
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                        class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                        <path fill-rule="evenodd"
                                            d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php if ($id == '1') { ?>
                        <div class="mt-4 px-3 text-center">
                            <div class="container px-4 py-3 shadow-lg bg-white rounded">
                                <input id="usernameInput" type="text" class="form-control mb-2"
                                    placeholder="Enter the username">
                                <button type="button" class="btn btn-danger" onclick="fdelete_user()">Delete user</button>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-md-8 col-xl-6 middle-wrapper">
                    <div id="post_poster" name="post_poster" class="card social-timeline-card grid grid-margin">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="posts-tab" data-toggle="tab" href="#posts" role="tab"
                                        aria-controls="posts" aria-selected="true">Share your insights</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="images-tab" data-toggle="tab" role="tab"
                                        aria-controls="images" aria-selected="false" href="#images">Share Images</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <form action="php/post_handler.php" method="POST" enctype="multipart/form-data"
                                class="post-form">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade active show" id="posts" role="tabpanel"
                                        aria-labelledby="posts-tab">
                                        <div class="form-group">
                                            <label class="sr-only" for="message">post</label>
                                            <textarea class="form-control" id="message" name="post_content" rows="3"
                                                placeholder="What are you thinking?"></textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile"
                                                    name="post_image">
                                                <label class="custom-file-label" for="customFile"
                                                    id="customFileLabel">Upload image</label>
                                            </div>
                                        </div>
                                        <div class="py-4"></div>
                                    </div>
                                </div>
                                <div class="btn-toolbar justify-content-between">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary">Share</button>
                                    </div>
                                    <div class="btn-group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-link dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-globe"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                            <a class="dropdown-item" href="#"><i class="fa fa-globe"></i> Public</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-users"></i> Friends</a>
                                            <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Just me</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $time;
                        while ($post = mysqli_fetch_assoc($posts_query)) {
                            $userid = $post['userid'];
                            $username_query = "SELECT username FROM users WHERE id = $userid";
                            $userpic_query = "SELECT profilepic FROM users WHERE id = $userid";
                            $username_result = mysqli_query($con, $username_query);
                            $userpic_result = mysqli_query($con, $userpic_query);
                            if ($userpic_result && mysqli_num_rows($userpic_result) > 0) {
                                $userimg_row = mysqli_fetch_assoc($userpic_result);
                                $userimg = $userimg_row['profilepic'];
                            }
                            if ($userimg == "") {
                                $userimg = "./img/user.png";
                            }
                            if ($username_result && mysqli_num_rows($username_result) > 0) {
                                $username_row = mysqli_fetch_assoc($username_result);
                                $username = $username_row['username'];
                                $time = $post['createdAt'];
                            } else {
                                $username = 'Unknown User';
                            }
                            $post_id = $post['id'];
                            $rating_query = mysqli_query($con, "SELECT * FROM likes WHERE userid = $id  AND postid = $post_id");
                            $comment_query = mysqli_query($con, "SELECT * FROM comments WHERE postid = $post_id");
                            $comment_count = mysqli_num_rows($comment_query);
                            $liked_query = mysqli_query($con, "SELECT * FROM likes WHERE postid = $post_id AND rating = 'like'");
                            $disliked_query = mysqli_query($con, "SELECT * FROM likes WHERE postid = $post_id AND rating = 'dislike'");
                            $liked_count = mysqli_num_rows($liked_query);
                            $disliked_count = mysqli_num_rows($disliked_query);
                            $is_rated = mysqli_num_rows($rating_query) > 0;
                            if($is_rated){
                                $row = mysqli_fetch_assoc($rating_query);
                                $rating = $row['rating'];
                            }
                            else{
                                $rating = 'empty';
                            }
                            ?>
                            <div class="col-md-12 grid-margin">
                                <div class="card rounded">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <img class="img-xs rounded-circle" src='<?php echo $userimg ?>' alt>
                                                <div class="ml-2 username">
                                                    <p><?php echo $username; ?></p>
                                                    <p class="tx-11 text-muted"><?php echo $time; ?></p>
                                                </div>
                                            </div>
                                            <?php if ($userid == $_SESSION['id'] || $_SESSION['id'] == "1"): ?>
                                                <div class="dropdown">
                                                    <button class="btn p-0" type="button" id="dropdownMenuButton2"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-more-horizontal icon-lg pb-3px">
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="19" cy="12" r="1"></circle>
                                                            <circle cx="5" cy="12" r="1"></circle>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            onclick="editpostWithUpdate(<?php echo $post_id; ?>)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-edit btn-icon-prepend">
                                                                <path
                                                                    d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                </path>
                                                                <path
                                                                    d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                                                                </path>
                                                            </svg> <span class>Edit</span>
                                                        </a>
                                                        <a class="dropdown-item d-flex align-items-center"
                                                            onclick="fdelete(<?php echo $post_id ?>)">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <path
                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                                <path
                                                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                            </svg> <span class>Delete</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-3 tx-14"><?php echo $post['description']; ?></p>
                                        <div class="overflow-hidden">
                                            <?php if (!empty($post['img'])) { ?>
                                                <img src="<?php echo $post['img']; ?>" alt="Post Image"
                                                    class="interactive-image img-fluid" style="max-width: 100%; height: auto;">
                                            <?php } ?>
                                            <div class="comments-container"></div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex post-actions">
                                            <a href="javascript:;"
                                                class="like-button d-flex text-muted mr-4 <?php echo $rating == 'like' ? 'active' :  ''; ?>"
                                                data-post-id="<?php echo $post['id']; ?>">
                                                <span class="material-icons" style="color: <?php echo $rating == 'like' ? 'blue' : 'gray'; ?>">
                                                    thumb_up
                                                </span>
                                                <p class="d-none d-md-block ml-2"> <?php echo "($liked_count)" ?> Like</p>
                                            </a>
                                            <a href="javascript:;"
                                                class="dislike-button d-flex text-muted mr-4 <?php echo $rating == 'dislike' ? 'active' : ''; ?>"
                                                data-post-id="<?php echo $post['id']; ?>">
                                                <span class="material-icons" style="color: <?php echo $rating == 'dislike' ? 'red' : 'gray'; ?>">
                                                    thumb_down
                                                </span>
                                                <p class="d-none d-md-block ml-2"> <?php echo "($disliked_count)" ?> Dislike
                                                </p>
                                            </a>

                                            <a href="javascript:;" class="d-flex text-muted mr-4 show-comments"
                                                data-post-id="<?php echo $post['id']; ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-message-square icon-md">
                                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z">
                                                    </path>
                                                </svg>
                                                <p class="d-none d-md-block ml-2"> <?php echo "($comment_count)"; ?> Comment
                                                </p>
                                            </a>
                                        </div>
                                        <form action="php/comment_handler.php" method="POST" enctype="multipart/form-data"
                                            class="post-form">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade active show" id="posts" role="tabpanel"
                                                    aria-labelledby="posts-tab">
                                                    <div class="form-group">
                                                        <input type="hidden" name="post_id"
                                                            value="<?php echo $post['id']; ?>">
                                                        <textarea class="form-control" id="post_content" name="post_content"
                                                            rows="3" placeholder="What are you thinking?"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="btn-toolbar justify-content-between">
                                                <div class="btn-group">
                                                    <button type="submit" class="btn btn-primary">Comment</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="d-none d-xl-block col-xl-3 right-wrapper">
                    <div class="row">
                        <div class="col-md-12 grid-margin">
                            <div class="card rounded">
                                <div class="card-body">
                                    <h6 class="card-title">latest photos</h6>
                                    <div class="latest-photos">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <figure>
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[0]) ? $postimges[0] : 'img/user.png'); ?>>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure>
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[1]) ? $postimges[1] : 'img/user.png'); ?>>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure>
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[2]) ? $postimges[2] : 'img/user.png'); ?>>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure>
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[3]) ? $postimges[3] : 'img/user.png'); ?>>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure>
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[4]) ? $postimges[4] : 'img/user.png'); ?> alt>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure>
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[5]) ? $postimges[5] : 'img/user.png'); ?> alt>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure class="mb-0">
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[6]) ? $postimges[6] : 'img/user.png'); ?> alt>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure class="mb-0">
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[7]) ? $postimges[7] : 'img/user.png'); ?> alt>
                                                </figure>
                                            </div>
                                            <div class="col-md-4">
                                                <figure class="mb-0">
                                                    <img class="img-fluid" src=<?php echo (!empty($postimges[8]) ? $postimges[8] : 'img/user.png'); ?> alt>
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 grid-margin">
                            <div class="card rounded">
                                <div class="card-body">
                                    <h6 class="card-title">suggestions for you</h6>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div class="d-flex align-items-center hover-pointer">
                                            <img class="img-xs rounded-circle" src=<?php echo (!empty($userimgs[0]) ? $userimgs[0] : 'img/user.png'); ?> alt>
                                            <div class="ml-2">
                                                <p style="margin-bottom: 0;">
                                                    <?php echo (!empty($usernames[0]) ? $usernames[0] : 'user'); ?>
                                                </p>
                                                <p class="tx-11 text-muted" style="margin-top: 0;">
                                                    <?php echo (!empty($userdecs[0]) ? $userdecs[0] : 'hi i am using ... '); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <button class="btn btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user-plus" data-toggle="tooltip" title
                                                data-original-title="Connect">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div class="d-flex align-items-center hover-pointer">
                                            <img class="img-xs rounded-circle" src=<?php echo (!empty($userimgs[1]) ? $userimgs[1] : 'img/user.png'); ?> alt>
                                            <div class="ml-2">
                                                <p style="margin-bottom: 0;">
                                                    <?php echo (!empty($usernames[1]) ? $usernames[1] : 'user'); ?>
                                                </p>
                                                <p class="tx-11 text-muted" style="margin-top: 0;">
                                                    <?php echo (!empty($userdecs[1]) ? $userdecs[1] : 'hi i am using ... '); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <button class="btn btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user-plus" data-toggle="tooltip" title
                                                data-original-title="Connect">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div class="d-flex align-items-center hover-pointer">
                                            <img class="img-xs rounded-circle" src=<?php echo (!empty($userimgs[2]) ? $userimgs[2] : 'img/user.png'); ?> alt>
                                            <div class="ml-2">
                                                <p style="margin-bottom: 0;">
                                                    <?php echo (!empty($usernames[2]) ? $usernames[2] : 'user'); ?>
                                                </p>
                                                <p class="tx-11 text-muted" style="margin-top: 0;">
                                                    <?php echo (!empty($userdecs[2]) ? $userdecs[2] : 'hi i am using ... '); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <button class="btn btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user-plus" data-toggle="tooltip" title
                                                data-original-title="Connect">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div class="d-flex align-items-center hover-pointer">
                                            <img class="img-xs rounded-circle" src=<?php echo (!empty($userimgs[3]) ? $userimgs[3] : 'img/user.png'); ?> alt>
                                            <div class="ml-2">
                                                <p style="margin-bottom: 0;">
                                                    <?php echo (!empty($usernames[3]) ? $usernames[3] : 'user'); ?>
                                                </p>
                                                <p class="tx-11 text-muted" style="margin-top: 0;">
                                                    <?php echo (!empty($userdecs[3]) ? $userdecs[3] : 'hi i am using ... '); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <button class="btn btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user-plus" data-toggle="tooltip" title
                                                data-original-title="Connect">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                                        <div class="d-flex align-items-center hover-pointer">
                                            <img class="img-xs rounded-circle" src=<?php echo (!empty($userimgs[4]) ? $userimgs[4] : 'img/user.png'); ?> alt>
                                            <div class="ml-2">
                                                <p style="margin-bottom: 0;">
                                                    <?php echo (!empty($usernames[4]) ? $usernames[4] : 'user'); ?>
                                                </p>
                                                <p class="tx-11 text-muted" style="margin-top: 0;">
                                                    <?php echo (!empty($userdecs[4]) ? $userdecs[4] : 'hi i am using ... '); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <button class="btn btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user-plus" data-toggle="tooltip" title
                                                data-original-title="Connect">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center hover-pointer">
                                            <img class="img-xs rounded-circle" src=<?php echo (!empty($userimgs[5]) ? $userimgs[5] : 'img/user.png'); ?> alt>
                                            <div class="ml-2">
                                                <p style="margin-bottom: 0;">
                                                    <?php echo (!empty($usernames[5]) ? $usernames[5] : 'user'); ?>
                                                </p>
                                                <p class="tx-11 text-muted" style="margin-top: 0;">
                                                    <?php echo (!empty($userdecs[5]) ? $userdecs[5] : 'hi i am using ... '); ?>
                                                </p>
                                            </div>
                                        </div>
                                        <button class="btn btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-user-plus" data-toggle="tooltip" title
                                                data-original-title="Connect">
                                                <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                                <circle cx="8.5" cy="7" r="4"></circle>
                                                <line x1="20" y1="8" x2="20" y2="14"></line>
                                                <line x1="23" y1="11" x2="17" y2="11"></line>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('customFile').addEventListener('change', function () {
            var fileName = this.files[0].name;
            var label = document.getElementById('customFileLabel');
            label.innerText = fileName;
        });
    </script>
    <script>
        function fdelete_user(post_id) {
            var username = document.getElementById('usernameInput').value;
            $.ajax({
                url: 'php/delete_user.php',
                type: 'POST',
                data: {
                    username: username,
                },
                success: function (response) {
                    console.log(response.message);
                    var jsonResponse = JSON.parse(response);
                    console.log(jsonResponse.message);
                    if (jsonResponse.message == "User deleted successfully.") {
                        alert('User deleted successfully.');
                        window.location.reload(true);
                    }
                    else if (jsonResponse.message == "Error deleting user.") { alert('Error deleting user.'); }
                    else if (jsonResponse.message == "Username not provided.") { alert('Username not provided.'); }
                }
            });
        }
    </script>
    <script>
        function fdelete(post_id) {
            $.ajax({
                url: 'php/delete_post.php',
                type: 'POST',
                data: {
                    postId: post_id,
                },
                success: function (response) {
                    if (response == "success!") { window.location.reload(true); }
                }
            });
        }
    </script>
    <script>
        var loggedInUserId = <?php echo $id; ?>;
        console.log(loggedInUserId);
        $(document).ready(function () {
            $('.show-comments').click(function (e) {
                e.preventDefault();
                var postId = $(this).data('post-id');
                $('#commentsModal').remove();
                $.ajax({
                    url: './php/fetch_comments.php',
                    type: 'POST',
                    data: {
                        postId: postId
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response && response.comments && response.comments.length > 0) {
                            var modalContent = '<div class="modal fade" id="commentsModal" tabindex="-1" aria-labelledby="commentsModalLabel" aria-hidden="true">';
                            modalContent += '<div class="modal-dialog modal-lg">';
                            modalContent += '<div class="modal-content">';
                            modalContent += '<div class="modal-header">';
                            modalContent += '<h5 class="modal-title" id="commentsModalLabel">Comments</h5>';
                            modalContent += '</div>';
                            modalContent += '<div class="modal-body">';
                            modalContent += '<div class="row">';
                            modalContent += '<div class="col-12">';
                            modalContent += '<ul class="list-group list-group-flush">';
                            response.comments.forEach(function (comment, index) {
                                if (response.commentownerid[index] !== undefined) {
                                    modalContent += '<li class="list-group-item">';
                                    if (loggedInUserId == response.commentownerid[index] || loggedInUserId == "1") {
                                        modalContent += '<div class="dropdown">';
                                        modalContent += '<button class="btn p-0" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal icon-lg pb-3px"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg></button>';
                                        modalContent += '<div class="dropdown-menu">';
                                        modalContent += '<a class="dropdown-item d-flex align-items-center" onclick="commentdelete(' + response.commentIds[index] + ')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path></svg> <span class="">Delete</span></a>';
                                        modalContent += '</div>';
                                        modalContent += '</div>';
                                    }
                                    modalContent += '<textarea class="form-control" rows="3" readonly>' + comment + '</textarea></li>';
                                }
                            });
                            modalContent += '</ul>';
                            modalContent += '</div>';
                            modalContent += '</div>';
                            modalContent += '</div>';
                            modalContent += '<div class="modal-footer"></div>';
                            modalContent += '</div>';
                            modalContent += '</div>';
                            modalContent += '</div>';
                            $('body').append(modalContent);
                            $('#commentsModal').modal('show');
                        } else {
                            alert('No comments available.');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                }
                );
            });
        });
    </script>
    <script>
        function commentdelete(commentid) {
            $.ajax(
                {
                    url: './php/delete_comment.php',
                    type: 'POST',
                    data: {
                        commentid: commentid
                    },
                    dataType: 'json',
                    success: function (response) {
                        if (response.message === "success!") {
                            window.location.reload(true);
                        } else {
                            console.error("Unexpected response:", response);
                            alert("An unexpected error occurred. Please try again.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText);
                        alert("An error occurred while deleting the comment. Please try again.");
                    }
                }
            );
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.like-button').on('click', function () {
                var postId = $(this).data('post-id');
                var isLiked = $(this).hasClass('active');

                console.log("postId:", postId);
                console.log("isLiked:", isLiked);

                if (!postId) {
                    console.error("postId is missing!");
                    return;
                }

                $.ajax({
                    url: 'php/like_handler.php',
                    type: 'POST',
                    data: {
                        postId: postId,
                        action: isLiked ? 'unlike' : 'like'
                    },
                    success: function (response) {
                        console.log("Response:", response);
                        if (response === 'liked') {
                            $('.like-button[data-post-id="' + postId + '"]').addClass('active');
                        } else if (response === 'unliked') {
                            $('.like-button[data-post-id="' + postId + '"]').removeClass('active');
                        }
                        window.location.reload(true);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.dislike-button').on('click', function () {
                var postId = $(this).data('post-id');
                var is_Disliked = $(this).hasClass('active');
                console.log("postId:", postId);
                console.log("isdisLiked:", is_Disliked);
                if (!postId) {
                    console.error("postId is missing!");
                    return;
                }
                $.ajax({
                    url: 'php/dislike_handler.php',
                    type: 'POST',
                    data: {
                        postId: postId,
                        action: is_Disliked ? 'undislike' : 'dislike'
                    },
                    success: function (response) {
                        console.log("Response:", response);
                        if (response === 'disliked') {
                            $('.dislike-button[data-post-id="' + postId + '"]').addClass('active');
                        } else if (response === 'undisliked') {
                            $('.dislike-button[data-post-id="' + postId + '"]').removeClass('active');
                        }
                        window.location.reload(true);
                    }
                });
            });
        });
    </script>
    <script>function updateSession(postId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './php/update_session.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log('Session updated');
                }
            };
            xhr.send('post_id=' + postId);
        }
    </script>
    <script>
        function editpostWithUpdate(postId) {
            var id = postId;
            $.ajax({
                url: 'php/update_session.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id
                },
                success: function (response) {
                    console.log('Response:', response);
                    if (response.error) {
                        console.error('There was a problem updating the post ID:', response.error);
                    } else {
                        console.log('Post ID updated successfully:', response.message);

                    }
                },
                error: function (xhr, status, error) {
                    console.error('Request failed with status:', status);
                    console.error('Error:', error);
                }
            });
            editpost();
        }
    </script>
    <script>
        function editpost() {
            var formContainer = document.createElement('div');
            formContainer.id = 'post_poster_clone';
            formContainer.name = 'post_poster_clone';
            formContainer.className = 'card social-timeline-card grid grid-margin';
            formContainer.style.position = 'fixed';
            formContainer.style.top = '50%';
            formContainer.style.left = '50%';
            formContainer.style.transform = 'translate(-50%, -50%)';
            formContainer.style.backgroundColor = '#fff';
            formContainer.style.padding = '20px';
            formContainer.style.borderRadius = '10px';
            formContainer.style.boxShadow = '0px 0px 10px rgba(0, 0, 0, 0.5)';
            formContainer.style.zIndex = '9999';
            formContainer.style.width = '50%';
            var cardHeader = document.createElement('div');
            cardHeader.className = 'card-header';
            var navTabs = document.createElement('ul');
            navTabs.className = 'nav nav-tabs card-header-tabs';
            navTabs.id = 'myTab_clone';
            navTabs.setAttribute('role', 'tablist');
            var insightsTab = document.createElement('li');
            insightsTab.className = 'nav-item';
            var insightsLink = document.createElement('a');
            insightsLink.className = 'nav-link active';
            insightsLink.id = 'posts-tab_clone';
            insightsLink.setAttribute('data-toggle', 'tab');
            insightsLink.setAttribute('href', '#posts_clone');
            insightsLink.setAttribute('role', 'tab');
            insightsLink.setAttribute('aria-controls', 'posts_clone');
            insightsLink.setAttribute('aria-selected', 'true');
            insightsLink.textContent = 'Share your insights';
            insightsTab.appendChild(insightsLink);
            var imagesTab = document.createElement('li');
            imagesTab.className = 'nav-item';
            var imagesLink = document.createElement('a');
            imagesLink.className = 'nav-link';
            imagesLink.id = 'images-tab_clone';
            imagesLink.setAttribute('data-toggle', 'tab');
            imagesLink.setAttribute('href', '#images_clone');
            imagesLink.setAttribute('role', 'tab');
            imagesLink.setAttribute('aria-controls', 'images_clone');
            imagesLink.setAttribute('aria-selected', 'false');
            imagesLink.textContent = 'Share Images';
            imagesTab.appendChild(imagesLink);
            navTabs.appendChild(insightsTab);
            navTabs.appendChild(imagesTab);
            cardHeader.appendChild(navTabs);
            var cardBody = document.createElement('div');
            cardBody.className = 'card-body';
            var form = document.createElement('form');
            form.action = 'php/edit_post.php';
            form.method = 'POST';
            form.enctype = 'multipart/form-data';
            form.className = 'post-form';
            var insightsTabContent = document.createElement('div');
            insightsTabContent.className = 'tab-content';
            insightsTabContent.id = 'myTabContent_clone';
            var insightsForm = document.createElement('div');
            insightsForm.className = 'tab-pane fade active show';
            insightsForm.id = 'posts_clone';
            insightsForm.setAttribute('role', 'tabpanel');
            insightsForm.setAttribute('aria-labelledby', 'posts-tab');
            var formGroup1 = document.createElement('div');
            formGroup1.className = 'form-group';
            var label1 = document.createElement('label');
            label1.className = 'sr-only';
            label1.setAttribute('for', 'message_clone');
            label1.textContent = 'post';
            var textarea1 = document.createElement('textarea');
            textarea1.className = 'form-control';
            textarea1.id = 'message_clone';
            textarea1.name = 'post_content_clone';
            textarea1.rows = '3';
            textarea1.placeholder = 'What are you thinking?';
            formGroup1.appendChild(label1);
            formGroup1.appendChild(textarea1);
            insightsForm.appendChild(formGroup1);
            insightsTabContent.appendChild(insightsForm);
            var imagesTabContent = document.createElement('div');
            imagesTabContent.className = 'tab-pane fade';
            imagesTabContent.id = 'images_clone';
            imagesTabContent.setAttribute('role', 'tabpanel');
            imagesTabContent.setAttribute('aria-labelledby', 'images-tab');
            var formGroup2 = document.createElement('div');
            formGroup2.className = 'form-group';
            var customFileDiv = document.createElement('div');
            customFileDiv.className = 'custom-file-edit';
            customFileDiv.style.display = 'flex';
            customFileDiv.style.alignItems = 'center';
            var inputFile = document.createElement('input');
            inputFile.type = 'file';
            inputFile.className = 'custom-file-input';
            inputFile.id = 'custom-file-edit';
            inputFile.name = 'post_image_clone';
            inputFile.style.width = '70%';
            var label2 = document.createElement('label');
            label2.className = 'custom-file-label-clone';
            label2.setAttribute('for', 'custom-file-edit-clone');
            label2.id = 'customFileLabel-edit';
            label2.textContent = 'Upload image';
            label2.style.width = '75%';
            customFileDiv.appendChild(inputFile);
            customFileDiv.appendChild(label2);
            formGroup2.appendChild(customFileDiv);
            imagesTabContent.appendChild(formGroup2);
            imagesTabContent.appendChild(document.createElement('div'));
            insightsTabContent.appendChild(imagesTabContent);
            var buttonToolbar = document.createElement('div');
            buttonToolbar.className = 'btn-toolbar justify-content-between';
            var btnGroup1 = document.createElement('div');
            btnGroup1.className = 'btn-group';
            var shareButton = document.createElement('button');
            shareButton.type = 'button';
            shareButton.id = 'shareButton';
            shareButton.name = 'shareButton';
            shareButton.className = 'btn btn-primary';
            shareButton.textContent = 'UPDATE';
            btnGroup1.appendChild(shareButton);
            var btnGroup2 = document.createElement('div');
            btnGroup2.className = 'btn-group';
            var dropdownButton = document.createElement('button');
            dropdownButton.type = 'button';
            dropdownButton.className = 'btn btn-link dropdown-toggle';
            dropdownButton.setAttribute('data-toggle', 'dropdown');
            dropdownButton.setAttribute('aria-haspopup', 'true');
            dropdownButton.setAttribute('aria-expanded', 'false');
            dropdownButton.id = 'btnGroupDrop1';
            dropdownButton.innerHTML = '<i class="fa fa-globe"></i>';
            var dropdownMenu = document.createElement('div');
            dropdownMenu.className = 'dropdown-menu';
            dropdownMenu.setAttribute('aria-labelledby', 'btnGroupDrop1');
            var publicOption = document.createElement('a');
            publicOption.className = 'dropdown-item';
            publicOption.href = '#';
            publicOption.innerHTML = '<i class="fa fa-globe"></i> Public';
            var friendsOption = document.createElement('a');
            friendsOption.className = 'dropdown-item';
            friendsOption.href = '#';
            friendsOption.innerHTML = '<i class="fa fa-users"></i> Friends';
            var justMeOption = document.createElement('a');
            justMeOption.className = 'dropdown-item';
            justMeOption.href = '#';
            justMeOption.innerHTML = '<i class="fa fa-user"></i> Just me';
            dropdownMenu.appendChild(publicOption);
            dropdownMenu.appendChild(friendsOption);
            dropdownMenu.appendChild(justMeOption);
            btnGroup2.appendChild(dropdownButton);
            btnGroup2.appendChild(dropdownMenu);
            buttonToolbar.appendChild(btnGroup1);
            buttonToolbar.appendChild(btnGroup2);
            form.appendChild(insightsTabContent);
            cardBody.appendChild(form);
            cardBody.appendChild(buttonToolbar);
            formContainer.appendChild(cardHeader);
            formContainer.appendChild(cardBody);
            document.body.appendChild(formContainer);
            var additionalScript = document.createElement('script');
            additionalScript.textContent = `
                document.getElementById('custom-file-edit').addEventListener('change', function () {
                    var fileName = this.files[0].name;
                    var label = document.getElementById('customFileLabel-edit');
                    label.innerText = fileName;
                });

                // Add click event listener to the Share button
                document.getElementById('shareButton').addEventListener('click', function () {
                    // Create an XHR object
                    var xhr = new XMLHttpRequest();

                    // Configure the request
                    xhr.open('POST', 'php/edit_post.php', true);

                    // Define the callback function when the request is complete
                    xhr.onload = function () {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            // Request was successful
                            console.log(xhr.responseText); // You can handle the response here
                        } else {
                            // Request failed
                            console.error('Request failed with status:', xhr.status);
                        }
                        window.location.reload(true);

                    };

                    // Prepare the data to be sent
                    var formData = new FormData();
                    var message = document.getElementById('message_clone').value;
                    var fileInput = document.getElementById('custom-file-edit');
                    var file = fileInput.files[0];

                    // Append data to FormData object
                    formData.append('post_content_clone', message);
                    formData.append('post_image_clone', file);
                    console.log(formData);

                    // Send the request with FormData
                    xhr.send(formData);
                });
            `;
            document.body.appendChild(additionalScript);
            var closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'btn btn-danger';
            closeButton.textContent = 'Close';
            closeButton.style.marginTop = '10px';
            closeButton.addEventListener('click', function () {
                document.body.removeChild(formContainer);
            });
            formContainer.appendChild(closeButton);
        }
    </script>
</body>

</html>