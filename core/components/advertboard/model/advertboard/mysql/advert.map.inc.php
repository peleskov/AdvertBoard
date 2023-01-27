<?php
$xpdo_meta_map['Advert']= array (
  'package' => 'advertboard',
  'version' => '1.1',
  'table' => 'advertboard',
  'extends' => 'xPDOSimpleObject',
  'tableMeta' => 
  array (
    'engine' => 'InnoDB',
  ),
  'fields' => 
  array (
    'created' => NULL,
    'updated' => NULL,
    'user_id' => NULL,
    'status' => 0,
    'pid' => NULL,
    'title' => NULL,
    'content' => NULL,
    'price' => 0.0,
    'old_price' => 0.0,
    'images' => '',
    'top' => 0,
    'hash' => NULL,
    'extended' => '',
  ),
  'fieldMeta' => 
  array (
    'created' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
    ),
    'updated' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => true,
    ),
    'user_id' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
    ),
    'status' => 
    array (
      'dbtype' => 'int',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'pid' => 
    array (
      'dbtype' => 'int',
      'precision' => '10',
      'phptype' => 'integer',
      'null' => false,
    ),
    'title' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '191',
      'phptype' => 'string',
      'null' => true,
      'index' => 'index',
    ),
    'content' => 
    array (
      'dbtype' => 'mediumtext',
      'phptype' => 'string',
      'null' => true,
      'index' => 'index',
    ),
    'price' => 
    array (
      'dbtype' => 'float',
      'phptype' => 'float',
      'null' => false,
      'default' => 0.0,
    ),
    'old_price' => 
    array (
      'dbtype' => 'float',
      'phptype' => 'float',
      'null' => false,
      'default' => 0.0,
    ),
    'images' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
    'top' => 
    array (
      'dbtype' => 'int',
      'precision' => '1',
      'phptype' => 'integer',
      'null' => false,
      'default' => 0,
    ),
    'hash' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '256',
      'phptype' => 'string',
      'null' => true,
    ),
    'extended' => 
    array (
      'dbtype' => 'text',
      'phptype' => 'string',
      'null' => false,
      'default' => '',
    ),
  ),
  'indexes' => 
  array (
    'user_id_IDX' => 
    array (
      'alias' => 'user_id_IDX',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'user_id' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'advert_title_IDX' => 
    array (
      'alias' => 'advert_title_IDX',
      'primary' => false,
      'unique' => false,
      'type' => 'FULLTEXT',
      'columns' => 
      array (
        'title' => 
        array (
          'length' => '',
          'collation' => '',
          'null' => true,
        ),
      ),
    ),
    'advert_content_IDX' => 
    array (
      'alias' => 'advert_content_IDX',
      'primary' => false,
      'unique' => false,
      'type' => 'FULLTEXT',
      'columns' => 
      array (
        'content' => 
        array (
          'length' => '',
          'collation' => '',
          'null' => true,
        ),
      ),
    ),
    'pid_IDX' => 
    array (
      'alias' => 'pid_IDX',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'pid' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
  ),
);
