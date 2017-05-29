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
		<script type="text/javascript"  src="Content/js/main.js"></script>
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
            <?php 
                include 'api/employeeService.php';
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h1>TEAM MANAGEMENT</h1>
                    <br />
                </div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Add a new employee
                </button>
                
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Cell</th>
                                    <th>Job Title</th>
                                    <th>Qualification</th>
                                    <th>Skills</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $service = new employeeService();
                                    $employees = $service->getEmployees();
                                    foreach ($employees as $employee) {
                                        $employee = $employee;
                                        $id = $employee['_id']->__ToString();
                                        
                                ?>
                                <tr>
                                    <td><span><?php echo $employee['FullName']; ?></span></td>
                                    <td><span><?php echo $employee['Email']; ?></span></td>
                                    <td><span><?php echo $employee['Cell']; ?></span></td>
                                    <td><span><?php echo $employee['JobTitle']; ?></span></td>
                                    <td><span><?php echo $employee['Qualification']; ?></span></td>
                                    <td>
                                        <?php 
                                            foreach($employee['Skills'] as $skill) {
                                                ?>
                                                <span class="label label-info">
                                                    <?php echo $skill; ?>
                                                </span>
                                                <?php 
                                            }; 
                                        ?>
                                    </td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $id;?>">
                                            <i class="fa fa-pencil-square-o fa-2x" aria-hidden="true"></i>
                                        </a>
                                        <a href="delete.php?id=<?php echo $id;?>">
                                            <i class="fa fa-trash-o fa-2x" aria-hidden="true"></i>
                                        </a>
                                        
                                    </td>
                                </tr>
                                <?php 
                                    }
                                ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                    </div>
                <div class="modal-body">
                    <?php

                        if ($_SERVER['REQUEST_METHOD'] == "POST") {
                            $model = new employeeModel();
                            $service = new employeeService();

                            $fullName = ($_POST['fullName']);
                            $emal = ($_POST['email']);
                            $cell = ($_POST['cell']);
                            $jobTitle = ($_POST['jobTitle']);
                            $qualification = ($_POST['qualification']);
                            $Skills = ($_POST['skills']);

                            if ($fullName == "" || $emal == "" || $jobTitle == "" || $qualification == "" || $cell == "" ) {
                                echo "<span>Fields cannot be empty</span>";
                            } else {
                                $model->FullName = $fullName;
                                $model->Email = $emal;
                                $model->Cell = $cell;
                                $model->JobTitle = $jobTitle;
                                $model->Qualification = $qualification;
                                $model->Skills = $Skills;

                                $service->createEmployee($model);
                                header("Refresh:0");
                                ?>
                                <script type="text/javascript">
                                    document.location.href = "index.php"
                                </script>
                                <?php
                            }
                        }
                    ?>
                    <form class="form-horizontal" action="index.php" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="fullName" id="name" placeholder="Full name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cell" class="col-sm-2 control-label">Cell</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="cell" id="cell" placeholder="Contact number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jobTitle" class="col-sm-2 control-label">Job Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="jobTitle" id="jobTitle" placeholder="Job title" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="qualification" class="col-sm-2 control-label">Qualification</label>
                            <div class="col-sm-10">
                                <select name="qualification" class="form-control">
                                    <option value="None">None</option>
                                    <option value="Certificate">Certificate</option>
                                    <option value="Higher Certificate">Higher Certificate</option>
                                    <option value="Bachelor">Bachelor</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="skills" class="col-sm-2 control-label">Skills</label>
                            <div class="col-sm-10">
                                <select name="skills[]" class="form-control" multiple="true">
                                    <option value="Html">Html</option>
                                    <option value="CSS/CSS3">CSS/CSS3</option>
                                    <option value="C#">C#</option>
                                    <option value="Angular">Angular</option>
                                    <option value="JavaScript">JavaScript</option>
                                </select>
                            </div>
                        </div>
  
 
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </body>
</html>
