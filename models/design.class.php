<?php 
class design extends motherClass{
	protected $id_design = null;
	protected $name = null;
	protected $background_url = null;
	protected $background_color = null;
	protected $text_color = null;
	protected $form_color = null;
	protected $font_size = null;
	protected $font_name = null;
	protected $date_created=null;
	protected $date_updated=null;
	protected $deleted=null;
	protected $state=null;

	public function setId_design($v){$this->id_design=$v;}
	public function setName($v){$this->name=$v;}
	public function setBackground_color($v){$this->background_color=$v;}
	public function setBackground_url($v){$this->background_url=$v;}
	public function setText_color($v){$this->text_color=$v;}
	public function setForm_color($v){$this->form_color=$v;}
	public function setFont_size($v){$this->font_size=$v;}
	public function setFont_name($v){$this->font_name=$v;}
	public function setDate_created($v){$this->date_created=$v;}
	public function setDate_updated($v){$this->date_updated=$v;}
	public function setDeleted($v){$this->deleted=$v;}
	public function setState($v){$this->state=$v;}

	public function getId_design(){return $this->id_design;}
	public function getName(){return $this->name;}
	public function getBackground_color(){return $this->background_color;}
	public function getBackground_url(){return $this->background_url;}
	public function getText_color(){return $this->text_color;}
	public function getForm_color(){return $this->form_color;}
	public function getFont_size(){return $this->font_size;}
	public function getFont_name(){return $this->font_name;}
	public function getDate_created(){return $this->date_created;}
	public function getDate_updated(){return $this->date_updated;}
	public function getDeleted(){return $this->deleted;}
	public function getState(){return $this->state;}
}
