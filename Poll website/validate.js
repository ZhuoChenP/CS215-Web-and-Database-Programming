

var password=document.getElementById("pswd");

var email=document.getElementById("email");

var login=document.getElementById("login");
var user_sign=document.getElementById("user_sign");
var pswdr_sign=document.getElementById("pswdr_sign");
var password_sign=document.getElementById("password_sign");
var img=document.getElementById("img");


var opendate=document.getElementById ("Opendate");
var opentime=document.getElementById ("Opentime");
var question=document.getElementById ("Question");
var answer=document.getElementById ("a1");

var validate_email=true;
var validate_pswd=true;
var validate_pswdr=true;
var validate_usern=true;
var validate_img=true;




function usercheck(user_sign){
    
    var user_sign_v = user_sign.value.search(/^[a-zA-Z]+?$/); 
    if(user_sign_v==-1){
        document.getElementById("user_sign_msg").innerHTML="* No spaces or other non-word characters Allowed.";
            
        validate_usern=false;
        user_sign.classList.add("error_msg");
    }

    else
    {
        document.getElementById("user_sign_msg").innerHTML="";

        validate_usern=true;
        user_sign.classList.remove("error_msg");
    }
}

function pswd_r_check(pswdr_sign,password_sign){
    
    if(pswdr_sign.value!=password_sign.value||pswdr_sign.value=="")
    {
        document.getElementById("pswdr_sign_msg").innerHTML="* Password and Confirm Password has to be matched";
        validate_pswdr=false;  
    pswdr_sign.classList.add("error_msg");
}
   else
    {
            document.getElementById("pswdr_sign_msg").innerHTML="";
            validate_pswdr=true;
        pswdr_sign.classList.remove("error_msg");
    }
}

function emailcheck(email){

    var email_v = email.value.search(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/); 

    if(email_v==-1){
        document.getElementById(email.name+"_msg").innerHTML="* Email address empty or wrong format."  +"<br />"+ "&nbsp   (Example: username@somewhere.sth.)";
        validate_email=false;
        email.classList.add("error_msg");
    }

    else
    {
        document.getElementById(email.name+"_msg").innerHTML="";
        validate_email=true;
        email.classList.remove("error_msg");
    }
    
}

function pswdcheck(password){
    var pswd_v;
    if(password.name=="pswd")
    {
        pswd_v =password.value.search( /^(\S*)?$/);
    }
    else {pswd_v =password.value.search(/^(\S*\W+\S*)$/)}


    if((pswd_v==-1&&password.name=="pswd")||(password.name=="pswd"&&password.value.length!=8)){

        document.getElementById(password.name+"_msg").innerHTML="* 8 characters or longer, no spaces";

        validate_pswd=false;   
        password.classList.add("error_msg");
    }

    else if ((password.name=="pswd_sign"&&pswd_v==-1)||(password.name=="pswd_sign"&&password.value.length!=8))
    {
        document.getElementById(password.name+"_msg").innerHTML="* 8 characters long, at least one non-letter character";
        validate_pswd=false;  
        password.classList.add("error_msg");
    }
   else
    {
        document.getElementById(password.name+"_msg").innerHTML="";
        validate_pswd=true;
        password.classList.remove("error_msg");

    }
}


function validateForm() {
    if (validate_email == 0||validate_pswd==0||validate_usern==0||validate_pswdr==0||validate_img==0) {
        event.preventDefault();
    }
    else{ }
  }

function loginErrorHandler(event){
    var email = document.getElementById("email");
    var password = document.getElementById("pswd");
    emailcheck(email);
    pswdcheck(password);
    validateForm();
}
function imgcheck(img){
    if(img.value=="")
    {
        
       document.getElementById("img_sign_msg").innerHTML="* Please select your avatar image";
            validate_img=false;  
            img.classList.add("error_msg");
    }
       else
        {
                document.getElementById("img_sign_msg").innerHTML="";
                validate_img=true;
                img.classList.remove("error_msg");
        }
    
}
function SignErrorHandler(event){
    var email_sign = document.getElementById("email_sign");
    var password_sign= document.getElementById("password_sign");
    var user_sign= document.getElementById("user_sign");
    var pswdr_sign=document.getElementById("pswdr_sign");
    var img=document.getElementById("img");

    imgcheck(img);
    pswd_r_check(pswdr_sign,password_sign);
    usercheck(user_sign);
    emailcheck(email_sign);
    pswdcheck(password_sign);
    validateForm();
}

function CreationErrorHandler(event)
{
var opendate=document.getElementById ("Opendate");
var opentime=document.getElementById ("Opentime");
var closedate=document.getElementById ("Closedate");
var closetime=document.getElementById ("Closetime");
var question=document.getElementById ("Question");
var a1=document.getElementById ("a1");
var a2=document.getElementById ("a2");
var a3=document.getElementById ("a3");
var a4=document.getElementById ("a4");
var a5=document.getElementById ("a5");
datecheck(opendate);
timecheck(opentime);
datecheck(closedate);
timecheck(closetime);
questioncheck(question);
answercheck(a1);
answercheck(a2);
answercheck(a3);
answercheck(a4);
answercheck(a5);
checkalltreu(answercheck(a1),answercheck(a2),answercheck(a3),answercheck(a4),answercheck(a5));
validatcreation();
}

function validatcreation()
{
if(validate_date==0||validate_time==0||validate_question==0||validate_answer==0)
{event.preventDefault();}
else{}
}


var validate_date=true;
var validate_time=true;
var validate_question=true;
var validate_answer=true;

function checkalltreu(a1,a2,a3,a4,a5)
{
if(a1==a2&&a1==a3&&a1==a4&&a1==a5&&a1==1)
{validate_answer=1;}
else{validate_answer=0;}
}


function answercheck(answer)
{
answer_v=answer.value;
if(answer_v.length>50)
{
    document.getElementById(answer.name+"_msg").innerHTML="* The answer cannot be more than 50 characters";
    answer.classList.add("error_msg");
return 0;}
   
else{
  
    document.getElementById(answer.name+"_msg").innerHTML="";
    answer.classList.remove("error_msg"); 
    return 1;
}
}



function questioncheck(question)
{
question_v=question.value;
if(question_v==""||question_v.length>100)
{document.getElementById(question.name+"_msg").innerHTML="* non-blank and shorter than 100 characters";
validate_question=false;  
question.classList.add("error_msg");}
else{
    document.getElementById(question.name+"_msg").innerHTML="";
    validate_question=true;
    question.classList.remove("error_msg");
    }
}




function datecheck(date)
{
    date_v=date.value.search(/^\d{1,2}\/\d{1,2}\/\d{4}$/);

    if(date_v==-1)
    {
        
       document.getElementById(date.name+"_msg").innerHTML="* The formate should be (dd/mm/yyyy)";
            validate_date=false;  
            date.classList.add("error_msg");
    }
       else
        {
                document.getElementById(date.name+"_msg").innerHTML="";
                validate_date=true;
                date.classList.remove("error_msg");
        }
}

function timecheck(time)
{
    time_v=time.value.search(/^\d{1,2}:\d{2}([ap]m)?$/);
    if(time_v==-1)
    {
        
       document.getElementById(time.name+"_msg").innerHTML="* eg. 19:25 or 7:25pm";
            validate_time=false;  
            time.classList.add("error_msg");
    }
       else
        {
                document.getElementById(time.name+"_msg").innerHTML="";
                validate_time=true;
                time.classList.remove("error_msg");
        }
}


function counterHandlerQ(event)
{
   var obj=document.getElementById("Question");
    counter(obj);
}
function counterHandlerA1(event)
{
   var obj1=document.getElementById("a1");
   counter(obj1);
}
function counterHandlerA2(event)
{  var  obj2=document.getElementById("a2");
counter(obj2);}
function counterHandlerA3(event)
{  var  obj3=document.getElementById("a3");
counter(obj3);}
function counterHandlerA4(event)
{  var  obj4=document.getElementById("a4");
counter(obj4);}
function counterHandlerA5(event)
{  var  obj5=document.getElementById("a5");
counter(obj5);}

function counter(obj){
    let jb="dynamic_"+obj.name
    let maxlengthQ=100;
    
    let maxlengthA=50;
    if(obj.name=="question")
    {var lengthQ=obj.value.length;}
    else{var lengthA=obj.value.length}
    
     
if(obj.name=="question"&&lengthQ>maxlengthQ)
{
    document.getElementById(jb).innerHTML='<span style="color: red;">'+lengthQ+" out of "+maxlengthQ+' charateries. </span>';
}
else if(obj.name=="question"&&lengthQ<=maxlengthQ){

    document.getElementById(jb).innerHTML="Input: "+lengthQ+" charateries. "+(maxlengthQ-lengthQ)+ ' left';
}


for(var x=1;x<6;x++)
{
if(obj.name=="a"+x&&lengthA>maxlengthA)
{  
    document.getElementById(jb).innerHTML='<span style="color: red;">'+lengthA+" out of "+maxlengthA+' charateries</span>';
}
else if(obj.name=="a"+x&&lengthA<=maxlengthA){
    document.getElementById(jb).innerHTML="Input: "+lengthA+" charateries. "+(maxlengthA-lengthA)+ "left";
}

}

}