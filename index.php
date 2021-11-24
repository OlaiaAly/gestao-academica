<?php
require __DIR__."/App/lib/autoload.php";

use \MyApp\model\classes\Aluno; 
use \MyApp\model\classes\Curso;
use \MyApp\model\classes\Cadeira; 

$aux = new Aluno();
$ob = $aux->getAllAluno();
echo"<pre>";
    print_r($ob);
echo"</pre>";

$aux = new Curso();
$ob = $aux->getAllCurso();
echo"<pre>";
    print_r($ob);
echo"</pre>";

$aux = new Cadeira();
$ob = $aux->getAllCadeira();
echo"<pre>";
    print_r($ob);
echo"</pre>";