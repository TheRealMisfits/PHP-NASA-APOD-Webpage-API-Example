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
<style>
@import url('https://fonts.googleapis.com/css2?family=Francois+One&family=Sora:wght@300;500&display=swap');
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
<div class="info">
<p class="title"><?php echo $json['title'];?></p>
<p class="copyright">&#169; <?php echo $json["copyright"];?> // <?php echo $json["date"];?></p>
<p class="description"><?php echo $json['explanation'];?></p>
</div>
</body>
</html>
