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
<!-- page content -->
        <div class="right_col" role="main">
		<div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Çalışma Notları <small> GENEL </small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="?ayar=4">4 Kayıt</a>
                        </li>
                        <li><a href="?ayar=6">6 Kayıt</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <ul class="list-unstyled timeline">
					<?php 
		include_once("selfyazilim.php"); 
		$vt = new veritabani();  
		$sorgum = $vt->listele("calisma");
		$kayitsayisi = $sorgum->rowCount();
		$lim = isset($_GET['ayar']) ? $_GET['ayar'] : 3;
		$ofset = isset($_GET['syf']) ? $_GET['syf'] : 0;
		$sorgu = $vt->listele("calisma","ORDER BY id DESC LIMIT ".$lim." OFFSET ".$ofset."");
		if($sorgu != null) foreach( $sorgu as $satir ) {
		?>
					<li>
                      <div class="block">
                        <div class="tags">
                          <a href="" class="tag">
                            <span><?php
							$sk = $vt->listele("kategori","WHERE id=".$satir['kategori']."");
		if($sk != null){ foreach( $sk as $kat ) { 
		echo $kat['adi'];}}
			else
			{
				echo "NULL";
			}	?> </span>
                          </a>
                        </div>
                        <div class="block_content">
                          <h2 class="title">
                                          <a><?php echo $satir['konu']; ?></a>
                                      </h2>
                          <div class="byline">
                            <span><?php echo $satir['tarih']; ?></span> BY <a><?php
							$kl = $vt->listele("kullanici","WHERE id=".$satir['kullanici']."");
		if($kl != null){ foreach( $kl as $kat ) { 
		echo $kat['kuladi'];}}
			else
			{
				echo "NULL";
			}	?></a>
                          </div>
                            <p class="excerpt"><?php echo $satir['icerik']; ?> <br><b><a> <span class="glyphicon glyphicon-search"></span> Devamını Göster </a></b>
                          </p>
                        </div>
                      </div>
                    </li>
					 <?php } ?>
                  </ul>
				  <?php 
			  if ($kayitsayisi > $lim) {
				  echo '<center><nav aria-label="Page navigation">
  <ul class="pagination">
    ';
    $x = 0;
    for ($i = 0; $i < $kayitsayisi; $i += $lim) {
        $x++;
		echo '<li><a href="?syf='.$i.'">'.$x.'</a></li>';
    }
	echo '
  </ul>
</nav></center>';
	
}
			  ?>
                </div>			
              </div>
            </div>
		<div class="col-md-6 col-sm-6 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><h2> Muhasebe Verileri</h2></h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                <center><?php
                    $gdrtoplam = 0; $glrtoplam=0; $kar=0; $zarar=0;
                    $sorgugider = $vt->ozellistele("SELECT SUM(tutar) AS toplamgider FROM gider");
                    if($sorgugider != null) foreach( $sorgugider as $gdr ) {
                        $gdrtoplam = $gdr['toplamgider'];
                    }
                    $sorgugelir = $vt->ozellistele("SELECT SUM(tutar) AS toplamgelir FROM gelir");
                    if($sorgugelir != null) foreach( $sorgugelir as $glr ) {
                        $glrtoplam = $glr['toplamgelir'];
                    }

                    $degson = $glrtoplam - $gdrtoplam;

                    ?>
                    <button class="btn btn-success col-lg-10" type="button">
                        Toplam Gelir <span class="badge"><?php echo $glrtoplam; ?> ₺</span>
                    </button>
                    <button class="btn btn-danger col-lg-10" type="button">
                        Toplam Gider <span class="badge"><?php echo $gdrtoplam; ?> ₺</span>
                    </button>
                        <?php
                        if($degson>0)
                        {
                            $kar = $degson;
                            echo '<button class="btn btn-info col-lg-10" type="button">
                Kâr <span class="badge">'. $kar .' ₺</span>
            </button>';
                        }
                        else if($degson<0)
                        {
                            $zarar = $degson;
                            echo '<button class="btn btn-warning col-lg-10" type="button">
                Zarar <span class="badge">'. $zarar .' ₺</span>
            </button>';
                        }
                        else
                        {
                            $karzarar = "Herhangi Bir Kâr veya Zarar Bulunmuyor.";
                            echo '<button class="btn btn-primary col-lg-10" type="button">
                 <span class="badge">'. $karzarar .' </span>
            </button>';
                        }
                        ?></center>
                </div>
            </div>
		</div>
		</div>
<?php
include('footer.php');
}
?>