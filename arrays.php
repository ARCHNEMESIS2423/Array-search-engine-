<?php 
       $arraym = [
        ['name'=>'Act Buggati the dream car Classy','descr'=>'Most famous people love it de Buggati especially that guy'],  
        ['name'=>'Blue Ferrari the sports car Etsy','descr'=>'One of the most beloved sports car though not famous nowadays '],
        ['name'=>'Classy Sounds in physics','descr'=>'Reffered to as wave phenomenons through air '],
        ['name'=>'Doctor BIT my course code Act ','descr'=>'BSIT is more accurate but BIT is mostly used acronym'],
        ['name'=>'Etsy Alex my young brother Act','descr'=>'Loves to have fun ,a fond of gamification and is pretty Smart 🤓 ,we have a lot of memories together'], 
        ['name'=>'Godlove my brother','descr'=>'He is a little pain when it comes to school stuff but he does like being useful on things he believes he can do '],  
        ['name'=>'Moses My brother ','descr'=>'He is a smart 🤓 guy,loves school 🎒 loves to play all kinds of fun games and is quite a determined boy , I believe if he keeps up in that spirit he might find great treasures in his life 🧬 '],   
        ['name'=>'Mom my mother ','descr'=>'A very determined mom hopes to see her babies all successfull  '], 
        ['name'=>'Buggati Brother Web development','descr'=>'Today is Feb 22 Sunday 2026 '], 
        ['name'=>'Avengers end game dreamed nightmare ','descr'=>'ACTION MOVIE 🍿 FROM AMERICA HOLLYWOOD '],
        ['name'=>'QWERTY QWERTY ','descr'=>'first lettes of computer 🖥️ keyboard ⌨️']
];

if(isset($_GET['query']) && !empty($_GET['query'])){
  $start = microtime(true);
$search = explode(' ',$_GET['query']);
$p=0;
            foreach($search as $pointer){
    foreach($arraym as $arr){
		$flag = stripos($arr['name'],$pointer) ||  stripos($arr['descr'],$pointer);
      if($flag ===false){continue;} else {

              $array[$p]['name'] = $arr['name'];
              $array[$p]['descr'] = $arr['descr'];
              $clean_array =array_unique($array,SORT_REGULAR);
              $p++; 
                 }
             }
       }


   if(isset($clean_array)===true){
$found= array_map(function ($item) use ($search) {     foreach($search as $point){
$item['descr'] = str_ireplace($point,"<b class='highlight'>$point</b>",$item['descr']);  
      	 
$item['name'] = str_ireplace($point,"<b class='highlight'>$point</b>",$item['name']);     
       }
       return $item;
       },  $clean_array);
       $stop = microtime(true);
   }  
   print_r(isset($found)??$found);
       
}else{
  $search = false;
}


?>



    
    

  


	
	