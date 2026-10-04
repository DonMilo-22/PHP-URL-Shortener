<?php
require_once __DIR__ . "/../src/Database.php";
$db = new Database(__DIR__ . "/../data/links.sqlite");

if (isset($_GET["c"])) {
  $url=$db->find($_GET["c"]);
  if ($url) { header("Location: ".$url, true, 302); exit; }
  http_response_code(404); $error="Short link not found.";
}

$short=null;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $url=trim($_POST["url"] ?? "");
  if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array(parse_url($url, PHP_URL_SCHEME), ["http","https"], true)) $error="Enter a valid http:// or https:// URL.";
  else {
    do { $code=substr(bin2hex(random_bytes(4)),0,7); } while ($db->find($code));
    $db->save($code,$url);
    $destinationHost = parse_url($url, PHP_URL_HOST);
    $scheme=(!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"]!=="off") ? "https" : "http";
    $short=$scheme."://".$_SERVER["HTTP_HOST"]."/?c=".$code;
  }
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>PHP URL Shortener</title>
<style>
:root{font-family:Inter,system-ui;background:#0e1014;color:#f7f7f5}*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px}.box{width:min(680px,100%);background:#171a21;border:1px solid #2a2f3a;border-radius:24px;padding:34px;box-shadow:0 20px 70px #0006}h1{font-size:clamp(2rem,7vw,4.8rem);line-height:.9;letter-spacing:-.055em;margin:0 0 18px}p{color:#aeb3bd}form{display:flex;gap:10px;margin-top:25px}input{flex:1;background:#0e1117;color:white;border:1px solid #343a46;border-radius:12px;padding:14px}button{border:0;border-radius:12px;padding:0 18px;font-weight:800;background:#9dff6a;color:#101310;cursor:pointer}.result,.error{margin-top:18px;padding:14px;border-radius:12px;word-break:break-all}.result{background:#18241b;border:1px solid #34513b}.error{background:#2a1818;border:1px solid #5a3030}.copy{margin-top:12px;padding:9px 13px}@media(max-width:560px){form{flex-direction:column}button{padding:14px}}
</style></head><body><main class="box"><p>LOCAL • PHP + SQLITE</p><h1>Short links,<br>zero framework.</h1><p>Paste a long address and get a compact local redirect code.</p>
<form method="post"><input type="url" name="url" placeholder="https://example.com/a/very/long/url" required><button>Shorten</button></form>
<?php if ($short): ?><div class="result"><strong>Your short URL</strong><br><small>Destination: <?=htmlspecialchars($destinationHost ?? "")?></small><br><a id="short-url" href="<?=htmlspecialchars($short)?>"><?=htmlspecialchars($short)?></a><br><button class="copy" type="button" onclick="copyShortUrl()">Copy link</button></div><?php endif; ?>
<?php if (isset($error)): ?><div class="error"><?=htmlspecialchars($error)?></div><?php endif; ?>
</main>
<script>
async function copyShortUrl(){
  const el=document.getElementById("short-url");
  if(!el) return;
  await navigator.clipboard.writeText(el.href);
  const button=document.querySelector(".copy");
  if(button){ button.textContent="Copied!"; setTimeout(()=>button.textContent="Copy link",1500); }
}
</script>
</body></html>