Yuu LTE Form Booster
===========

Install new modul
-------------------------
* Colom in datatables     
  * label
    * ex : "label"=>"Name"
    * For the name label in html
  * name
    * ex :"name"=>"name"
    * for the name in ajax
  * dbcustom
    * ex : "dbcustom"=>true
    * if you custom field in not use database
  * Action
    * use : "label"=>"Action","name"=>"action","dbcustom"=>true
    * if you can using action "edit and delete"

```bash
  $this->col = array();
  $this->col[] = array("label"=>"Name","name"=>"name");#EXAMPLE
```

* Form Booster 	  
    * label
      * ex : "label"=>"Name"
      * For the name label in html
    * name
      * ex :"name"=>"name"
      * for the name and id in input html
    * dbcustom
      * ex : "dbcustom"=>true
      * if you custom field in not use database

```bash
  $this->form = [];
  $this->form[] = ['label'=>'Username','name'=>'name','type'=>'text','validation'=>'required|min:1|max:255'];

```
