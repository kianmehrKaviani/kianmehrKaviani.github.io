const searchInput = document.getElementById("searchInput");
const searchButton = document.getElementById("searchButton");
const playersContainer = document.getElementById("playersContainer");
const resultInfo = document.getElementById("resultInfo");
const searchResults = document.getElementById("searchResults");


function normalize(text) {
    return text
        .toString()
        .toLowerCase()
        .trim();
}


// محاسبه نزدیک بودن اسم
function getScore(search, name) {

    search = normalize(search);
    name = normalize(name);

    if (!search) return 0;

    // اسم کاملاً برابر
    if (name === search) {
        return 1000;
    }

    // اسم با عبارت جستجو شروع شود
    if (name.startsWith(search)) {
        return 900;
    }

    // عبارت داخل اسم باشد
    if (name.includes(search)) {
        return 800;
    }

    // مقایسه حروف
    let score = 0;

    for (
        let i = 0;
        i < Math.min(search.length, name.length);
        i++
    ) {

        if (search[i] === name[i]) {
            score += 10;
        } else {
            break;
        }
    }

    return score;
}


// نمایش کارت بازیکنان
function showPlayers(list) {

    playersContainer.innerHTML = "";

    resultInfo.textContent =
        `${list.length} players found`;


    if (list.length === 0) {

        playersContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    ❌ Player not found
                </div>
            </div>
        `;

        return;
    }


    list.forEach(player => {

        const card = document.createElement("div");

        card.className = "col-md-6 col-lg-4";


        card.innerHTML = `

            <div class="card player-card h-100 shadow-sm">

                <div class="card-body">

                    <div class="d-flex
                        justify-content-between
                        align-items-start">

                        <h4 class="fw-bold">
                            ${player.name}
                        </h4>

                        <span class="badge bg-primary">
                            #${player.id}
                        </span>

                    </div>

                    <p class="text-secondary">
                        🌍 ${player.nationality}
                    </p>

                    <hr>

                    <div class="row text-center">

                        <div class="col-6">

                            <div class="stat">

                                ⚽

                                <strong>
                                    ${player.goal}
                                </strong>

                                <small>
                                    Goals
                                </small>

                            </div>

                        </div>


                        <div class="col-6">

                            <div class="stat">

                                🎯

                                <strong>
                                    ${player.assist}
                                </strong>

                                <small>
                                    Assists
                                </small>

                            </div>

                        </div>

                    </div>


                    <a
                        href="blog_detail.html?id=${player.id}"
                        class="btn btn-primary w-100 mt-4">

                        View Details

                    </a>

                </div>

            </div>
        `;


        playersContainer.appendChild(card);

    });

}


// جستجو
function searchPlayers() {

    const search =
        normalize(searchInput.value);


    // اگر خالی بود همه بازیکنان
    if (search === "") {

        searchResults.innerHTML = "";

        showPlayers(players);

        return;
    }


    const results = players
        .map(player => {

            return {
                player: player,

                score: getScore(search,
                    player.name
                )
            };

        })

        .filter(item => item.score > 0)

        .sort((a, b) =>
            b.score - a.score
        )

        .map(item => item.player);


    showPlayers(results);

    showSearchResults(results);
}


// نتایج کوچک زیر کادر سرچ
function showSearchResults(results) {

    searchResults.innerHTML = "";


    if (results.length === 0) {

        searchResults.innerHTML = `
            <div class="search-item">
                ❌ No player found
            </div>
        `;

        return;
    }


    // فقط 5 نتیجه اول
    results
        .slice(0, 5)
        .forEach(player => {

            const item =
                document.createElement("a");


            item.href =
                `blog_detail.html?id=${player.id}`;


            item.className =
                "search-item";


            item.innerHTML = `

                <div>

                    <strong>
                        ${player.name}
                    </strong>

                    <small>
                        ${player.nationality}
                    </small>

                </div>

                <span>
                    →
                </span>
            `;


            searchResults.appendChild(item);

        });

}


// تایپ کردن
searchInput.addEventListener(
    "input",
    searchPlayers
);


// دکمه Search
searchButton.addEventListener(
    "click",
    searchPlayers
);


// Enter
searchInput.addEventListener(
    "keydown",
    function(event) {

        if (event.key === "Enter") {

            searchPlayers();

        }

    }
);


// کلیک بیرون از سرچ
document.addEventListener(
    "click",
    function(event) {

        if (
            !event.target.closest(
                ".search-container"
            )
        ) {

            searchResults.innerHTML = "";

        }

    }
);


// شروع سایت
showPlayers(players);
