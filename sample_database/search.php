<?php
include('conn.php');

$output = "";
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";

$query = "SELECT * FROM `sample` WHERE `firstName` LIKE '%$search%' OR `lastName` LIKE '%$search%'";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $firstName = htmlspecialchars($row['firstName']);
    $lastName = htmlspecialchars($row['lastName']);
    $contactNumber = htmlspecialchars($row['contactNumber']);

    $output .= "<tr>
        <td>{$id}</td>
        <td>{$firstName}</td>
        <td>{$lastName}</td>
        <td>{$contactNumber}</td>
        <td>
            
            <a href='update.php?id={$id}' 
                class='btn btn-dark me-2' 
                title='Update' 
                data-bs-toggle='tooltip' 
                data-bs-placement='top'>
                <i class='bi bi-pencil fs-6'></i>
            </a>
            <a href='delete.php?id={$id}' 
                class='btn btn-danger me-2' 
                title='Delete' 
                data-bs-toggle='tooltip' 
                data-bs-placement='top'>
                <i class='bi bi-trash fs-6'></i>
            </a>
        </td>
    </tr>";
}

echo $output ?: "<tr><td colspan='5'>No results found</td></tr>";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<?php include('footer.php'); ?>
