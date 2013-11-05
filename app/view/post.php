<?php

	foreach($data as $post){
?>	
	
	<article>
		<h1><?php echo $post['title']; ?></h1>
			<span style="font-size: 0.7em"><?php echo $post['date']; ?></span>
		<p>
			<?php echo $post['author']; ?><br/>
			<?php echo $post['content']; ?>
		</p>
	</article>

<?php
	}

 ?>