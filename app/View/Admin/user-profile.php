
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>User Profile | Registration and Login System</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
      <?php include_once('includes/navbar.php');?>
        <div id="layoutSidenav">
          <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        

                        <h1 class="mt-4"><?php echo $userData['fname'];?>'s Profile</h1>
                        <div class="card mb-4">
                     
                            <div class="card-body">
                                <a href="/admins-edit-profile?uid=<?php echo $userData['id'];?>">Edit</a>
                                <table class="table table-bordered">
                                   <tr>
                                    <th>First Name</th>
                                       <td><?php echo $userData['fname'];?></td>
                                   </tr>
                                   <tr>
                                       <th>Last Name</th>
                                       <td><?php echo $userData['lname'];?></td>
                                   </tr>
                                   <tr>
                                       <th>Email</th>
                                       <td colspan="3"><?php echo $userData['email'];?></td>
                                   </tr>
                                     <tr>
                                       <th>Contact No.</th>
                                       <td colspan="3"><?php echo $userData['contactno'];?></td>
                                   </tr>
                                     
                                        <tr>
                                       <th>Reg. Date</th>
                                       <td colspan="3"><?php echo $userData['posting_date'];?></td>
                                   </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </main>
          <?php include('includes/footer.php');?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>
