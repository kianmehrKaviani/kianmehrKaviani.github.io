<?php

require_once "connection.php";

$search = trim($_GET["search"] ?? "");

$stmt = $pdo->query("SELECT * FROM players");
$allPlayers = $stmt->fetchAll();

$players = [];

if ($search !== "") {

    $searchClean = mb_strtolower($search, "UTF-8");

    foreach ($allPlayers as &$player) {

        $nameClean = mb_strtolower($player["name"], "UTF-8");

        similar_text(
            $searchClean,
            $nameClean,
            $percent
        );

        $distance = levenshtein(
            $searchClean,
            $nameClean
        );

        $starts = str_starts_with(
            $nameClean,
            $searchClean
        );

        $contains = mb_stripos(
            $nameClean,
            $searchClean
        ) !== false;

        $player["score"] =
            ($starts ? 10000 : 0) +
            ($contains ? 5000 : 0) +
            ($percent * 100) -
            ($distance * 10);
    }

    unset($player);

    usort($allPlayers, function ($a, $b) {
        return $b["score"] <=> $a["score"];
    });

    $players = array_slice($allPlayers, 0, 10);

} else {

    usort($allPlayers, function ($a, $b) {
        return strcmp($a["name"], $b["name"]);
    });

    $players = $allPlayers;
}

?>

<!DOCTYPE html>

<html lang="fa" dir="rtl">

<head>

<meta charset="UTF-8">

<meta name="viewport"
      content="width=device-width, initial-scale=1">

<title>بازیکنان برتر تاریخ</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css"
rel="stylesheet">

<style>

body {
    background: #f5f7fb;
}

.search-box {
    max-width: 650px;
    margin: auto;
}

.player-card {
    text-decoration: none;
    color: inherit;
    transition: 0.2s;
}

.player-card:hover {
    transform: translateY(-5px);
}

</style>

</head>

<body>

<div class="container py-5">

    <h1 class="text-center fw-bold mb-4">
        ⚽ ۱۰۰ بازیکن برتر تاریخ
    </h1>


    <!-- SEARCH -->

    <form method="GET"
          class="search-box mb-5">

        <div class="input-group input-group-lg">

            <input
                type="search"
                name="search"
                value="<?= htmlspecialchars($search) ?>"
                class="form-control"
                placeholder="نام بازیکن را جستجو کنید...">

            <button
                class="btn btn-primary">

                🔍 جستجو

            </button>

        </div>

    </form>


    <?php if ($search !== ""): ?>

        <h5 class="mb-4">

            نتایج نزدیک به:

            <b>
                <?= htmlspecialchars($search) ?>
            </b>

        </h5>

    <?php endif; ?>


    <div class="row g-4">

        <?php foreach ($players as $player): ?>

            <div class="col-md-6 col-lg-4">

                <a
                    href="blog_detail.php?id=<?= $player["id"] ?>"
                    class="card player-card shadow-sm h-100">

                    <div class="card-body">

                        <div class="d-flex
                                    justify-content-between">

                            <h4 class="fw-bold">

                                <?= htmlspecialchars(
                                    $player["name"]
                                ) ?>

                            </h4>

                            <span class="badge bg-primary">

                                #<?= $player["id"] ?>

                            </span>

                        </div>


                        <p class="text-secondary">

                            🌍
                            <?= htmlspecialchars(
                                $player["nationality"]
                            ) ?>

                        </p>


                        <hr>


                        <div class="row">

                            <div class="col-6">

                                ⚽ گل

                                <strong>
                                    <?= $player["goal"] ?>
                                </strong>

                            </div>


                            <div class="col-6">

                                🎯 پاس گل

                                <strong>
                                    <?= $player["assist"] ?>
                                </strong>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

        <?php endforeach; ?>

    </div>


    <?php if (empty($players)): ?>

        <div class="alert alert-warning text-center mt-4">

            بازیکنی پیدا نشد.

        </div>

    <?php endif; ?>

</div>

</body>

</html>
