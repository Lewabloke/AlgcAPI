<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;


$app = new \Slim\App;

$app->options('/{routes:.+}', function($request,$response,$args){
	return $response;
});

$app->add(function($req,$res,$next){
	$response = $next($req, $res);
	return $response
				->withHeader('Access-Control-Allow-Origin','*')
				->withHeader('Access-Control-Allow-Headers','X-Requested-With, Content-Type, Accept, Origin, Authorization')
				->withHeader('Access-Control-Allow-Methods','GET, POST, PUT, DELETE, OPTIONS');
});

/* 
Module: Testimony
@description: Handles crud functionality of the Testimony http request 
@author: Omolewa Stephen Ayobami
@company: Hubroot Technologies
@endpoint: 
	/api/testimony - Reads all testimony
	/api/testimony/new - Posts a new testimony

*/

$app->get('/api/testimony',function(Request $request, Response $response){
 
	$sql = "SELECT * FROM `algc`.`testimony`";

	try{
		$db = new Db();
		$db->query($sql);
		$posts = $db->resultset();

		$db = null;

		return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withJson($posts, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

	}catch(PDOException $e){
		echo '{ "error": {"text": '.$e->getMessage(). '}';
	}
});

$app->post('/api/testimony/new', function(Request $request, Response $response){

	$name = $request->getParam('name');
	$title = $request->getParam('title');
	$message = $request->getParam('message');
	$date = $request->getParam('date');

	$sql = "INSERT INTO testimony(name,title,message,tdate)VALUES(:name,:title,:message,:tdate)";

	try {
		$db = new Db();

		$db->query($sql);
		$db->bind(':name', $name);
		$db->bind(':title', $title);
		$db->bind(':message', $message);
		$db->bind(':tdate', $date);

		$db->execute();
		echo '{"notice": {"text": "Testimony Sent"}';
	} catch (PDOException $e) {
		echo '{"error": {"text": '.$e->getMessage().'}';
	}	
});

####################################
## 			End Testimony 		  ##
####################################

/* 
Module: Rev. Blog/Sermon
@description: Handles crud functionality of the Article http request 
@author: Omolewa Stephen Ayobami
@company: Hubroot Technologies
@endpoint: 
	/api/article - Reads all articles
	/api/article/id - Reads a single article

*/

$app->get('/api/article',function(Request $request, Response $response){
 
	$sql = "SELECT * FROM `algc`.`article`";

	try{
		$db = new Db();
		$db->query($sql);
		$art = $db->resultset();

		$db = null;

		return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withJson($art, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

	}catch(PDOException $e){
		echo '{ "error": {"text": '.$e->getMessage(). '}';
	}
});

$app->get('/api/article/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');

	$sql = "SELECT * FROM article WHERE id = $id ";

	try {
		$db = new Db();
		$db->query($sql);
		$post = $db->single();
		$db = null;

		return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withJson($post, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

	} catch (PDOException $e) {
		echo '{ "error": {"text": '.$e->getMessage(). '}';
	}
});

####################################
## 			End Article 		  ##
####################################

/* 
Module: District
@description: Handles crud functionality of the district http request 
@author: Omolewa Stephen Ayobami
@company: Hubroot Technologies
@endpoint: 
	/api/district - Reads all district
	/api/district/id - Reads a single district

*/

$app->get('/api/district',function(Request $request, Response $response){
 
	$sql = "SELECT * FROM `algc`.`district`";

	try{
		$db = new Db();
		$db->query($sql);
		$art = $db->resultset();

		$db = null;

		return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withJson($art, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

	}catch(PDOException $e){
		echo '{ "error": {"text": '.$e->getMessage(). '}';
	}
});

$app->get('/api/district/{id}', function(Request $request, Response $response){
	$id = $request->getAttribute('id');
	if(empty($id)){
		$error = "No district identity given.";
		echo '{ "error": {"text": '. $error. '}';
	}

	$sql = "SELECT * FROM district WHERE id = $id ";

	try {
		$db = new Db();
		$db->query($sql);
		$post = $db->single();
		$db = null;

		return $response->withHeader('Content-Type', 'application/json')->withStatus(200)->withJson($post, null, JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

	} catch (PDOException $e) {
		echo '{ "error": {"text": '.$e->getMessage(). '}';
	}
});

####################################
## 			End District 		  ##
####################################


