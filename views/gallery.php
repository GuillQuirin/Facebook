<?php 
	if(!empty($listParticipation)): 
		?>
		<select name="sort">
			<option value="0" selected>Random</option>
			<option value="1">Date d'ajout</option>
			<option value="2">Tri par like</option>
		</select>
		<input type="hidden" id="url" value="<?php echo __URI__; ?>">
		<div class="row" id="gallery">
		
		</div>
		<!-- Pagination -->
		<nav aria-label="Page navigation">
		  <ul class="pagination">
		    <li>
		      <a href="#" aria-label="Previous">
		        <span aria-hidden="true">&laquo;</span>
		      </a>
		    </li>
		    <li><a href="#">1</a></li>
		    <li><a href="#">2</a></li>
		    <li><a href="#">3</a></li>
		    <li><a href="#">4</a></li>
		    <li><a href="#">5</a></li>
		    <li>
		      <a href="#" aria-label="Next">
		        <span aria-hidden="true">&raquo;</span>
		      </a>
		    </li>
		  </ul>
		</nav>
<?php else: ?>
	<h3>Soyez le premier participant au concours !</h3>
	<h5>Pour vous inscrire, accèder <a href="<?php echo WEBPATH.'/index'; ?>">ici</a></h5>
<?php endif; ?>

