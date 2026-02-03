<?php
$conn = new mysqli("localhost", "root", "", "blog");

$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 5;
$start = ($page - 1) * $limit;

/* DATA FETCH */
$sql = "SELECT * FROM posts 
        WHERE title LIKE '%$search%' 
        OR content LIKE '%$search%' 
        LIMIT $start, $limit";
$result = $conn->query($sql);

/* TOTAL POSTS */
$total = $conn->query("SELECT COUNT(*) AS total FROM posts");
$totalPosts = $total->fetch_assoc()['total'];
$totalPages = ceil($totalPosts / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Task 3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-4">

<h3>My Posts</h3>

<!-- SEARCH -->
<form method="GET" class="mb-3">
    <input type="text" name="search" placeholder="Search post" value="<?= $search ?>">
    <button class="btn btn-primary btn-sm">Search</button>
</form>

<!-- POSTS -->
<?php while($row = $result->fetch_assoc()) { ?>
    <div class="card mb-2">
        <div class="card-body">
            <h5><?= $row['title'] ?></h5>
            <p><?= $row['content'] ?></p>
        </div>
    </div>
<?php } ?>

<!-- PAGINATION -->
<?php for($i=1; $i<=$totalPages; $i++) { ?>
    <a href="?page=<?= $i ?>" class="btn btn-sm btn-outline-dark"><?= $i ?></a>
<?php } ?>

</div>
</body>
</html>
