<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Dashboard</title>

    <style>
        /* Custom CSS to position the sidebar */
        body{
            background-image: url("assets/bg1.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
        }

        .line { 
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-width: 2px;
            border-color: #43B6D6FF; 
            border-style: solid;
        } 

        .profile {
            position: relative;
            width: 120px; 
            height: 120px; 
            fill: #636AE8FF; /* primary-500 */
        }

        .nav-elements {
            display: flex;
            align-items: center;
            justify-content: center;
            
        }
        
        .sidebar {
            height: 100vh; /* Full viewport height */
            position: fixed; /* Stay fixed on the screen */
            top: 0;
            left: 0;
            width: 300px; /* Set sidebar width */
            background-color: #DEE1E699; /* Light background */
            padding-top: 20px; /* Space from top */
            padding: 10px;
        }

        .sidebar .nav-link {
            color: #000; /* Dark link color */
            font-weight: bold;
            font-size: large;
            padding-left: 20px;
            padding-right: 20px;
            border-radius: 12px;
            margin-top: 2px;
            margin-bottom: 2px;
            margin-left: 12px;
            margin-right: 12px;
        }
        
        .sidebar .nav-link:hover {
            background-color: #ddd; /* Hover effect */
            border-radius: 12px;
        }

        .sidebar .nav-link:active {
            background-color: #ddd; /* Hover effect */
            border-radius: 12px;
        }

        .btn {
            color: #fff; /* Dark link color */
            background: #43B6D6FF; 
            border-radius: 12px; 
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .btn:hover {
            color: #fff; /* Dark link color */
            background-color: #ddd; /* Hover effect */
            border-radius: 12px;
        }

        .space {
            height: 70px;
            width: auto;
        }

    </style>
</head>

<body>
    <div>
        <nav class="sidebar">
            <div class="container-fluid"></div>
                <ul class="navbar-nav flex-column">

                    <div class="nav-elements container flex-column">
                        <img class="profile" src="assets/reserve_profile.svg">
                        <div class="line container"></div>
                        <p class="h5" style="margin: auto; color:black">Compuer Society Org.</p>
                        <p class="display-h6" style="font-size: 15px; margin:auto; color:black;">comsocsocitey@gmail.com</p>
                        <button type="button" class="btn container-fluid">Edit Profile</button>
                    </div>

                    <div class="space"></div>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link 1</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link 1</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link 1</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Link 1</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Link 1</a>
                    </li>

                    <div class="line container"></div>

                    <li class="nav-item">
                        <a class="nav-link" href="#">Link 1</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</body>
</html>