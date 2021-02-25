//fetchdata();
setInterval(fetchdata,90000);

function fetchdata(){
    {
        var subcontainer=document.getElementsByClassName("subcontainer");
        var  xmlhttp = new XMLHttpRequest();
        // access the onreadystatechange event for the XMLHttpRequest object
            xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
               var results = JSON.parse(this.responseText)
               if (results.length > 0) 
               {
                 var count=0;
                 
                  
                   for (var i = 0; i < results.length; i++) 
                   {
                    
                    var json_result = results[i];
                    var matches=subcontainer[count].id.match(/(\d+)/);
                    var qid=parseInt(json_result.qid);
                        if(json_result.aid==null)
                        {          
                            var parent=subcontainer[0].parentNode;
                            if(qid>matches[0])
                            {   
                                addElement(parent.id,"div","subid"+json_result.qid,subcontainer[count],"subcontainer");
                                addElement_sub("subid"+json_result.qid,"div","board"+json_result.qid,"","border");
                                addElement_sub("board"+json_result.qid,"p","","Poll Created date:"+json_result.created_dt,"title");
                                addElement_sub("subid"+json_result.qid,"p","sub21"+json_result.qid,json_result.question,"poll_event");
                                addElement_sub("subid"+json_result.qid,"ol","ol"+json_result.qid,"","PA");
                                addElement_sub("ol"+json_result.qid,"span","formvote"+json_result.qid,"","spanFormat");
                                addElement_form("formvote"+json_result.qid,"post","Main Page.php","subform"+json_result.qid);
                                addElement_sub("subform"+json_result.qid,"input","","","","hidden","question_id",json_result.qid);
                                addElement_sub("subform"+json_result.qid,"input","","","","submit","Vote","Vote");
                                
                                addElement_sub("ol"+json_result.qid,"span","formresult"+json_result.qid,"","spanFormat");
                                addElement_form("formresult"+json_result.qid,"post","Main Page.php","subform1"+json_result.qid);
                                addElement_sub("subform1"+json_result.qid,"input","","","","hidden","result_id",json_result.qid);
                                addElement_sub("subform1"+json_result.qid,"input","","","","submit","Result","Result");
                                removeElement(subcontainer[5].id);
                                count++;
                            }
                        }
                        else if((json_result.aid!=null)&&(qid>matches[0])){
                                var node=document.getElementById("formvote"+json_result.qid);
                            addElement_ol(json_result.answer,"ol"+json_result.qid,node);
                            } 
                        
                   }
               }
                               
             }
         } 
         xmlhttp.open("GET", "auto.php", true);
         xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         xmlhttp.send();
     }

   }
 
    function removeElement(elementId) {
        // Removes an element from the document
        var element = document.getElementById(elementId);
        element.parentNode.removeChild(element);
    }
    
    function addElement(parentId, elementTag, elementId, str,className) {
        // Adds an element to the document
        var p = document.getElementById(parentId);
        var newElement = document.createElement(elementTag);
        newElement.setAttribute('id', elementId);
        newElement.className=className;
        p.insertBefore(newElement,str);
    }
    function addElement_ol(answer,parentId,str1) {
        // Adds an element to the document
        var ol = document.getElementById(parentId);
    var name = answer;
    var li = document.createElement('li');
    li.appendChild(document.createTextNode(name));
    ol.insertBefore(li,str1);
    }

    function addElement_sub(parentId, elementTag, elementId, html,className,type,name,value) {
        // Adds an element to the document
        var p = document.getElementById(parentId);
        var newElement = document.createElement(elementTag);
        newElement.setAttribute('id', elementId);
        newElement.innerHTML = html;
        newElement.className=className;
        newElement.type=type;
        newElement.name=name;
        newElement.value=value;
        p.appendChild(newElement);
    }

    function addElement_form(parentId,method,action,elementId) {
        // Adds an element to the document
        var p = document.getElementById(parentId);
        var newElement = document.createElement("form");
        newElement.setAttribute('id', elementId);
        newElement.method = method;
        newElement.action=action;
        p.appendChild(newElement);
    }