<?php
include('conn.php');
include('header.php');


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);


    $stmt = $conn->prepare("SELECT * FROM sample WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result || $result->num_rows === 0) {
        die("No student found.");
    }

    $row = $result->fetch_assoc();
    $stmt->close();
} else {
    die("Invalid request.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_students'])) {
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $cnumber = trim($_POST['cnumber']);


    if (empty($fname) || empty($lname) || empty($cnumber)) {
        die("All fields are required.");
    }

    
    $stmt = $conn->prepare("UPDATE sample SET firstName = ?, lastName = ?, contactNumber = ? WHERE id = ?");
    $stmt->bind_param("sssi", $fname, $lname, $cnumber, $id);

    if ($stmt->execute()) {
        header('Location: index.php?update_msg=Your data updated successfully');
        exit();
    } else {
        die("Update failed: " . $stmt->error);
    }

    $stmt->close();
}
?>


<div class="container mt-4">
    <h2>UPDATE STUDENT</h2>
    <form method="post">
        <div class="form-group mb-2">
            <label for="fname">First Name</label>
            <input type="text" name="fname" class="form-control" value="<?php echo htmlspecialchars($row['firstName']); ?>" required>
        </div>
        <div class="form-group mb-2">
            <label for="lname">Last Name</label>
            <input type="text" name="lname" class="form-control" value="<?php echo htmlspecialchars($row['lastName']); ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="cnumber">Contact Number</label>
            <input type="text" name="cnumber" class="form-control" value="<?php echo htmlspecialchars($row['contactNumber']); ?>" required>
        </div>
        <button type="submit" class="btn btn-outline-success" name="update_students" style="margin-left: 5px;" title="Update" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay='{"show":0, "hide":0}'><i class="bi bi-arrow-repeat"></i></button>

        <a href="index.php" class="btn btn-outline-danger"  title="Close" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-delay='{"show":0, "hide":0}'><i class="bi bi-x-circle"></i></a>

    </form>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Enable all tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include('footer.php'); ?>
