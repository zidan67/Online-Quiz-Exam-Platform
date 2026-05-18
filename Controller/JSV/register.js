function validateReg(){
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let role = document.querySelector('input[name="role"]:checked');
    
    let isValid = true;
    if(name==""){
    isValid = false;
    document.getElementById("nameError").innerHTML = "Name is required";
    }
    else if(name.lenngth<2){
    isValid = false;
    document.getElementById("nameError").innerHTML = "Minimum 2 characters";
    }
    else{
    document.getElementById("nameError").innerHTML = "";
    }
    if(email==""){
    isValid = false;
    document.getElementById("emailError").innerHTML = "Email is required";
    }
    else if(!email.includes("@")){
        isValid = false;
        document.getElementById("emailError").innerHTML = "Invalid Email";

    }
    else{
        document.getElementById("emailError").innerHTML = "";

    }
    if(password ==""){
    isValid = false;
    document.getElementById("passwordError").innerHTML = "Password is required";
    }
    else if(password.length<8){
    isValid = false;
    document.getElementById("passwordError").innerHTML = "Minimum 8 digits";
    }
    else{
     document.getElementById("passwordError").innerHTML = "";
 
    }
    if(role==null){
        isValid = false;
        document.getElementById("roleError").innerHTML = "Pls Select a role!!";

    }
    else{
    document.getElementById("roleError").innerHTML = "";

    }

return isValid;
}


