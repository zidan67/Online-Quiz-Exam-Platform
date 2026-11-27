function loadLeaderboard(){

    let xhttp =
    new XMLHttpRequest();



    xhttp.onreadystatechange =
    function(){

        if(
            this.readyState == 4 &&
            this.status == 200
        ){

            document.getElementById(
                "leaderboardTable"
            ).innerHTML =
            this.responseText;
        }
    };



    xhttp.open(
        "GET",
        "../../TASK4/Controller/leaderboardAjax.php",
        true
    );



    xhttp.send();
}



loadLeaderboard();



let time = 30;

setInterval(function(){

    time--;

    document.getElementById(
        "countdown"
    ).innerHTML = time;



    if(time <= 0){

        loadLeaderboard();

        time = 30;
    }

}, 1000);