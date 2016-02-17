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
            $("#msg").html(data);
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
          $("#msg").html(data);
          data = JSON.parse(data);
          transId = data.transactionId;
          console.info("Transid: " + transId);
          $("#transid-input").val(transId);
          poll();
        });
      });

      $("#status-unpaid-btn").click(function(){
        $.post("callback.php", {"transactionId": transId, "status":"UNPAID"}, function(data){
          $("#status-unpaid-btn").toggleClass("active", true);
          $("#status-paid-btn").toggleClass("active", false);

          console.log("Data (unpaid): " + data);
          $("#msg").html(data);
        });
      });

      $("#status-paid-btn").click(function(){
        $.post("callback.php", {"transactionId": transId, "status":"PAID"}, function(data){
          $("#status-unpaid-btn").toggleClass("active", false);
          $("#status-paid-btn").toggleClass("active", true);

          console.log("Data (paid): " + data);
          $("#msg").html(data);
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
    <input type="text" class="form-control" id="transid-input" placeholder="" readonly="">
    <p class="help-block">The transaction id number returned by the API</p>
  </div>
</div>
<!-- Button Group http://getbootstrap.com/components/#btn-groups -->
<div class="form-group">
  <label class="control-label col-sm-2">Button Group</label>
  <div class="text-left col-sm-10">
    <div id="status-unpaid-btnGroup" class="btn-group" role="group" aria-label="Button Group">
      <button type="button" id="status-unpaid-btn" name="status-unpaid-btn" class="btn btn-danger" aria-label="Set status: unpaid">Set status: unpaid</button>
      <button type="button" id="status-paid-btn" name="status-paid-btn" class="btn btn-success" aria-label="Set status: unpaid">Set status: paid</button>
    </div>
    <p class="help-block">Set the session variable for payment status</p>
  </div>
</div>

<div id="msg"></div>


</fieldset>
</form>
</div>

</body>
</html>