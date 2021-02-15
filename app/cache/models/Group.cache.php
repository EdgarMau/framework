<?php
return array("#tableName"=>"group","#primaryKeys"=>["id"=>"id"],"#manyToOne"=>["organization"],"#fieldNames"=>["id"=>"id","name"=>"name","email"=>"email","aliases"=>"aliases","organization"=>"idOrganization","users"=>"users"],"#memberNames"=>["id"=>"id","name"=>"name","email"=>"email","aliases"=>"aliases","idOrganization"=>"organization","users"=>"users"],"#fieldTypes"=>["id"=>"int(11)","name"=>"varchar(65)","email"=>"varchar(255)","aliases"=>"mediumtext","organization"=>"","users"=>"mixed"],"#nullable"=>["name","email","aliases"],"#notSerializable"=>["organization","users"],"#transformers"=>[],"#accessors"=>["id"=>"setId","name"=>"setName","email"=>"setEmail","aliases"=>"setAliases","idOrganization"=>"setOrganization","users"=>"setUsers"],"#manyToMany"=>["users"=>["targetEntity"=>"models\\User","inversedBy"=>"groups"]],"#joinTable"=>["users"=>["name"=>"groupusers"]],"#joinColumn"=>["organization"=>["className"=>"models\\Organization","name"=>"idOrganization"]],"#invertedJoinColumn"=>["idOrganization"=>["member"=>"organization","className"=>"models\\Organization"]]);