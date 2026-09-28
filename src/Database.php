<?php
final class Database {
  private PDO $pdo;
  public function __construct(string $path) {
    $dir = dirname($path); if (!is_dir($dir)) mkdir($dir, 0775, true);
    $this->pdo = new PDO("sqlite:" . $path);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $this->pdo->exec("CREATE TABLE IF NOT EXISTS links (code TEXT PRIMARY KEY, url TEXT NOT NULL, created_at TEXT NOT NULL)");
  }
  public function save(string $code, string $url): void {
    $q=$this->pdo->prepare("INSERT INTO links(code,url,created_at) VALUES(:c,:u,:d)");
    $q->execute([":c"=>$code,":u"=>$url,":d"=>date(DATE_ATOM)]);
  }
  public function find(string $code): ?string {
    $q=$this->pdo->prepare("SELECT url FROM links WHERE code=:c"); $q->execute([":c"=>$code]);
    $v=$q->fetchColumn(); return $v === false ? null : (string)$v;
  }
}