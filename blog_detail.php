<?php

require_once "connection.php";

$id = $_GET["id"] ?? 0;

$stmt = $pdo->prepare(
    "SELECT * FROM players WHERE id = ?"
);

$stmt->execute([$id]);

$player = $stmt->fetch();

if (!$player) {

    die("بازیکن پیدا نشد.");

}

?>

<!DOCTYPE html>

<html lang="fa" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>
<?= htmlspecialchars($player["name"]) ?>
</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
rel="stylesheet">

</head>


<body class="bg-light">


<div class="container py-5">


<a
href="index.php"
class="btn btn-outline-secondary mb-4">

← برگشت

</a>


<div class="card shadow border-0">

<div class="card-body p-5">


<h1 class="fw-bold">

<?= htmlspecialchars($player["name"]) ?>

</h1>


<p class="text-secondary fs-5">

🌍
<?= htmlspecialchars($player["nationality"]) ?>

</p>


<hr>


<div class="row g-4">


<!-- NATIONALITY -->

<div class="col-md-6">

<div class="card bg-light border-0 h-100">

<div class="card-body">

<h5>🌍 ملیت</h5>

<p>

<?= htmlspecialchars(
$player["nationality"]
) ?>

</p>

</div>

</div>

</div>


<!-- TEAMS -->

<div class="col-md-6">

<div class="card bg-light border-0 h-100">

<div class="card-body">

<h5>🏟️ تیم‌ها</h5>

<p>

<?= nl2br(
htmlspecialchars(
$player["teams"]
)
) ?>

</p>

</div>

</div>

</div>


<!-- NUMBERS -->

<div class="col-md-6">

<div class="card bg-light border-0 h-100">

<div class="card-body">

<h5>👕 شماره پیراهن</h5>

<p>

<?= htmlspecialchars(
$player["numbers"]
) ?>

</p>

</div>

</div>

</div>


<!-- POSTS -->

<div class="col-md-6">

<div class="card bg-light border-0 h-100">

<div class="card-body">

<h5>📍 پست‌ها</h5>

<p>

<?= htmlspecialchars(
$player["posts"]
) ?>

</p>

</div>

</div>

</div>


<!-- GOALS -->

<div class="col-md-6">

<div class="card bg-primary text-white">

<div class="card-body">

<h5>⚽ گل زده</h5>

<div class="display-5 fw-bold">

<?= $player["goal"] ?>

</div>

</div>

</div>

</div>


<!-- ASSISTS -->

<div class="col-md-6">

<div class="card bg-success text-white">

<div class="card-body">

<h5>🎯 پاس گل</h5>

<div class="display-5 fw-bold">

<?= $player["assist"] ?>

</div>

</div>

</div>

</div>


<!-- TROPHIES -->

<div class="col-12">

<div class="card bg-warning-subtle border-0">

<div class="card-body">

<h5>🏆 جام‌ها</h5>

<p>

<?= nl2br(
htmlspecialchars(
$player["trophies"]
)
) ?>

</p>

</div>

</div>

</div>


</div>

</div>

</div>

</div>


</body>

</html>
