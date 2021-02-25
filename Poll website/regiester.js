try{
document.getElementById("login").addEventListener("click",loginErrorHandler,false);
}
catch{}


try{
document.getElementById("sign").addEventListener("click",SignErrorHandler,false);}
catch{}
try{
    document.getElementById("creation").addEventListener("click",CreationErrorHandler,false);
    document.getElementById("Question").addEventListener("keyup",counterHandlerQ,false);
    document.getElementById("a1").addEventListener("keyup",counterHandlerA1,false);
    document.getElementById("a2").addEventListener("keyup",counterHandlerA2,false);
    document.getElementById("a3").addEventListener("keyup",counterHandlerA3,false);
    document.getElementById("a4").addEventListener("keyup",counterHandlerA4,false);
    document.getElementById("a5").addEventListener("keyup",counterHandlerA5,false);
}
    catch{}