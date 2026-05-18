function toggleUser(id,currentStatus){
    let newStatus;
    if(currentStatus == 1){
        newStatus = 0;
    }

    else{
        newStatus = 1;
    }
    let xhttp =
    new XMLHttpRequest();

    xhttp.onreadystatechange =
    function(){

        if(this.readyState == 4 && this.status == 200){
            let response =
            this.responseText.split("|");

            let statusText = response[0];
            let buttonText = response[1];
            let statusClass = response[2];

            let buttonClass = response[3];
            let nextStatus =response[4];
            // STATUS

            let status =document.getElementById("status-" + id);
            status.innerHTML = statusText;
            status.className = statusClass;



            // BUTTON

            let button = document.getElementById( "btn-" + id );

            button.innerHTML = buttonText;
            button.className = buttonClass;

            button.setAttribute("onclick","toggleUser(" +id +"," + nextStatus +")");
        }
    };





    xhttp.open("POST", "../../Controller/toggleUserAjax.php",true );

    xhttp.setRequestHeader(

        "content-type",

        "application/x-www-form-urlencoded"
    );

    xhttp.send(

        "id=" + id +
        "&status=" + newStatus
    );
}
function searchUser(){

    let input = document.getElementById("searchInput").value.toLowerCase();
    let table = document.getElementById( "userTable");
    let tr = table.getElementsByTagName("tr");



    for(let i = 1;i < tr.length;i++){
        
        let td =
        tr[i].getElementsByTagName("td");
        let found = false;
    for(let j = 0;j < td.length;j++){
            if(td[j].innerHTML.toLowerCase().indexOf(input) > -1){
               
                found = true;
            
            }
        }
            if(found){

            tr[i].style.display = "";
            }

        else{
            tr[i].style.display = "none";
        }
    }
}