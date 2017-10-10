<?php include ("../_config.php"); ?>
<div>
<a onclick="makeClick(0);" href="http://www.soundcyborg.com" target="_blank" ><img class="sponsor" src="<?php echo SITE_URL ?>img/logo.png" /></a>
<a href="soundcyborg.com" target="_blank" ><img class="sponsor" src="<?php echo SITE_URL ?>img/logo.png" /></a>



</div>
<div class="clear-fix">

<script>
function makeClick(id){
	$.ajax({
	   type: "POST",
	   url: SITE_URL+'actions/sponsor-click.php',
	   data:{id: id},
	   success:function(txt) {
	   }

	});
}

</script>