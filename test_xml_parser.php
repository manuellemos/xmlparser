<?
/*
 * test_xml_parser.html
 *
 * @(#) $Header$
 *
 */

?><HTML>
<HEAD>
<TITLE>Test for Manuel Lemos's XML parser PHP class</TITLE>
</HEAD>
<BODY>
<H1><CENTER>Test for Manuel Lemos's XML parser PHP class</CENTER></H1>
<HR>
<?
	require("xml_parser.php");

Function DumpArray(&$array,$indent)
{
	for(Reset($array),$node=0;$node<count($array);Next($array),$node++)
	{
		echo $indent."\"".Key($array)."\"=";
		$value=$array[Key($array)];
		if(GetType($value)=="array")
		{
			echo "\n".$indent."[\n";
			DumpArray(&$value,$indent."\t");
			echo $indent."]\n";
		}
		else
			echo "\"$value\"\n";
	}
}

Function DumpStructure(&$structure,&$positions,$path)
{
	echo "[".$positions[$path]["Line"].",".$positions[$path]["Column"].",".$positions[$path]["Byte"]."]";
	if(GetType($structure[$path])=="array")
	{
		echo "&lt;".$structure[$path]["Tag"]."&gt;";
		for($element=0;$element<$structure[$path]["Elements"];$element++)
			DumpStructure(&$structure,&$positions,$path.",$element");
		echo "&lt;/".$structure[$path]["Tag"]."&gt;";
	}
	else
		echo $structure[$path];
}

	$file_name="example.xml";
	if(!($file=fopen($file_name,"r")))
		echo "<H2><CENTER>Could not open file \"$file_name\"</CENTER></H2>\n";
	else
	{
		$parser=new xml_parser_class;
		$parser->store_positions=1;
		$error=$parser->ParseStream($file);
		fclose($file);
		if(strcmp($error,""))
			echo "<H2><CENTER>Parser error: $error</CENTER></H2>\n";
		else
		{
			echo "<H2><CENTER>Parsed file structure</CENTER></H2>\n";
			echo "<P>This example dumps the structure of the elements a XML file by displaing the tags and data preceed by their positions in the file: line number, column number and file byte index.</P>\n";
			echo "<PRE>";
			DumpStructure(&$parser->structure,&$parser->positions,"0");
			echo "</PRE>\n";
		}
	}
?></BODY>
</HTML>