<html>
  <head>
    <title>Bootstrap Slider</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
  </head>
  <body>
    <style>
        table {
            width: 70% !important;
        }
    </style>
    <div class="jumbotron text-center">
        <table class="table">
            <tr>
                <th>Category</th>
                <th>Time (Hours)</th>
                <th>Max</th>
            </tr>
            <tr>
                <td>Foundations</td>
                <td><input id="slider_1" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="1" data-slider-value="15"/></td>
                <td id="td_limit_1"></td>
            </tr>
            <tr>
                <td>Logic Games</td>
                <td><input id="slider_2" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="1" data-slider-value="15"/></td>
                <td id="td_limit_2"></td>
            </tr>
            <tr>
                <td>Reading Comprehension</td>
                <td><input id="slider_3" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="1" data-slider-value="15"/></td>
                <td id="td_limit_3"></td>
            </tr>
            <tr>
                <td>Logical reasoning</td>
                <td><input id="slider_4" type="text" data-slider-min="0" data-slider-max="10" data-slider-step="1" data-slider-value="15"/></td>
                <td id="td_limit_4"></td>
            </tr>
            <tr>
                <td colspan=3 align="center">
                    <button id="btn_calc" class="btn btn-primary">Submit</button>
                </td>
            </tr>
            <tr>
                <td colspan=3 align="center" id="td_results">
                </td>
            </tr>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
    <script  src="https://code.jquery.com/jquery-3.6.3.min.js"  integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU="  crossorigin="anonymous"></script>
    <script>
      

      $.ajax({
            url : "backend.php",
            method : "POST",
            data : { init : 1 },
            success : function(msg) {
                var ret = $.parseJSON(msg);
                $('#slider_1').attr("data-slider-max", ret[0]);
                $('#slider_2').attr("data-slider-max", ret[1]);
                $('#slider_3').attr("data-slider-max", ret[2]);
                $('#slider_4').attr("data-slider-max", ret[3]);
                $('#td_limit_1').html(ret[0]);
                $('#td_limit_2').html(ret[1]);
                $('#td_limit_3').html(ret[2]);
                $('#td_limit_4').html(ret[3]);

                // Basic Slider
                var slider_1 = new Slider("#slider_1", {
                });
                var slider_2 = new Slider("#slider_2", {
                });
                var slider_3 = new Slider("#slider_3", {
                });
                var slider_4 = new Slider("#slider_4", {
                });
            }
      })

      

      $("#btn_calc").click(function(){

        var arrCategory = new Array("Foundations", "Logic Games", "Reading Comprehension", "Logical reasoning");

        $.ajax({
            url : "backend.php",
            method : "POST",
            data : { 
                        param_1 : $('#slider_1').val(),
                        param_2 : $('#slider_2').val(),
                        param_3 : $('#slider_3').val(),
                        param_4 : $('#slider_4').val()
                    },
            success : function(msg) {
                var ret = $.parseJSON(msg);
                var html = "";
                $.each(ret, function(i, row){
                    html += arrCategory[i] + "<br><br>";
                    html += row + "<br><br><br>";
                })
                $('#td_results').html(html);
            }
        })
        
      })
    </script>
  </body>
</html>