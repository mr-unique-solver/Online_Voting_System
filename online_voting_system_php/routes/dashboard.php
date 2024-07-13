<?php
session_start();
if (!isset($_SESSION['userdata'])) {
    header("location: ./index.html");
}
$userdata = $_SESSION['userdata'];
$groupsdata = $_SESSION['groupdata'];
$statusStyle = ($_SESSION['userdata']['status'] == 0) ? 'color:red' : 'color:green';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System - Dashboard</title>
    <!-- Bootstrap CSS (make sure to link this) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            transition: background-color 0.5s ease-in-out;
        }

        #mainsection {
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.5s ease-in-out;
        }

        #headersection {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        #backbtn {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            background-color: blueviolet;
            color: white;
            text-decoration: none;
            position: absolute;
            top: 10px;
            left: 10px;
            transition: background-color 0.5s ease-in-out;
        }

        #logoutbtn {
            float: right;
        }

        h1 {
            color: blueviolet;
            transition: color 0.5s ease-in-out;
        }

        #mainpanel {
            display: flex;
            transition: display 0.5s ease-in-out;
        }

        #Profile, #Group {
            background-color: white;
            padding: 20px;
            margin: 10px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.5s ease-in-out;
        }

        #Profile img {
            border-radius: 50%;
            margin-bottom: 20px;
            transition: margin-bottom 0.5s ease-in-out;
        }

        .group-item {
            margin-bottom: 20px;
            transition: margin-bottom 0.5s ease-in-out;
        }

        .group-item img {
            float: right;
            border-radius: 5px;
            transition: float 0.5s ease-in-out;
        }

        .vote-btn, .voted-btn {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            transition: background-color 0.5s ease-in-out;
        }

        .vote-btn {
            background-color: blueviolet;
        }

        .vote-btn:hover {
            background-color: darkviolet;
        }

        .voted-btn {
            background-color: green;
            cursor: not-allowed;
        }

        /* Arrange voters on the left, groups on the right */
        #mainpanel {
            display: flex;
            justify-content: space-between;
            transition: justify-content 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <div id="mainsection">
        <div id="headersection">
            <a href="./index.html" class="btn btn-primary" id="backbtn">Back</a>
            <a href="./logout.php" class="btn btn-danger" id="logoutbtn">Logout</a>
            <h1>Online Voting System</h1>
        </div>
        <hr>
        <div id="mainpanel">
            <div id="Profile">
                <center><img src="../uploads/<?php echo $userdata['photo'] ?>" height="100" width="100"></center><br><br>
                <b>Name:</b><?php echo $userdata['name'] ?><br><br>
                <b>Mobile:</b><?php echo $userdata['mobile'] ?><br><br>
                <b>Address:</b><?php echo $userdata['address'] ?><br><br>
                <b>Status: <span style="<?php echo $statusStyle; ?>"><?php echo ($userdata['status'] == 0) ? 'Not Voted' : 'Voted'; ?></span></b><br><br>
            </div>
            <div id="Group">
                <?php
                if ($groupsdata) {
                    foreach ($groupsdata as $group) {
                        ?>
                        <div class="group-item">
                            <img src="../uploads/<?php echo $group['photo'] ?>" height="100" width="300">
                            <b>Group Name:</b><?php echo $group['name'] ?><br><br>
                            <b>Votes:</b><?php echo $group['votes'] ?><br><br>
                            <form action="../api/vote.php" method="POST">
                                <input type="hidden" name="gvotes" value="<?php echo $group['votes'] ?>">
                                <input type="hidden" name="gid" value="<?php echo $group['id'] ?>">
                                <?php
                                $btnDisabled = ($_SESSION['userdata']['status'] == 0) ? '' : 'disabled';
                                $btnClass = ($_SESSION['userdata']['status'] == 0) ? 'btn btn-success vote-btn' : 'btn btn-success voted-btn';
                                ?>
                                <button type="submit" name="votebtn" class="<?php echo $btnClass; ?>" <?php echo $btnDisabled; ?>>Vote</button>
                            </form>
                        </div>
                        <hr>
                        <?php
                    }
                } else {
                    echo '<p>No groups available.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (make sure to link this) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
