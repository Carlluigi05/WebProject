<?php include('conn.php'); ?>
<?php include('header.php'); ?>

<div class="container">
    <h2 class="student">DASHBOARD</h2>

    <a href="logout.php" class="btn btn-outline-danger float-end mb-3" style="margin-left: 10px;">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
    <button class="btn btn-warning float-end mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
        <i class="bi bi-person-plus"></i> ADD STUDENT
    </button>

    <div class="input-group mb-3">
        <input type="text" name="search" id="liveSearch" class="w-25 p-2 me-2 border-0"
               style="border-radius: 7px;" placeholder="Search by first or last name">
    </div>


    <?php if(isset($_GET['message'])): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <?php echo $_GET['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['insert_msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo $_GET['insert_msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['update_msg'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $_GET['update_msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if(isset($_GET['delete_msg'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo $_GET['delete_msg']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

   
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Contact Number</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="searchResults">
            <?php
            $query = "SELECT * FROM `sample`";
            $result = mysqli_query($conn, $query);
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['firstName']; ?></td>
                    <td><?php echo $row['lastName']; ?></td>
                    <td><?php echo $row['contactNumber']; ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-dark me-2" title="Update"
                           data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay='{"show":0,"hide":0}'>
                            <i class="bi bi-pencil fs-6"></i>
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger me-2" title="Delete"
                           data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay='{"show":0,"hide":0}'>
                            <i class="bi bi-trash fs-6"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    
    <form action="insert.php" method="post">   
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ADD STUDENTS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" name="fname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="cnumber">Contact Number</label>
                        <input type="text" name="cnumber" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" name="add_students" value="ADD" title="Save"
                            data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay='{"show":0,"hide":0}'>
                        <i class="bi bi-save"></i>
                    </button>
                </div>
            </div>
            </div>
        </div>
    </form>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchBox = document.getElementById("liveSearch");
    const results = document.getElementById("searchResults");

    searchBox.addEventListener("keyup", function () {
        const query = this.value;

        fetch("search.php?search=" + encodeURIComponent(query))
            .then(response => response.text())
            .then(data => {
                results.innerHTML = data;
            });
    });

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<?php include('footer.php'); ?>
