window.onload = function () {
    document.Register.ok.disabled = true;
}

document.getElementById("reg").onsubmit = function () {
    if (document.querySelector("#name").value === "") { 
        alert("يجب ادخال اسمك كامل");
        return false;
        console.log("sdf");
    }
    if (/^[A-Za-z\u0621-\u064A]+\s{1}[A-Za-z\u0621-\u064A]+\s{1}[A-Za-z\u0621-\u064A]+$/g.test(document.querySelector("#name").value) === false) {
        alert("بجب ادخال الاسم الثلاثي");
        return false;
    }
    if (document.getElementById("email").value === "") {
        alert("يجب ادخال ايميل");
        return false;
    }

    if (/\w+@(gmail|hotmail|yahoo).(com|net|org)$/.test(document.getElementById("email").value) === false) {
        alert("ادخل الايميل بشكل صحيح");
        return false;
    }
    if (/^[0-9]{9}$/g.test(document.getElementById("tel").value) === false){
        alert("يحب ادخال رقم الهاتف بشكل صحيح");
        return false;
    }

    if (/^(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$+()=*{}/|_%^&*\u0621-\u064A-]{4,}$/g.test(document.querySelector("#pass").value) === false) {
        alert("يجب الا تقل كلمة السر عن خمسة احرف تحتوي على احرف كبيرة وصغيرة ورموز وارقام");
        return false;
    }
    if (document.querySelector("#pass1").value.length == 0) {
        alert("يجب تاكيد كلمة السر");
        return false;
    }
    if (document.querySelector("#pass1").value 
    !== document.querySelector("#pass").value) {
        alert("لا تتطابق كلمة السر");
        return false;
    }
    
  
    
    if (Register.user_gender[0].checked == false && Register.user_gender[1].checked == false) {
        alert("يحب تحديد الجنس");
        return false;
    }
    // if (document.querySelector("#country").selectedIndex == 0) {
    //     alert("You must choose the country");
    //     return false;
    // }
    return true;
}

function checkImg() {
    if (!/(\.jpg|\.jpeg|\.png|\.svg)$/i.exec(document.getElementById("user_img").value)) {
        alert("Invalid file type");
        document.getElementById("user_img").value = '';
        return false;
    }
    return true;
}

function theChecker() {
    if (document.Register.agree.checked == true)
        document.Register.ok.disabled = false;
    else
        document.Register.ok.disabled = true;
}

function checkC() {
    if (document.getElementById("name_s").value === "" || /^([A-Za-z\u0621-\u064A]+\s{0,1}){1,}$/g.test(document.getElementById("name_s").value) === false) {
        document.getElementById("send_c").disabled = true;
        return false;
    }
    if (document.getElementById("email_s").value === "" || /\w+@(gmail|hotmail|yahoo).(com|net|org)$/.test(document.getElementById("email_s").value) === false) {
        document.getElementById("send_c").disabled = true;
        return false;
    }
    if (document.getElementById("mess_s").value.length == 0) {
        document.getElementById("send_c").disabled = true;
        return false;
    }
    document.getElementById("send_c").disabled = false;
    return true;
}