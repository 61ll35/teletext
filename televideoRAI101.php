<?php
while(1)
{
$last_news=file_get_contents("last_news.txt");
$breaking_news1=file_get_contents("http://www.servizitelevideo.rai.it/televideo/pub/solotesto.jsp?pagina=101");
file_put_contents("breaking.txt",$breaking_news1);
$breaking_news=file_get_contents("breaking.txt");

	if ($last_news==$breaking_news)
		{
		//NON CI SONO NOTIZIE
		}
	else
		{
		$regex='#<\s*?pre\b[^>]*>(.*?)</pre\b[^>]*>#s';
		preg_match($regex,$breaking_news,$matches);
		$articolo=$matches[0]; $articolo=strip_tags($articolo); $articolo=trim($articolo);
		//echo "$articolo \n";
		
		file_put_contents("articolo.txt",$articolo);
		$txt=fopen("articolo.txt","r");
		$line1=fgets($txt); $titolo_articolo=fgets($txt); $titolo_articolo=trim($titolo_articolo);//titolo dell'articolo
		$titolo_articolo= str_replace("\"", "'", $titolo_articolo);
		exec("notify-send \"$titolo_articolo\" ");	

		$data=date(DATE_RFC2822);

		file_put_contents('storico.txt',  $titolo_articolo . " -> " .  $data . "\n", FILE_APPEND);
		file_put_contents('storico_articolo.txt', "////////// \n" . $data . "\n" .  $articolo . "\n" .  $data . "\n//////////\n", FILE_APPEND);
		file_put_contents("last_news.txt",$breaking_news);
		}
sleep(60);
}
?>
