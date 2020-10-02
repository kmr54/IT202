<?PHP 
///Part 1
$arr1 = array(1,2,3,4,5);
var_dump($arr1);
print  "<br>\n";
print  "<br>\n";

#Part 2;
foreach($arr1 as $nums){
	echo "$nums <br>\n";
}
print  "<br>\n";

/*Part 3?*/
$i = 0;
while( $i<count($arr1) ){
	if($arr1[$i]%2==0)
		echo "$arr1[$i] <br>\n";
$i++;
}

#Part 4

/*In order to only print the even values of $arr1's elements, I decided to 
use a while loop to go through and check if the values were even. I declared
the variable $i to start at 0, the first index of $arr1, and stop before
count($arr1), the length of the array. If a value was even (which I checked using mod and seeing if the number divided by 2 yielded no remainder) I would print that value.
*/

?>;
