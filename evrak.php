<?php 
ob_start();
session_start();
if(empty($_SESSION['yetki']))
{
	 header('Location: index.php');
}
else
{
if (isset($_SESSION['yetki'])) {
    if ($_SESSION['yetki'] == 1 || $_SESSION['yetki'] == 2 ) {
		include 'header.php';
    }
} else {
    header('Location: index.php');
    exit();
}
?>
<title> Çalışma Masası | Self Yazılım </title>
<!-- page content -->
        <div class="right_col" role="main">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Dosya İsimi Giriniz.." name="isim" />
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" name="dosya" />
                </div>
<div class="form-group">
    <input type="submit" class="btn btn-block btn-success" name="yukle" value="Dosya Yükle" />
</div>

</form>
<?php 

$resim = new resim();
$vt = new veritabani();
if(@$_POST['yukle']) {
    $dosyaadi = $_POST['isim'];
    $dosya = @$_FILES["dosya"];//resim çekme.
    $dosyaekle = $resim->dosya_upload($dosya);
    $sonuc = $vt->ekle("dosyalar", array("ekleyenID" => $_SESSION['kid'], "dosyaadi" => $dosyaadi, "dosyayolu" => $dosyaekle));
    if($sonuc>0)
        echo "<br>Başarılı Ekleme.";
}

?>
<div class="row">
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Evrak Dosyası</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="row">

                    <p>Genel olarak kullanılan evrak ve dosyaları buradan görebilirsiniz.</p>
    <?php
    $evraksorgu = $vt->listele("dosyalar");
    if($evraksorgu != null) foreach( $evraksorgu as $evrak ) {

        ?>

                    <div class="col-md-55">
                        <div class="thumbnail">
                            <div class="image view view-first">
                                <img style="width: 100%; display: block;" src="images/evrak.jpg" alt="image" />
                                <div class="mask">
                                    <p><?php echo $evrak['dosyaadi']; ?></p>
                                    <div class="tools tools-bottom">
                                        <a href="<?php echo $evrak['dosyayolu']; ?>" download><i class="fa fa-download"></i></a>
                                        <a href="?sil=<?php echo $evrak['ID']; ?>&yol=<?php echo $evrak['dosyayolu']; ?>"><i class="fa fa-times"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="caption">
                                <p><?php echo $evrak['dosyaadi']; ?><br><center> <label class="badge-important" style="text-align: left;"><?php echo $evrak['tarih']; ?></label></center> <br><br></p>
                            </div>
                        </div>
                    </div>
        <?php
    }
    ?>
                    <?php
                    if($_GET)
                    {
                        $idim = $_GET['sil'];
                        $yol = $_GET['yol'];
                        $sonuc = $vt->sil("dosyalar","ID=".$idim);
                        unlink($yol);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
		</div>
<!-- Ekleme Modal End -->
<?php
include('footer.php');
}
?>