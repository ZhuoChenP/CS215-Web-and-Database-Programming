
//console.log(info1);
setInterval(loop,60000);
var letter=document.getElementsByName("piechart");


//loop();
function loop()
{
    for(var x=0;x<letter.length;x++)
    {
        updateresult(letter[x].id);
    }
}

function updateresult(chartid){
    {
        var matches=chartid.match(/(\d+)/);
        var qid=parseInt(matches);
        var title_id=document.getElementById("span"+qid).innerHTML;
        //console.log(title_id);
        var  xmlhttp = new XMLHttpRequest();
        // access the onreadystatechange event for the XMLHttpRequest object
            xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                var results = JSON.parse(this.responseText);
                //console.log(results);
                var info1=[];
                
                for (var i = 0; i < results.length; i++) 
                {   //console.log(results);
                  if(title_id==results[i].last_vote_dt){}
                  else{
                    if(results[i].answer!=null&&qid==results[i].qid)
                    {
                        info1.push({answer:results[i].answer,total:"",aid:results[i].aid})
                    }
                    for (var b = 0; b < info1.length; b++) 
                    {
                        if(results[i].total!=null&&info1[b].aid==results[i].aid)
                        {
                            info1[b].total=results[i].total;

                        }
                    }
                    if(qid==results[i].qid&&results[i].last_vote_dt!=null)
                    {
                        var change=document.getElementById("span"+qid);
                        change.innerHTML=results[i].last_vote_dt;
                        change.style.color="red";
                        setTimeout(function() { changebuck(change); }, 5000);
                        }
                    }
                    
               }
               
                //console.log(info1);
                createChart(qid,info1);
               //console.log(info1[1].total);
            }
                               
         } 
         
         xmlhttp.open("GET", "autoresult.php?q="+ qid, true);
         xmlhttp.send();
     }
}


function changebuck(element)
{
    element.style.color="black";
}





function createChart(target,what){
    google.charts.load('current', {
      callback: function () {
        var cont = 0;
        //var rowtbl = document.getElementById("tabella").rows.length;
        //rowtbl = rowtbl - 1;

        // use object notation for column headings
        var data = new google.visualization.arrayToDataTable([
          [{type: 'string', label: ''}, {type: 'number', label: 'Total: '}]
        ]);
       
        //number rows table
        while(cont<what.length){

          var nomi;
          var qnt;
          nomi = what[cont].answer;
          qnt = what[cont].total;
          var info = {
            name: nomi,
            qn: qnt
          };
          // add row to google data
          data.addRow([
            info.name,
            parseFloat(info.qn)
          ]);

          cont = cont +1;
        }

        var options = {'title':'Poll Results', 'width':350, 'height':250};

        var chart = new google.visualization.PieChart(document.getElementById('piechart'+target));
        chart.draw(data, options);
      },
      packages: ['corechart']
    });

  }
  