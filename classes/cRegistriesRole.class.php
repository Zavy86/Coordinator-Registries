<?php
/**
 * Registries - Role
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 /**
  * Registries Role class
  */
 class cRegistriesRole extends cObject{

  /** Parameters */
  static protected $table="registries__roles";
  static protected $logs=false;

  /** Properties */
  protected $id;
  protected $deleted;
  protected $name;
  protected $title;
  protected $icon;

  /**
   * Check
   *
   * @return boolean
   * @throws Exception
   */
  protected function check(){
   // check properties
   if(!strlen(trim($this->name))){throw new Exception("Role name is mandatory..");}
   if(!strlen(trim($this->icon))){throw new Exception("Role icon is mandatory..");}
   // return
   return true;
  }

  /**
   * Get Label
   *
   * @param boolean $show_title Show title
   * @param boolean $show_icon Show icon
   * @param boolean $icon_position Icon position [left|right]
   * @return string|false Role label
   */
  public function getLabel($show_title=true,$show_icon=true,$icon_position="left"){
   if(!$this->exists()){return false;}
   if(!in_array($icon_position,["left","right"])){$icon_position="left";}
   // make label
   $label=$this->name;
   if($show_title && $this->title){$label.=" (".$this->title.")";}
   if($show_icon){if($icon_position=="left"){$label=$this->getIcon()." ".$label;}else{$label=$label." ".$this->getIcon();}}
   // return
   return $label;
  }

  /**
   * Get Icon
   *
   * @return string|false Role icon
   */
  public function getIcon(){
   if(!$this->exists()){return false;}
   return api_icon($this->icon,$this->getLabel(true,false));
  }

  /**
   * Get Registries
   *
   * @return objects[] Registries array
   */
  public function getRegistries(){return api_sortObjectsArray($this->joined_select("registries__registries__join__roles","fkRole","cRegistriesRegistry","fkRegistry"),"name");}

  /**
   * Edit form
   *
   * @param string[] $additional_parameters Array of url additional parameters
   * @return object Form structure
   */
  public function form_edit(array $additional_parameters=null){
   // build form
   $form=new strForm(api_url(array_merge(["mod"=>"registries","scr"=>"controller","act"=>"store","obj"=>"cRegistriesRole","idRole"=>$this->id],$additional_parameters)),"POST",null,null,"registries_role_edit_form");
   // fields
   $form->addField("text","name",api_text("cRegistriesRole-property-name"),$this->name,api_text("cRegistriesRole-placeholder-name"),null,null,null,"required");
   $form->addField("text","title",api_text("cRegistriesRole-property-title"),$this->title,api_text("cRegistriesRole-placeholder-title"));
   $form->addField("text","icon",api_text("cRegistriesRole-property-icon"),$this->icon,null,null,null,null,"required autocomplete='off'");
   // controls
   $form->addControl("submit",api_text("form-fc-submit"));
   // return
   return $form;
  }

  /**
   * Remove
   *
   * @return boolean|exception
   */
  public function remove(){
   // check if role is empty
   if(count($this->getRegistries())){
    // exception if not empty
    throw new Exception("Role remove function denied if not empty..");
   }else{
    // remove role
    return parent::remove();
   }
  }

  // debug
  //protected function event_triggered($event){api_dump($event,static::class." event triggered");}

 }

?>