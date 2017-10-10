<?php include ("../_config.php"); 
session_start();
?>

<?php if($_SESSION['admin']==false){ ?>
	<h3>Admin Panel</h3>
	<?php 
	if ($_GET['msg'] == "baduser" ) echo "<p class='error'>Usuario no encontrado</p>";
	if ($_GET['msg'] == "captcha" ) echo "<p class='error'>Hubo un error en el Captcha. Int&eacute;ntelo de nuevo.</p>";
	?>
	<form id="form" action="<?php echo SITE_URL ?>actions/admin-login.php" method="post">
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="email">Email address</label></div>
			<div class="col-md-4"><input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required></div>
			<div class="col-md-6"></div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="password">Password</label></div>
			<div class="col-md-4"><input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required></div>
			<div class="col-md-6"></div>
		</div>
		<div class="form-group col-md-12">
			<div class="col-md-2"><label for="captcha">Captcha</label></div>
			<div class="col-md-2"><input type="text" class="form-control" id="captcha" name="captcha" placeholder="Ingresa el captcha" required></div>
			<div class="col-md-2"><img src="<?php echo SITE_URL ?>actions/captcha.php"  /></div>
			<div class="col-md-6"></div>
		</div>
		<button type="submit" class="btn btn-primary">Sign In</button>
	</form>
	<script type="text/javascript">
		$("#form").validate();
	</script>

<?php }else{ 
echo "<a href='' onclick='runPostsCleanup();' >Run Posts Cleanup!</a>";
echo "<h4>POSTS LIST</h4>";
echo "<a href='".SITE_URL."admin?list=active' >Active Posts </a><a href='".SITE_URL."admin?list=inactive' >Inactive Posts </a>";
$posts = new Posts();
$array = $posts->getAllPosts();
$list = $_GET['list'];

if (sizeof($array)>0) {
				echo "<ul class='post-list'>";
				for ($i=0;$i<sizeof($array);$i++){
					if (($list == "active" && $array[$i]['active']=="1")||($list == "inactive" && $array[$i]['active']==0)|| !isset($_GET['list'])){
						echo "<li><h4>". $array[$i]["title"] . "</h4><p class='post-content'>" . $array[$i]["content"] ."</p> <p class='post-contact'>".$array[$i]['contact']."</p><p class='post-date'> ".$array[$i]["day"]."</p><p>Active = ".$array[$i]['active']."</p><p><a class='js-links' href='' onclick='togglePost(".$array[$i]['id'].")'>Toggle</a></p></li>";
					}
				}
				echo "</ul>";
			}else{
				echo "<p>No hay resultados.</p>";
			}

	} ?>
<script type="text/javascript">
$('.js-links').click(function(e) { 
	e.preventDefault(); 
});
function togglePost(num){
	$.ajax({
       type: "POST",
       url: SITE_URL+'actions/toggle-post.php',
       data:{id: num},
       success:function(txt) {
       		window.location.reload();
       }

  	});
}	
function deletePost(num){
	var accept = confirm("Seguro que desea eliminar este post?");
	if (accept){
		$.ajax({
	       type: "POST",
	       url: SITE_URL+'actions/delete-post.php',
	       data:{id: num},
	       success:function(txt) {
	       		window.location.reload();
	       }

	  	});
	}
}
function runPostsCleanup(){
	$.ajax({
       type: "POST",
       url: SITE_URL+'actions/admin-posts-cleanup.php',
       success:function(txt) {
       		alert("Se eliminaron "+txt+" avisos.");
       		window.location.reload();
       }

  	});
}

</script>

