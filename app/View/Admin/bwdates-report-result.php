<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>B/w Dates Report Result | Registration and Login System</title>
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
                        <h1 class="mt-4">B/w Dates Report Result</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item active">B/w Dates Report Result</li>
                        </ol>
            
                        <div class="card mb-4">
                            <div class="card-header" align="center" style="font-size:20px;">
                                <i class="fas fa-table me-1"></i>

B/w Dates Report Result from <?php echo date("d-m-Y", strtotime($fdate));?> to <?php echo date("d-m-Y", strtotime($tdate));?>
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                             <th>Sno.</th>
                                  <th>First Name</th>
                                  <th> Last Name</th>
                                  <th> Email Id</th>
                                  <th>Contact no.</th>
                                  <th>Reg. Date</th>
                                  <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                             <th>Sno.</th>
                                  <th>First Name</th>
                                  <th> Last Name</th>
                                  <th> Email Id</th>
                                  <th>Contact no.</th>
                                  <th>Reg. Date</th>
                                  <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php 
                                        $cnt = 1;
                                        foreach ($reportData as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo $row['fname'];?></td>
                                            <td><?php echo $row['lname'];?></td>
                                            <td><?php echo $row['email'];?></td>
                                            <td><?php echo $row['contactno'];?></td>
                                            <td><?php echo $row['posting_date'];?></td>
                                            <td>
                                                <a href="/user-profile?uid=<?php echo $row['id'];?>"> 
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="/delete-user?uid=<?php echo $user['id']; ?>" onClick="return confirm('Do you really want to delete');">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
                                        $cnt = $cnt+1; 
                                        } 
                                        ?>
                                      
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
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="../js/datatables-simple-demo.js"></script>
    </body>
</html>