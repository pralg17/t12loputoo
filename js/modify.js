var bakaForm = 0;
var magiForm = 0;


function show(id,id2){
    document.getElementById(id).style.opacity="1";
    document.getElementById(id).style.visibility="visible";
    document.getElementById(id2).style.background="#801224";

};
function hide(id,id2){
    document.getElementById(id).style.opacity="0";
    document.getElementById(id).style.visibility="hidden";
    document.getElementById(id2).style.background="#B71234";
};
function showUnPairInput(id) {
    document.getElementById(id).style.opacity="1";
    document.getElementById(id).style.visibility="visible";
    document.getElementById('unPairButton').style.background="#801224";
};
function showBakaForm() {
    if (bakaForm == 0) {
        bakaForm = 1;
        document.getElementById("bakaForm").style.visibility = "visible";
        document.getElementById("bakaForm").style.opacity = "1";
        document.getElementById("magiForm").style.visibility = "hidden";
        document.getElementById("magiForm").style.opacity = "0";
        magiForm=0;
    }else{
        bakaForm = 0;
        document.getElementById("bakaForm").style.visibility = "hidden";
        document.getElementById("bakaForm").style.opacity = "0";
    }
}
function showMagiForm() {
    if (magiForm == 0) {
        magiForm = 1;
        document.getElementById("bakaForm").style.visibility = "hidden";
        document.getElementById("bakaForm").style.opacity = "0";
        document.getElementById("magiForm").style.visibility = "visible";
        document.getElementById("magiForm").style.opacity = "1";
        bakaForm=0;
    }else{
        document.getElementById("magiForm").style.visibility = "hidden";
        document.getElementById("magiForm").style.opacity = "0";
        magiForm=0;
    }
}
function showErialad() {
        document.getElementById("erialad").style.visibility = "visible";
        document.getElementById("erialad").style.opacity = "1";
        document.getElementById("btnGroupMain2").style.background="#801224";
    
       
}
function hideErialad() {
        document.getElementById("erialad").style.visibility = "hidden";
        document.getElementById("erialad").style.opacity = "0";
		document.getElementById("btnGroupMain2").style.background="#B71234";
}


