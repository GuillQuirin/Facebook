<ul class="nav nav-tabs nav-justified">
	<li class="active"><a data-toggle="tab" href="#choose">Sélection d'un design</a></li>
	<li><a data-toggle="tab" href="#create">Création d'un design</a></li>
</ul>

<div class="tab-content">
	<div id="choose" class="tab-pane fade in active">
		<div class="container" id="design">
			<div class="col-sm-6">
				<h2 class="text-uppercase"> Selection d'un design existant </h2>
				<form>
					<div class="input-group">
						<select class="form-control" name="designExist" id="designExist">
							<?php foreach ($listDesign as $key => $design) { ?>
							<option value="<?php echo $design->getId_design();?>"><?php echo $design->getName(); ?></option>
							<?php } ?>                            
						</select>
						<span class="input-group-btn">
							<button type="submit" id="applyTemplate" class="btn btn-success">Appliquer le design</button>
						</span>
					</div><br>
				</form>
			</div>
			<div class="col-sm-5 col-sd-offset-1">
				<h2 class="text-uppercase">Aperçu</h2>
				<div class="col-md-12 apercu" id="apercu"><br>
					<h2 class="text-uppercase"> Création d'un design </h2>
					<div class="form-group">
						<label for="name">Nom du design :</label>
						<input type="text" class="form-control" name="name" id="name" placeholder="" required>
					</div>
					<div class="form-group padding-top-10">
						<label for="url">URL de l'image de fond :</label>
						<input type="text" class="form-control" name="url" id="url" placeholder="" required>
					</div>
					<div class="form-group padding-top-10">
						<label for="fontSize">Taille de la police :</label>
						<input type="number" class="form-control" name="fontSize" id="fontSize" step="1" min="12" max="16" required>
					</div> 
					<div class="form-group padding-top-10">
						<label for="fontStyle">Police du texte :</label>
						<select class="form-control" name="fontStyle" id="fontStyle" required>
							<option value="">Arial</option>                               
						</select>
					</div><br>
				</div>
			</div>
		</div>
	</div>
	<div id="create" class="tab-pane fade">
		<form>
			<h2 class="text-uppercase"> Création d'un design </h2>
			<div class="form-group col-sm-12">
				<label for="name">Nom du design :</label>
				<input type="text" class="form-control" name="name" id="name" required>
			</div>
			<div class="form-group col-sm-5 padding-top-10">
				<label for="url">URL de l'image de fond :</label>
				<input type="text" class="form-control" name="url" id="url" >
			</div>
			<div class="col-sm-2 no-padding text-center padding-top-20">
				<h3 class="no-margin">OU</h3>
			</div>
			<div class="form-group col-sm-5 padding-top-10">
				<label for="color">Couleur du fond :</label>
				<input type="text" class="jscolor {hash:true} form-control" name="color" id="color" placeholder="#">
			</div>
			<div class="form-group col-sm-5 padding-top-10">
				<label for="fontColor">Couleur de la police :</label>
				<input type="text" class="jscolor {hash:true} form-control" name="fontColor" id="fontColor" required>
			</div>
			<div class="form-group col-sm-5 col-sm-offset-2 padding-top-10">
				<label for="fontColorForm">Couleur des champs du formulaire :</label>
				<input type="text" class="jscolor {hash:true} form-control" name="fontColorForm" id="fontColorForm" required>
			</div>
			<div class="form-group col-sm-5 padding-top-10">
				<label for="fontSize">Taille de la police :</label>
				<input type="number" class="form-control" name="fontSize" id="fontSize" step="1" min="12" max="16" required>
			</div> 
			<div id="hsvflat"></div>
			<div class="form-group col-sm-5 col-sm-offset-2 padding-top-10">
				<label for="fontStyle">Style de la police du texte :</label>
				<select class="form-control" name="fontStyle" id="fontStyle" required>
					<option value="Arial">Arial</option>
					<option value="Arial, sans serif">Arial, sans serif</option> 
					<option value="Comic Sans MS">Comic Sans MS</option> 
					<option value="Courier New">Courier New</option> 
					<option value="Helvetica">Helvetica</option>
					<option value="Helvetica, sans serif">Helvetica, sans serif</option> 
					<option value="Impact">Impact</option>                               
				</select>
			</div>
			<div class="col-sm-12 padding-top-20">
				<button type="submit" id="changeDesign" class="btn btn-success">Appliquer le design</button>
				<button type="submit" id="saveTemplate" class="btn btn-success">Enregistrer sous un nouveau template</button>
			</div>
		</form>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('select[name="designExist"]').change(function () {
			$.ajax({
				url: 'design/getDesign',
				method: 'POST',
				data: {id_design: $(this).val()},
				success: function (data) {
					var listDesign = JSON.parse(data);
					$("#name").val(listDesign[0].name);
					$("#url").val(listDesign[0].background_url);
					$("#color").val(listDesign[0].background_color);
					$("#fontColor").val(listDesign[0].text_color);
					$("#fontColorForm").val(listDesign[0].form_color);
					$("#fontSize").val(listDesign[0].font_size);
					$("#fontStyle").val(listDesign[0].font_name);
					$("#apercu").css("backgroundColor", listDesign[0].background_color);
					$("#apercu").css("color", listDesign[0].text_color);
					$("#apercu").css("fontSize", listDesign[0].font_size);
					$("#apercu").css("fontFamily", listDesign[0].font_name);
					$("#apercu").css("background-image", 'url(' + listDesign[0].background_url + ')');
					$("#apercu").find("input").css("backgroundColor", listDesign[0].form_color);
					$("#apercu").find("select").css("backgroundColor", listDesign[0].form_color);
				}
			});
		});

		$('#saveTemplate').click(function(){
			var f = document.getElementsByTagName('form')[0];
			if(f.checkValidity()) {   
				$.ajax({
					method: "POST",
					url: $('[name="webpath"]').val()+"/design/addDesign",
					data: {
						name: $("#name").val(),
						background_url: $("#url").val(),
						background_color: $("#color").val(),
						text_color: $("#fontColor").val(),
						form_color: $("#fontColorForm").val(),
						font_size: $("#fontSize").val(),
						font_name : $("#fontStyle").val()
					}
				})
				.done(function( msg ) {
					location.reload();
				});
			}
		});

		$('#applyTemplate').click(function(){
			$.ajax({
				method: "POST",
				url: $('[name="webpath"]').val()+"/design/applyDesign",
				data: {id_design: $("#designExist").val()
			}
		})
			.done(function( msg ) {
				location.reload();
			});
		});
	});
</script>
