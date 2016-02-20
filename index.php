<!-- GetSwish API test by David Forsberg, davidanton.se -->
<!-- License: CC-Attribution (http://creativecommons.org/licenses/by/4.0/) -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop by Swish</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
  <script>
    $(document).ready(function(){

      var transId = false;

      var poll = function(){
        $(".loader-img").toggleClass("hide", false);
        $(".success-img").toggleClass("hide", true);
        setTimeout(function(){
          console.warn("Polling...");
          $.get("ajax.php?transactionId=" + transId, function(data){
            $("#msg-poll").html(data);
            data = JSON.parse(data);
            if(data && data.status == "PAID"){
              alert("Thank you for your order!");
              // Perform redirect to order confirmation
              console.info("Order completed.");
              $(".loader-img").toggleClass("hide", true);
              $(".success-img").toggleClass("hide", false);
            }else{
              console.warn("Status: " + data.status);
              poll();
            }
          });
        }, 2000);
      };

      $("#send-btn").click(function(){
        var nr = $("#phone").val();
        $.get("ajax.php?orderId=" + $("#order").val() + "&phone=" + nr, function(data){
          $("#msg-poll").html(data);
          data = JSON.parse(data);
          transId = data.transactionId;
          console.info("Transid: " + transId);
          $("#transid-input").val(transId);
          poll();
        });
      });

      var currentStatus = {};
      $("#callback-sim-btn").click(function(){
        if(!transId){
          transId = $("#transid-input").val();
        }
        $.get("ajax.php", {"transactionId": transId, "action":"update"}, function(data){
          console.log("Current status: " + data);
          $("#msg-callback").html(data);
          currentStatus = data;
        });
      });

      $("#callback-sim-btn2").click(function(){
        console.log(currentStatus);
        $.post("callback.php", JSON.parse(currentStatus), function(data){
          console.log("Callback response: " + data);
          $("#msg-callback").html(data);
        });
      });

    });
  </script>
</head>
<body>
  <br><br>
  <div class="container">

<form class="form-horizontal">
<fieldset>


<!-- change col-sm-N to reflect how you would like your column spacing (http://getbootstrap.com/css/#forms-control-sizes) -->


<!-- Form Name -->
<legend>Form Name</legend>

<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="order" class="control-label col-sm-2">Order-id</label>
  <div class="col-sm-10">
    <input type="tel" class="form-control" id="order" value="DF16021201">
    <p class="help-block">The order id used as payment reference</p>
  </div>
</div>
<div class="form-group">
  <label for="phone" class="control-label col-sm-2">Mobilnummer</label>
  <div class="col-sm-10">
    <input type="tel" class="form-control" id="phone" placeholder="467x xxx xx xx" value="46700000000">
    <p class="help-block">The phone number you'd like to swish from</p>
  </div>
</div>
<!-- Button http://getbootstrap.com/css/#buttons -->
<div class="form-group">
  <label class="control-label col-sm-2" for="send-btn">Send request</label>
  <div class="text-left col-sm-10">
    <button type="button" id="send-btn" name="send-btn" class="btn btn-success" aria-label="Send request">Send</button>
      <img width="50" src="https://i1.wp.com/cdnjs.cloudflare.com/ajax/libs/galleriffic/2.0.1/css/loader.gif" alt="Loading..." class="loader-img hide">
      <img width="50" src="https://upload.wikimedia.org/wikipedia/commons/a/ac/Crystal_Project_success.png" alt="Success!" class="success-img hide">
    <p class="help-block">Send the request</p>
  </div>
</div>

<!-- Text input http://getbootstrap.com/css/#forms -->
<div class="form-group">
  <label for="transid-input" class="control-label col-sm-2">Transaction ID</label>
  <div class="col-sm-10">
    <input type="text" class="form-control" id="transid-input" placeholder="" >
    <p class="help-block">The transaction id number returned by the API</p>
  </div>
</div>

<div class="form-group">
  <label class="control-label col-sm-2" for="send-btn">Simulate callback</label>
  <div class="text-left col-sm-10">
    <button type="button" id="callback-sim-btn" name="callback-sim-btn" class="btn btn-primary">Get status</button>
    <button type="button" id="callback-sim-btn2" name="callback-sim-btn2" class="btn btn-success" aria-label="Send request">Send to callback.php</button>
    <p class="help-block">Since testing could take place behind a firewall or NAT, you can manually retrieve the payment status and simulate the callback call through an AJAX request.</p>
  </div>
</div>
<div id="msg-poll"></div>
<div id="msg-callback"></div>




</fieldset>
</form>
</div>

</body>
</html>