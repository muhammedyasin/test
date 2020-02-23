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
		<div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
				<h3> <input class="btn btn-sm btn-success btn-block" type="button" name="yeniekle" value="Yeni Not Ekle" data-toggle="modal" data-target="#yeniekle"> </h3>
                  		<?php 
		include_once("selfyazilim.php"); 
		$vt = new veritabani();  
		$sorgu = $vt->listele("calisma","WHERE kullanici=".$_SESSION['kid']."ORDER BY id DESC ");
		if($sorgu != null) foreach( $sorgu as $satir ) {
		?><h2>Çalışma Notları <small></small></h2>		<?php break; } ?>
                  <ul class="nav navbar-right panel_toolbox">
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <ul class="list-unstyled timeline">
		<?php  
		$sorgum = $vt->listele("calisma","WHERE kullanici=".$_SESSION['kid']."");
		$kayitsayisi = $sorgum->rowCount();
		$lim = 4;
		$ofset = isset($_GET['syf']) ? $_GET['syf'] : 0;
		$sorgu = $vt->listele("calisma","WHERE kullanici=".$_SESSION['kid']." ORDER BY id DESC LIMIT ".$lim." OFFSET ".$ofset."");
		if($sorgu != null) foreach( $sorgu as $satir ) {
		?>
					<li>
                      <div class="block">
                        <div class="tags">
                          <a href="" class="tag">
                            <span>
							<?php
							$sk = $vt->listele("kategori","WHERE id=".$satir['kategori']."");
		if($sk != null){ foreach( $sk as $kat ) { 
		echo $kat['adi'];}}
			else
			{
				echo "NULL";
			}	?>                               
							</span>
                          </a>
                        </div>
                        <div class="block_content">
                          <h2 class="title">
                                          <a><?php echo $satir['konu']; ?></a>
                                      </h2>
                          <div class="byline">
                            <span><?php echo $satir['tarih']; ?></span> BY <a><?php echo " ".$satir['kullanici']; ?></a>
                          </div>
                          <p class="excerpt"><?php echo $satir['icerik']; ?> <a>Devamını Göster</a>
                          </p>
                        </div>
                      </div>
                    </li>
				<?php } ?>
                  </ul>
				  
		 <?php 
			  if ($kayitsayisi > $lim) {
				  echo '<center><nav aria-label="Page navigation">
  <ul class="pagination">';
    $x = 0;
    echo '<li><a href="?syf='.$x.'"> <span class="glyphicon glyphicon-backward"></span> </a></li>';
    for ($i = 0; $i < $kayitsayisi; $i += $lim) {
        $x++;
		echo '<li><a href="?syf='.$i.'">'.$x.'</a></li>';
    }
    echo '<li><a href="?syf='.($i-$lim).'"> <span class="glyphicon glyphicon-forward"></span> </a></li>';
	echo '
  </ul>
</nav></center>';
	
}
			  ?>
                </div>
              </div>
            </div>
		</div>
		<!-- Ekleme Modal -->
<div class="modal fade" id="yeniekle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Yeni Not Ekle</h4>
      </div>
	  <?php if(@$_POST['olustur']){
		  
		  echo "<span class='bg-info'>Başarıyla Kaydedildi.</span>";
		  $baslik = $_POST['baslik'];
		  $ktgri = $_POST['kat'];
		  $icrk = $_POST['icerik'];
		  $kullanici = $_SESSION['kid'];
		  $sonuc = $vt->ekle("calisma",array("kullanici"=>$kullanici,"konu"=>$baslik,"kategori"=>$ktgri,"icerik"=>$icrk,"ek"=>"YOK"));
			
			echo '<script>
$("#myModal").modal();
</script>';
	  }
	  ?>
	  <form action="" method="POST" >
      <div class="modal-body">
        <div class="form-group">
            <label for="recipient-name" class="control-label">Başlık:</label>
            <input type="text" class="form-control" name="baslik">
          </div>
		   <div class="form-group">
            <label for="recipient-name" class="control-label">Kategori:</label>
            <select class="form-control" name="kat">
			<?php  
		$sk = $vt->listele("kategori");
		if($sk != null) foreach( $sk as $kat ) {
		?>
			<option value="<?php echo $kat['id']; ?>"> <?php echo $kat['adi']; ?> </option>
		<?php } ?>
			</select>
          </div>
		   <div class="form-group">
            <label for="recipient-name" class="control-label">İçerik:</label>
            <textarea class="form-control" name="icerik"> </textarea>
          </div>
	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">İptal</button>
        <input type="submit" name="olustur" class="btn btn-primary" value="Not Oluştur">
		</form>
      </div>
    </div>
  </div>
</div>
<!-- Ekleme Modal End -->
<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<?php
include('footer.php');
}
?>