<?php

$api_key = "3mM44UdBYNhWb2_4cUvaDHZJAkvnVzVpF37a3";
$api_secret = "7kEY3AVGmz6Uw29BwFAUKw";

$domain = $_POST["domain"];
$url = "https://api.godaddy.com/v1/domains/available?domain=" . $domain;

$headers = array(
  "Authorization: sso-key " . $api_key . ":" . $api_secret,
  "Content-Type: application/json",
);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

echo "<h1>Domain Availability Checker</h1>";
echo "<p>Anda mengecek domain: <strong>" . $domain . "</strong></p>";

if ($data["available"]) {
  echo "<p><span style='color: green'>Domain Tersedia!</span></p>";
  echo "<p>Berikut informasi detailnya:</p>";
  echo "<ul>";
  foreach ($data["prices"] as $price) {
    echo "<li>";
    echo $price["currency"] . " " . $price["amount"];
    if ($price["duration"] > 1) {
      echo " per " . $price["duration"] . " tahun";
    } else {
      echo " per tahun";
    }
    echo "</li>";
  }
  echo "</ul>";
  echo "<p><a href='https://www.godaddy.com/domains/register.aspx?domain=" . $domain . "' target='_blank'>Daftar Domain Ini di GoDaddy</a></p>";
} else {
  echo "<p><span style='color: red'>Domain Tidak Tersedia.</span></p>";
  echo "<p>Berikut beberapa saran:</p>";
  echo "<ul>";
  echo "<li>Coba gunakan ekstensi domain lain.</li>";
  echo "<li>Cari variasi nama domain yang mirip.</li>";
  echo "<li>Gunakan layanan domain backorder.</li>";
  echo "</ul>";
}

?>
