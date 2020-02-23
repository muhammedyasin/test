<?php 

class veritabani{
	private $db;
    private $dsn;
    private $user;
    private $password;

    function __construct() {       
        $this->dsn = 'mysql:host=localhost;dbname=aeonbilgitekonlojileri;charset=utf8';
        $this->user = 'root';
        $this->password = '';
    }
// Bağlantı komutları 
   private function Ac() {
        try { $this->db = new PDO($this->dsn, $this->user, $this->password); }
        catch (PDOException $e) { echo 'Veritabanı bağlantısı başarısız oldu: ' . $e->getMessage(); }
    }

    private function Kapat() {
        $this->db = null;
    }

   function listele($tablo,$diger="") {
        $sonuc = null;
        $this->Ac();
        $query = $this->db->query("SELECT * FROM ".$tablo." ".$diger, PDO::FETCH_ASSOC);
        if ( $query ) $sonuc = $query; else $sonuc = null;
        $this->Kapat();
        return $sonuc;
    }
    function ozellistele($diger="") {
        $sonuc = null;
        $this->Ac();
        $query = $this->db->query($diger, PDO::FETCH_ASSOC);
        if ( $query ) $sonuc = $query; else $sonuc = null;
        $this->Kapat();
        return $sonuc;
    }
	function ekle($tablo, $veriler) {
        $sonuc = 0;
        $alan1 = "";
        $alan2 = "";
        foreach ($veriler as $anahtar => $deger) {
            $alan1 .= $anahtar . ",";
            $alan2 .= ":".$anahtar.",";
        }
        $alan1 = substr($alan1,0,strlen($alan1)-1);
        $alan2 = substr($alan2,0,strlen($alan2)-1);
        $this->Ac();
        $query = $this->db->prepare("INSERT INTO ".$tablo." (".$alan1.") VALUES (".$alan2.")");
        $query->execute($veriler);
        if ( $query ) $sonuc = $this->db->lastInsertId(); else $sonuc = 0;
        $this->Kapat();
        return $sonuc;
    }
	
/////////////////////////////////// GÜNCELLE ///////////////////////
	     function guncelle($tablo, $veriler, $where="") {
        $sonuc = "";
        $alan = "";
        foreach ($veriler as $anahtar => $deger) $alan .= $anahtar . "= :".$anahtar.",";
        $alan = substr($alan,0,strlen($alan)-1);
        if($where!="") $where = " WHERE ".$where;
        $this->Ac();
        $query = $this->db->prepare("UPDATE ".$tablo." SET ".$alan.$where);
        $update = $query->execute($veriler);
        if ( $update ) $sonuc = $query->rowCount(); else $sonuc = 0;
        $this->Kapat();
        return $sonuc;
    }
///////////////////////////// GÜN. BİTİŞ //////////////////////

    function sil($tablo,$where) {
        $this->Ac();                    
        $delete = $this->db->exec("DELETE FROM ".$tablo." WHERE ".$where); 
        $this->Kapat();
        return $delete;
    }
 
}
/*
		///////// KULLANIMLARI AŞAĞIDA Kİ GİBİDİR. //////////////
		
		include_once("kediframe.php");
///////////// Klas Çağırma /////////////////////////

$vt = new veritabani(); // Class çağırma
//////////// Nesne Oluşturma /////////////////////

$sorgu = $vt->listele("odalar","ORDER BY oda_id DESC"); // Listeleme fonksiyonunu çağırma
if($sorgu != null) foreach( $sorgu as $satir ) {
	echo "<b>".$satir["oda_adi"]."</b><br />";
	} // Listeleme fonksiyonunu ekrana çıktı verme.
//////////////// Listeleme ///////////////////	

echo $sonuc = $vt->ekle("odalar",array("oda_adi"=>"Odam","oda_tanim"=>"tanım","resim"=>"resim","fiyat"=>270));
// Echo ile ekrana yazdırılan lastinsertid yani son eklenen kaydın id'si.
// Array içerisinde ("alan_adı"=>"parametre") yapısına ait.
////////////////// Ekleme //////////////////

$guncelle = $vt->guncelle("odalar",array("oda_tanim"=>"Beyoğlu Otel Özel Dizayn'lı odaları."),"fiyat=10"); // Tablo Adı, Dizi içerisinde değerler, Where Komutu.
//////////////// Güncelle //////////////////

$sonuc = $vt->sil("odalar","oda_id=20"); //Tablo Adı, Where Kısmı
/////////////// Silme //////////////////

*/
class resim{ 
	function upload($resimim,$adres="images/"){
					if ($resimim["size"]<1024*1024){
					if ($resimim["type"]=="image/jpeg" || $resimim["type"]=="image/png"){
					$dosya_adi=$resimim["name"];
					$uret=array("self","sy","yn","ny","selfyaz");
					$uzanti=substr($dosya_adi,-4,4);
					$sayi_tut=rand(1,10000);
					$yeni_ad=$adres.$uret[rand(0,4)].$sayi_tut.$uzanti;
					if (move_uploaded_file($resimim["tmp_name"],$yeni_ad)){
						echo 'Dosya başarıyla yüklendi.';
						return $yeni_ad;
					}else{
						echo 'Dosya Yüklenemedi!';
					}
				}else{
					echo 'Dosya yalnızca jpeg formatında olabilir!';
				}
			}else{			
				echo 'Dosya boyutu 1 Mb ı geçemez!';
			}
	}
	
	function dosya_upload($dosyam,$yol="dosyalar/"){
if(isset($dosyam)){
   $hata = $dosyam['error'];
   if($hata != 0) {
      echo 'Yüklenirken bir hata gerçekleşmiş.';
   } else {
      $boyut = $dosyam['size'];
      if($boyut > (1024*1024*3)){
         echo 'Dosya 3MB den büyük olamaz.';
      } else {
         $tip = $dosyam['type'];
         $isim = $dosyam['name'];
         $uzanti = explode('.', $isim);
         $uzanti = $uzanti[count($uzanti)-1];
		 
		 $dosya_adi=$dosyam['name'];
		 $uret=array("self","sy","yn","ny","selfyaz");
		 $sayi_tut=rand(1,10000);
		 $yeni_ad=$uret[rand(0,4)].$sayi_tut.".".$uzanti;
         if($tip != 'application/pdf' || $uzanti != 'pdf'  ) { // || $tip != 'application/msword' || $uzanti != 'doc' || $uzanti !='docx'
            echo 'Yanlızca PDF dosyaları gönderebilirsiniz.';
         } else {
            $dosya = $dosyam['tmp_name'];
            copy($dosya, $yol. $yeni_ad);
			// Database kaydı buradaolacak.
            echo 'Dosyanız upload edildi!';
			return $yol.$yeni_ad;
         }
      }
   }
}
}
	
}
?>