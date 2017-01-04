<div class="container">
 	<div class="form-group">
      	<h1 class="text-uppercase">Règlement du concours : </h1>
      	<div class="summernote" id="regulation"><?php echo $listSetting[1]->getValue();?></div>
      	<button type="submit" id="saveRegulation" class="btn btn-success">Sauvegarder le règlement</button>
    </div><br>
    <div class="form-group">
      	<h1 class="text-uppercase">Conditions Générales d'Utilisation : </h1>
      	<div class="summernote"><?php echo $listSetting[0]->getValue();?></div>
      	<button type="submit" id="saveCGU" class="btn btn-success">Sauvegarder les CGU</button>
    </div>
</div>
<script>
	$('.summernote').summernote({
      height: 200,                 // set editor height
      minHeight: null,             // set minimum height of editor
      maxHeight: null,             // set maximum height of editor
      focus: true 
    }); 

    $('#saveRegulation').click(function(){
				$.ajax({
					method: "POST",
					url: $('[name="webpath"]').val()+"/setting/saveRegulation",
					data: {
						regulation: $('#regulation').summernote('code'),
						id_setting: <?php echo $listSetting[1]->getId_setting();?>
					}
				})
				.done(function( msg ) {
					location.reload();
				});
		});
</script>