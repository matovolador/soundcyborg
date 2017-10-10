<?php include ("../_config.php"); 

$str = "";
$str = $_GET['search'];
$posts = new Posts();
if ($str == ""){
	$array = $posts->getSortedPosts();
}else{
	$str = str_replace("+", " ", $str);
	$array = $posts->searchPosts($str);	

}
if (!isset($_GET['page'])|| $_GET['page']<1) {
	$page = 1;
}else{
	$page = $_GET['page'];
}
if (!is_numeric($page)) $page = 1;


?>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-34011285-2', 'auto');
  ga('send', 'pageview');

</script>
<div class="row">
	<div class="col-sm-12 col-md-8">
		<h2>Avisos</h2>
		<p><a href="<?php echo SITE_URL?>publicar">Publica tu aviso</a> o busca en los avisos disponibles para encontrar m&uacute;sicos en Uruguay.</p>
	</div>
	<div class="col-sm-12 col-md-4">
		<form id="form" action="<?php echo SITE_URL ?>buscar.php" method="get">
        	<div class="input-group">
          		<input type="text" class="form-control" name="search" id="search" placeholder="Buscar">
        	
        	<span class="input-group-btn"><button type="submit" class="btn btn-default">Buscar</button></span>
        	</div>
      	</form>
    </div>

</div>
<div class="col-sm-12 col-md-12 ad">
		
		<!-- scyborg 1 -->
		<ins class="adsbygoogle"
		     style="display:block"
		     data-ad-client="ca-pub-8873123515716032"
		     data-ad-slot="6768618920"
		     data-ad-format="auto"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
	</div>
<div class="clear-fix"></div>
<div class="row">
	<div class="col-sm-12 col-md-12">
	<script type="text/javascript">
		$("#form").validate();
	</script>
		<?php
		if ($str == ""){

			if (sizeof($array)>0) {
				$numPages = 0;
				
				for ($h=0;$h<(sizeof($array))/10;$h++){
					$numPages ++;
				}
				
				$postcount = $page *10 - 10;
				$limit = 10*$page;
				if (sizeof($array)<$limit ){
					$limit = sizeof($array);
				}


				//Muestra paginado:
				if ($numPages > 1){
					echo "<div>P&aacute;ginas: ";
					for ($i=1;$i<=$numPages;$i++){
						if ($i == $page){
							echo "<a class='pages strong' href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";	
						}else{
							echo "<a class='pages'href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";
						}
					}
					echo "</div>";
				}
				////

				//Muestra avisos de la pagina
				echo "<ul class='post-list'>";
				for ($i=0 + $postcount;$i<$limit;$i++){
					$date = new DateTime($array[$i]['day']);
					$date = $date->format("Y-m-d");
					echo "<li><h4>". $array[$i]["title"] . "</h4><p class='post-content'>" . $array[$i]["content"] ."</p> <p class='post-contact'>".$array[$i]['contact']."</p><p class='post-date'> ".$date."</p></li>";
						
				}
				echo "</ul>";
				//Muestra paginado:
				if ($numPages > 1){
					echo "<div>P&aacute;ginas: ";
					for ($i=1;$i<=$numPages;$i++){
						if ($i == $page){
							echo "<a class='pages strong' href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";	
						}else{
							echo "<a class='pages' href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";
						}
					}
					echo "</div>";
				}
			}else{
				echo "<p>No hay resultados.</p>";
			}
		}else{
			if (sizeof($array)>0) {
				//Muestra paginado:
				if ($numPages > 1){
					echo "<div>P&aacute;ginas: ";
					for ($i=1;$i<=$numPages;$i++){
						if ($i == $page){
							echo "<a class='pages strong' href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";	
						}else{
							echo "<a class='pages' href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";
						}
					}
					echo "</div>";
				}


				echo "<ul class='post-list'>";
				for ($i=0;$i<sizeof($array);$i++){
					$date = new DateTime($array[$i]['day']);
					$date = $date->format("Y-m-d");
					echo "<li><h4>". $array[$i]["title"] . "</h4><p class='post-content'>" . $array[$i]["content"] ."</p> <p class='post-contact'>".$array[$i]['contact']."</p><p class='post-date'> ".$date."</p></li>";
						
				}
				echo "</ul>";
				//Muestra paginado:
				if ($numPages > 1){
					echo "<div>P&aacute;ginas: ";
					for ($i=1;$i<=$numPages;$i++){
						if ($i == $page){
							echo "<a class='pages strong' href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";	
						}else{
							echo "<a class='pages' href='".SITE_URL."buscar?page=".$i."'>".$i." </a>";
						}
					}
					echo "</div>";
				}
				?>

		<?php	}else{
				echo "<p>No hay resultados.</p>";
			}
		}
		?>
	</ul>



	</div>


</div>