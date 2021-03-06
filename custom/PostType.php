<?php

namespace cw\wp\custom;

class PostType{
  use traits\Settings;
  use posttype\traits\Labels;
  use posttype\traits\MenuPosition;
  use posttype\traits\Supports;
  use posttype\traits\Type;

  public $id;

  public $labels = [];

  public $args   = [
    'labels'             => [],
    'description'        => 'Description.',
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => ['slug' => 'todo' ],
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => []
  ];

  public function __construct($id){
    $this->id = $id;
  }

  public function hasArchive($set = true){
    $this->args['has_archive'] = $set;
    return $this;
  }

  public function addMetaBox(\cw\wp\custom\MetaBox $box){
    $box->screen($this->id);
    return $this;
  }

  public function getPosts($args=[]){
    return (new \cw\wp\custom\PostQuery($args))
              ->type($this->id);
  }

  public function publish(){
    $args           = $this->args;
    $args['labels'] = $this->labels;

    register_post_type($this->id, $args);
  }
}
