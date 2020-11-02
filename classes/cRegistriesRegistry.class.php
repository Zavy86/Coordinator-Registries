<?php
/**
 * Registries - Registry
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Registries Registry class
  */
 class cRegistriesRegistry extends cObject{

  /** Parameters */
  static protected $table="registries__registries";
  static protected $logs=true;

  /** Properties */
  protected $id;
  protected $deleted;
  protected $typology;
  protected $name;
  protected $fiscal;
  protected $vat;
  protected $url;
  protected $mail;
  protected $note;

  /**
   * Check
   *
   * @return boolean
   * @throws Exception
   */
  protected function check(){
   // check properties
   if(!in_array($this->typology,array_keys(static::availablesTypologies()))){throw new Exception("Registry typology is mandatory..");}
   if(!strlen(trim($this->name))){throw new Exception("Registry name is mandatory..");}
   // return
   return true;
  }

  /**
   * Availables Tipologies
   *
   * @return object[] Array of available typologies
   */
  public static function availablesTypologies(){
   return array(
    "private"=>(object)array("code"=>"private","text"=>api_text("cRegistriesRegistry-typology-private"),"icon"=>api_icon("fa-user",api_text("cRegistriesRegistry-typology-private"))),
    "freelance"=>(object)array("code"=>"freelance","text"=>api_text("cRegistriesRegistry-typology-freelance"),"icon"=>api_icon("fa-graduation-cap",api_text("cRegistriesRegistry-typology-freelance"))),
    "company"=>(object)array("code"=>"company","text"=>api_text("cRegistriesRegistry-typology-company"),"icon"=>api_icon("fa-building-o",api_text("cRegistriesRegistry-typology-company"))),
    "public"=>(object)array("code"=>"public","text"=>api_text("cRegistriesRegistry-typology-public"),"icon"=>api_icon("fa-institution",api_text("cRegistriesRegistry-typology-public")))
   );
  }

  /**
   * Get Typology Label
   *
   * @param boolean $show_text Show text
   * @param boolean $show_icon Show icon
   * @param boolean $icon_position Icon position [left|right]
   * @return string|false Role label
   */
  public function getTypologyLabel($show_text=true,$show_icon=true,$icon_position="left"){
   if(!$this->exists()){return false;}
   if(!in_array($icon_position,["left","right"])){$icon_position="left";}
   $typology=static::availablesTypologies()[$this->typology];
   // make label
   if($show_text && $show_icon){
    if($icon_position=="left"){$label=$typology->icon." ".$typology->text;}
    else{$label=$typology->text." ".$typology->icon;}}
   elseif($show_text){$label=$typology->text;}
   elseif($show_icon){$label=$typology->icon;}
   // return
   return $label;
  }

  /**
   * Get Roles
   *
   * @return object[]|false Array of roles objects or false
   */
  public function getRoles(){return api_sortObjectsArray($this->joined_select("registries__registries__join__roles","fkRegistry","cRegistriesRole","fkRole"),"name");}


  /**
   * Get Documents
   *
   * @return object[]|false Array of document objects or false
   */
  public function getDocuments(){return api_sortObjectsArray(cArchiveDocument::availables(true,["fkRegistry"=>$this->id]),"timestamp",true);}

  /**
   * Edit form
   *
   * @param string[] $additional_parameters Array of url additional parameters
   * @return object Form structure
   */
  public function form_edit(array $additional_parameters=null){
   // build form
   $form=new strForm(api_url(array_merge(["mod"=>"registries","scr"=>"controller","act"=>"store","obj"=>"cRegistriesRegistry","idRegistry"=>$this->id],$additional_parameters)),"POST",null,null,"registries_registry_edit_form");
   // fields
   $form->addField("select","typology",api_text("cRegistriesRegistry-property-typology"),$this->typology,api_text("cRegistriesRegistry-placeholder-typology"),null,null,null,"required");
   foreach(cRegistriesRegistry::availablesTypologies() as $typology_fobj){$form->addFieldOption($typology_fobj->code,$typology_fobj->text);}
   $form->addField("text","name",api_text("cRegistriesRegistry-property-name"),$this->name,api_text("cRegistriesRegistry-placeholder-name"),null,null,null,"required");
   $form->addField("text","fiscal",api_text("cRegistriesRegistry-property-fiscal"),$this->fiscal,api_text("cRegistriesRegistry-placeholder-fiscal"));
   $form->addField("text","vat",api_text("cRegistriesRegistry-property-vat"),$this->vat,api_text("cRegistriesRegistry-placeholder-vat"));
   $form->addField("text","url",api_text("cRegistriesRegistry-property-url"),$this->url,api_text("cRegistriesRegistry-placeholder-url"));
   $form->addField("email","mail",api_text("cRegistriesRegistry-property-mail"),$this->mail,api_text("cRegistriesRegistry-placeholder-mail"));
   $form->addField("textarea","note",api_text("cRegistriesRegistry-property-note"),$this->note,api_text("cRegistriesRegistry-placeholder-note"),null,null,null,"rows='2'");
   $form->addField("checkbox","roles[]",api_text("cRegistriesRegistry-property-roles"),array_keys($this->getRoles()));
   foreach(api_sortObjectsArray(cRegistriesRole::availables(true),"name") as $role_fobj){$form->addFieldOption($role_fobj->id,$role_fobj->getLabel(true,false));}
   // controls
   $form->addControl("submit",api_text("form-fc-submit"));
   // return
   return $form;
  }

  /**
   * Store
   *
   * {@inheritdoc}
   */
  public function store(array $properties,$log=true){
   $result=parent::store($properties,$log);
   if(!$result){return false;}
   // reset tags
   $this->joined_reset("registries__registries__join__roles","fkRegistry","roles_resetted",false);
   // check for array
   if(!is_array($properties["roles"])){return;}
   // cycle all tags
   foreach($properties["roles"] as $role_f){
    // get object
    $role_obj=new cRegistriesRole($role_f);
    // check object
    if(!$role_obj->id){continue;}
    // add tag to task
    $this->joined_add("registries__registries__join__roles","fkRegistry","cRegistriesRole","fkRole",$role_obj,"role_added",false);
   }
   // return
   return true;
  }

  // Disable remove function
  public function remove(){throw new Exception("Registry remove function disabled by developer..");}

  // debug
  //protected function event_triggered($event){api_dump($event,static::class." event triggered");}

 }

?>