<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    
    <title>Show Graph</title>
    
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
  </head>

  <body>

    <div class="container">
        <p><b>62101639 Julaluck Noosuwan</b></p>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-4">
                <canvas id="ttemp" width="400" height="200"></canvas>
            </div>
            <div class="class col-4">
                <canvas id="hhum" width="400" height="200"></canvas>
            </div>

            <div class="class col-4">
                <canvas id="llight" width="400" height="200"></canvas>
            </div>
        </div>

        <div class="class row">
            <div class="class col-3">

              <div class="class row">
                <div class="class col-4"><b>Temperature</b></div>
                <div class="col-8" >
                  <span id="lastTemperature"></span>
                </div>
              </div>

              <div class="class row">
                <div class="class col-4"><b>Humidity</b></div>
                <div class="col-8" >
                  <span id="lastHumidity"></span>
                </div>           
              </div>

              <div class="class row">
                <div class="class col-4"><b>Light</b></div>
                <div class="col-8" >
                    <span id="lastLight"></span>
                </div>
              </div>

              <div class="class row">
                <div class="class col-4"><b>Update</b></div>
                <div class="col-8" >
                  <span id="lastUpdate"></span>
                </div>
              </div>
            
            </div>
        </div>
    </div>

  </body>

  <script>

        function showtemp(data){
            var ctx=document.getElementById('ttemp').getContext('2d');
            var showtemp=new Chart(ctx,{
                type:'line',
                data:{
                labels:data.xlabel,
                datasets:[{
                    label:data.label,
                    data:data.data,
                    fill: false,
                    borderColor: '#9d43a0 ',
                    tension: 0.1
                    }]
                }
            });
        }

        function showhum(data2){
            var ctxy=document.getElementById('hhum').getContext('2d');
            var showhum=new Chart(ctxy,{
                type:'line',
                data:{
                labels:data2.xlabel,
                datasets:[{
                    label:data2.label,
                    data:data2.data,
                    fill: false,
                    borderColor: '#9d43a0 ',
                    tension: 0.1
                    }]
                }
            });
        }
        
        function showlight(data3){
            var ctxy=document.getElementById('llight').getContext('2d');
            var showlight=new Chart(ctxy,{
                type:'line',
                data:{
                labels:data3.xlabel,
                datasets:[{
                    label:data3.label,
                    data:data3.data,
                    fill: false,
                    borderColor: '#9d43a0 ',
                    tension: 0.1
                    }]
                }
            });
        }

        $(()=>{
          
          let url = " https://api.thingspeak.com/channels/1479261/feeds.json?results=240";

          $.getJSON(url)
            .done(function(data){
              //console.log(data);
              let feed=data.feeds;
              let chan=data.channel;
              console.log(feed);

              const d =new Date(feed[0].created_at);
              const monthNames=["January","February","March","April","May","June","July"
                                ,"August","September","October","November","December"];
              let dateStr = d.getDate()+" "+monthNames[d.getMonth()]+" "+d.getFullYear();
              dateStr += " "+d.getHours()+":"+d.getMinutes();

             var plot_data=Object();
             var xlabel=[];
             var temp=[];
             var humi=[];
             var ligh=[];
             
             $.each(feed,(k,v)=>{
                xlabel.push(v.entry_id);
                humi.push(v.field1);
                temp.push(v.field2);
                ligh.push(v.field3);
                console.log(k,humi);
             });
             
              var data=new Object();
              data.xlabel=xlabel;
              data.data=temp;
              data.label=chan.field2;
              showtemp(data);

            
              var data2=new Object();
              data2.xlabel=xlabel;
              data2.data=humi;
              data2.label=chan.field1;
              showhum(data2);

              var data3=new Object();
              data3.xlabel=xlabel;
              data3.data=ligh;
              data3.label=chan.field3;
              showlight(data3);


              
              $("#lastTemperature").text(feed[0].field2+" C");
              $("#lastHumidity").text(feed[0].field1+" %");
              $("#lastLight").text(feed[0].field3);
              $("#lastUpdate").text(dateStr);
              console.log(humi);
              
            })
            .fail(function(error){
            });
      });


  </script>
</html>