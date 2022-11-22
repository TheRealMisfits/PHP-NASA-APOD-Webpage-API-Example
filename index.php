<?php
header("Refresh:86400");
$url = "https://api.nasa.gov/planetary/apod?api_key=" .$_ENV["api_key"];
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$resp = curl_exec($curl);
curl_close($curl);
//var_dump($resp);
$json = json_decode($resp, true);
?>
<html lang="en-GB">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NASA APOD: <?php echo $json['title'];?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<link rel="preconnect" href="https://cdnjs.cloudflare.com">
<style>
@import url('https://fonts.googleapis.com/css2?family=Francois+One&family=Sora:wght@300;500;600&display=swap');
body, html {
  height: 100%;
}
body {
  background: #fff;
  background-image: linear-gradient(rgba(0, 0, 0, 0.60), rgba(0, 0, 0, 0.60)),  url("<?php echo $json['hdurl'];?>");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  margin: 0;
  padding: 0;
  width: 100%;
  overflow: hidden;
  filter: brightness(80%);
}
  .info {
  opacity: 0.7;
  width: 90%;
  bottom: 0;
  margin-bottom: 20px;
  margin-right: 20px;
  margin-left: 20px;
  color: #fff;
  right: 0;
  text-align: right;
  position: fixed;
  }
  .info .title {
  font-family: 'Francois One', sans-serif;
  font-size: 50px;
  margin-bottom: 7px;
  }
  .info .copyright {
  font-family: 'Sora', sans-serif;
  font-size: 19px;
  font-weight: 500;
  }
  .info .description {
  font-family: 'Sora', sans-serif;
  font-weight: 300;
  }
  .error {
    position:absolute;
  top:0px;
  right:0px;
  bottom:0px;
  left:0px;
  background: #000;
  }
  .error p {
  font-family: 'Sora', sans-serif;
  font-size: 19px;
  font-weight: 500;
  margin: 0;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: #fff;
  }
  .links {
  font-family: 'Sora', sans-serif;
  font-weight: 600;
  text-decoration: none;
  }
  .links a {
  text-decoration: none;
  color: #fff;
  display: inline-block;
  margin-right: 5px;
  }
  .links a :last-child {
  text-decoration: none;
  color: #fff;
  display: inline-block;
  margin-right: 0px;
  } 
  .modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #000;
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  border-radius: 10px;
  background-color: #000;
  color: #fff;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
overflow: auto;
}

/* The Close Button */
.close {
  color: #fff;
  float: right;
  font-size: 28px;
  font-weight: bold;
  display: inline-block;
 margin-top: 20px;
}

.close:hover,
.close:focus {
  color: #fff;
  text-decoration: none;
  cursor: pointer;
}
.modal-header {
font-family: 'Francois One', sans-serif;
  font-size: 50px;
  display: inline-block;
margin-top: 1px;
}
.modal-subheader {
 font-family: 'Francois One', sans-serif;
  font-size: 30px;
margin-top: 1px; 
margin-bottom: 5px; 

}
.modal-text {
  font-family: 'Sora', sans-serif;
}
@media screen and (max-width: 800px) {
#openmodal {
display: none;
}
}
</style>
</head>
<body>
<?php
if( isset( $json['error'] ) ){
echo('<div class="error">');
echo('<p> Fatal Error has Occured.');
exit('</p></div>');
}
?>
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <p class="modal-header">More Information</p><span class="close">&times;</span>
    <p class="modal-subheader">Raw Data</p>
    <p class="modal-text"><?php var_dump($resp);?></p>
      <p class="modal-subheader">Credits</p>
    <p class="modal-text"><b>Image -</b> <?php echo $json["copyright"];?>, 
    </p>
      <p class="modal-text"><b>Website -</b> themisfits.ml</p>
  </div>

</div>
<div class="info">
<p class="title"><?php echo $json['title'];?></p>
<p class="copyright">&#169; <?php echo $json["copyright"];?> // <?php echo $json["date"];?></p>
<p class="description"><?php echo $json['explanation'];?></p>
<div class="links"><a href="<?php echo $json['hdurl'];?>"><i class="fa-solid fa-download"></i> Download</a> <a id="openmodal"><i class="fa-solid fa-circle-info"></i> More Info</a></div>
</div>
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("openmodal");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
</body>
</html>
