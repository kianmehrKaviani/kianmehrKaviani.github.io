const params = new URLSearchParams(window.location.search);

const playerId = Number(params.get("id"));

const player = players.find(p => Number(p.id) === playerId);

const container = document.getElementById("playerDetail");

if (!player) {

    container.innerHTML = `
        <div class="alert alert-danger">
            Player not found!
        </div>
    `;

} else {

    container.innerHTML = `

        <div class="card shadow">

            <div class="card-body">

                <h1 class="fw-bold mb-4">
                    ${player.name}
                </h1>

                <div class="row g-3">

                    <div class="col-md-6">
                        <strong>ID:</strong>
                        ${player.id}
                    </div>

                    <div class="col-md-6">
                        <strong>Nationality:</strong>
                        ${player.nationality}
                    </div>

                    <div class="col-md-6">
                        <strong>Teams:</strong>
                        ${player.teams}
                    </div>

                    <div class="col-md-6">
                        <strong>Numbers:</strong>
                        ${player.numbers}
                    </div>

                    <div class="col-md-6">
                        <strong>Positions:</strong>
                        ${player.posts}
                    </div>

                    <div class="col-md-6">
                        <strong>Goals:</strong>
                        ${player.goal}
                    </div>

                    <div class="col-md-6">
                        <strong>Assists:</strong>
                        ${player.assist}
                    </div>

                    <div class="col-md-6">
                        <strong>Trophies:</strong>
                        ${player.trophies}
                    </div>

                </div>

            </div>

        </div>

    `;
}
