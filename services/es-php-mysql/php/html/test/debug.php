<?

/*
echo	"<pre>"
			."["
			.__DIR__
			."]"
			."["
			.__FILE__
			."]"
		."</pre>\n";
*/

require_once('../lib/lib.php');

function callf($fn) {
	echo "calling $fn hello\n";
	call_user_func($fn, "hello");
}

callf('print_r');



echo "<pre>";
echo "null==false : " ;
echo null==false;
echo "\n";
echo "null===false :";
echo null===false;
echo "</pre>";
echo "\n";


debug
	::on()
	::variable(debug::check(), "1" )
	::off()
	::variable(debug::check(), "2" )
	::on()
	::variable(debug::check(), "3" )
	::off()
	::variable(debug::check(), "4" );
	

# lol 
# https://stackoverflow.com/questions/125268/chaining-static-methods-in-php	
class chain
    {
    static public function one()
        {echo "one\n"; return get_called_class();}

    static public function two()
        {echo "two\n";return get_called_class();}
    }

${${${${chain::one()} = chain::two()}::one()}::two()}::one();
echo "${${${${chain::one()} = chain::two()}::one()}::two()}::one()";
