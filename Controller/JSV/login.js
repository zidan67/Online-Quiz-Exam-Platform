function validateLogin(){

    let email =document.getElementById("email").value;
    let password = document.getElementById("password").value;

    let isValid = true;

    // email CHeck

    if(email == ""){

    isValid = false;
     document.getElementById("emailError").innerHTML = "Email is required";
    }

    else if(!email.includes("@")){

    isValid = false;
    document.getElementById("emailError").innerHTML ="Invalid Email";  

    }   

    else{

        document.getElementById("emailError").innerHTML = "";
    }

    // PASSWORD

    if(password == ""){

    isValid = false;
    document.getElementById("passwordError").innerHTML ="Password is required";   
    }

    else{

    document.getElementById("passwordError").innerHTML = "";
    
    }
return isValid;
}