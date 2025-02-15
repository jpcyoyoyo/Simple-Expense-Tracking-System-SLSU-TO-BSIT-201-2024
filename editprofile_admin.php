<?php 
    include "backend/php/user_auth_admin.php";
    include "backend/php/set_theme.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Booststrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Balsamiq Sans:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" type="text/css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" type="text/css" rel="stylesheet">
    <title>Edit Profile</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/main_app.css">
    <link rel="stylesheet" href="css/main_app_content.css">  

</head>

<body>

    <div class="container-fluid" style="padding:0;">
        <div class="row" style="--bs-gutter-x: 0.75rem; margin: 0;">
            <!-- Include Sidebar from PHP -->
            <?php include "components/admin_sidebar.php"?>

            <!-- Deposit Content -->
            <div class="col-md-9 offset-md-3 col-12 main-app-content">
                <?php include "components/main_app_content_admin/editprofile_admin/editprofile_admin_component.php"?>
            </div>
        </div>
    </div>
    
    <script src="backend/javascript/editprofile.js"></script>
</body>
</html>