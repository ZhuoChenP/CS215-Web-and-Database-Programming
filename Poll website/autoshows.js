var aid="";


function changevote(){
    event.preventDefault()
    showresult();
}


function showresult(){
   
        var  xmlhttp = new XMLHttpRequest();
        // access the onreadystatechange event for the XMLHttpRequest object
            xmlhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                var results = JSON.parse(this.responseText);
                var list=[];
                for (var i = 0; i < results.length; i++) 
                {
                    if(results[i].answer!=null)
                    {
                        list.push({answer:results[i].answer,total:""})
                    }
                    for (var b = 0; b < list.length; b++) 
                    {
                        if(results[i].total!=null&&list[b].total=="")
                        {
                            list[b].total=results[i].total;

                        }
                    }
                }
                //console.log(list); 
                remove();
                createChart(list);
             }
            }
         xmlhttp.open("GET", "autoshows.php?aid="+ aid, true);
         xmlhttp.send();
}

function remove(){
var change=document.getElementById("change");
change.innerHTML="";
}

function add(){




    
}

function createChart(what){
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

        var chart = new google.visualization.PieChart(document.getElementById('change'));
        chart.draw(data, options);
      },
      packages: ['corechart']
    });

  }
  


function findid()
{

var pre_find_id=document.getElementsByClassName("helper");
for(var x=0;x<pre_find_id.length;x++)
{
    if(pre_find_id[x].checked){
      var  value = pre_find_id[x].value;
    }
}
aid=value;
}

document.getElementById("showchart").addEventListener('submit',changevote,false);

document.getElementById("list").addEventListener('click',findid,false);