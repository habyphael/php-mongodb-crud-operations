<?php 
    include 'api/employeeService.php';
?>
<?php
    if (!isset($_GET['id']) || $_GET['id'] == NULL) {
        header("location: index.php");
        } else {
        $id = $_GET['id'];
    }
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Team Managemnt | MongoDB and PHP.</title>
		<meta name="author" content="Haby-Phael Mouko">
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="lic-network, Haby-Phael, MongoDB, PHP, Web, Web Development">
		<meta name="description" content="This is a tutorial to help beginners starting with MongoDB and PHP.">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="Content/styles/style.css">
		
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">
		<link rel='stylesheet' id='cs-google-fonts-css'  href='//fonts.googleapis.com/css?family=Lato%3A400%7COpen+Sans%3A700%2C800&#038;subset=latin' type='text/css' media='all' />

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" aria-expanded="false">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">TM APP</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="#">Team <span class="sr-only">(current)</span></a></li>
                        <li><a href="#">Schedule</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="spacer"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>TEAM MANAGEMENT</h1>
                    <br />
                </div>
                
                <button type="button" onclick="goBack()" class="btn btn-primary btn-lg">
                    Back
                </button>
                <div class="col-md-12">
                    <?php

                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            $service = new employeeService();
                            if ($id == "") {
                                echo "<span>The id cannot be null.</span>";
                            } elseif(strlen($id) != 24) {
                                echo "<span>The id is invalid.</span>";
                            }
                             else {

                                $result = $service->deleteEmployee($id);
                                if ($result == "success"){
                                    header("location: index.php");
                                } else {
                                    echo "<h3 class='text-warning'>$result</h3>";
                                }
                                
                            }
                        }
                    ?>
                    <?php
                        $service = new employeeService();
                        $employee = $service->getEmployee($id);
                        
                        if (is_object($employee) || $employee != null) {
                    ?>
                    <br />
                    <div class="alert alert-danger" role="alert"><h3>Are you sure you want to delete this employee?</h3></div>
                    <div class="bg-danger">
                        <h3></h3>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                             <tr>
                                <td><?php echo $employee->FullName; ?></td>
                             </tr>
                             <tr>
                                <td><?php echo $employee->Email; ?></td>
                             </tr>
                             <tr>
                                <td><?php echo $employee->Cell; ?></td>
                             </tr>
                             <tr>
                                <td><?php echo $employee->JobTitle; ?></td>
                             </tr>
                             <tr>
                                <td><?php echo $employee->Qualification; ?></td>
                             </tr>
                             <tr>
                                <td>
                                    <?php 
                                        foreach($employee->Skills as $skill) {
                                    ?>
                                        <span class="label label-info">
                                        <?php echo $skill; ?>
                                        </span>
                                    <?php 
                                        }; 
                                    ?>
                                </td>
                             </tr>
                        </table>
                    </div>
                    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <button type="button" class="btn btn-default btn-block" onclick="goBack()">No</button>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary btn-block">Yes</button>
                            </div>
                        </div>
                    </form>
                     <?php
                    } //if
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript"  src="Content/js/main.js"></script>
    </body>
</html>
