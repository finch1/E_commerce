<?php
    error_reporting(E_ALL);
    ini_set("display_errors", '1');

    if(isset($_GET)) {

    }

?>
<html>
<head>
    <title>Insert Post</title>
</head>

<body>
    <form method="get">
        <p>isbn         <input type="text" name="isbn"></p>
        <p>title        <input type="text" name="title"></p>
        <p>author       <input type="text" name="authorFirst"><input type="text" name="authorLast"></p>
        <p>publisher    <input type="text" name="publisher"></p>
        <p>description  <textarea rows="4" cols="50" type="text" name="description"></textarea></p>
        <p>publish date YY/MM   <input type="text" name="publish_date_year"><input type="text" name="publish_date_month"></p>
        <p>genre    <br>
                    <label for="post_category">cat 1</label>
                    <input type="checkbox" name="post_category[first]" value="cat1">
                    <br>
                    <label for="post_category">cat 2</label>
                    <input type="checkbox" name="post_category[second]" value="cat2"></p>
        <p>stockQty <input type="text" name="stockQty"></p>
        <p>price <input type="text" name="price"></p>

        <input type="submit" value="new_book">
    </form>
</body>
</html>


<?php
    // This path should point to Composer's autoloader
    require 'private/vendor/autoload.php';

    $client = (new MongoDB\Client);

    try
    {
        $client->listDatabases();
    }
    catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e)
    {
        echo "PHP cannot find a MongoDB server using the MongoDB connection 
                string specified
                 do something here.";
        exit();
    }

    $collection = $client->test->users;
    echo $collection->count();

/*
    The MongoDB\Collection::insertOne() method inserts a single document into
    MongoDB and returns an instance of MongoDB\InsertOneResult, which you can use
    to access the ID of the inserted document.
*/
/*
    $insertOneResult = $collection->insertOne([
        'username'  => 'admin',
        'email'     => 'admin@example.com',
        'name'      => 'Admin User',
    ]);

    echo "<br>"."inserted ".$insertOneResult->getInsertedCount()." document";
    echo "<br> Object ID:".$insertOneResult->getInsertedId();
    echo "<br>";
    $insertManyResult = $collection->insertMany([
        [
            'username'  => 'admin',
            'email'     => 'admin@example.com',
            'name'      => 'Admin User',
        ],
        [
            'username'  => 'admin',
            'email'     => 'admin@example.com',
            'name'      => 'Admin User',
        ],

    ]);

    echo "<br>"."inserted ".$insertManyResult->getInsertedCount()." documents";
    $outputarray = $insertManyResult->getInsertedIds();
    echo "<br> Object ID:".$outputarray[0];
    echo "<br> Object ID:".$outputarray[1];
    echo "<br>";
*/
/*
    MongoDB\Collection::findOne() returns the first document that matches
    the query or null if no document matches the query.
*/
/*
    $document = $collection->findOne(['name'=>'Admin User']);
    echo "<br>".$document['name'];
    echo "<br>".$document['email'];
    echo "<br>".$document['username'];
    echo "<br>";
    echo "<br>";

/*
    MongoDB\Collection::find() returns a MongoDB\Driver\Cursor object,
    which you can iterate upon to access all matched documents.
*/
    $name = 'est';
    $option = ['username'=>$name];
    //$cursor = $collection->find($option);

//    $cursor = $collection->find(['id'=> ['$ne' =-> 4], 'id' => 1] );
//    foreach($cursor as $manydocs){
//        echo $manydocs['_id']."<br>";
//        echo $manydocs['name']."<br>";
//        echo $manydocs['username']."<br>";
//        echo $manydocs['email']."<br>";
//        echo "<br>";
//    }

    $cursor = $collection->findOneAndUpdate(
        ['name' => ['$eq' => 'Crystal']],
        ['$set' => ['isActive' => true]]);

/*
    By default, queries in MongoDB return all fields in matching documents.
    To limit the amount of data that MongoDB sends to applications, you can
    include a projection document in the query operation.
*/
/*
    $cursor = $collection->find(
        ['name'=>'Admin User'],
        ['projection' =>
            ['name' => 1,],
            'limit' => 4,
        ]
    );

    foreach($cursor as $manydocs){
        echo $manydocs['_id']."<br>";
        echo $manydocs['name']."<br>";
        //echo $manydocs['username']."<br>"; //no load no show
        //echo $manydocs['email']."<br>"; //no load no show
        echo "<br>";
    }
*/

/*
    The following example uses the limit and sort options to query
*/
/*
    $cursor = $collection->find(
        [],
        [
            'limit' => 4,
            'sort' => ['pop' => -1],
        ]
    );

    foreach($cursor as $manydocs){
        echo $manydocs['_id']."<br>";
        echo $manydocs['name']."<br>";
        echo $manydocs['username']."<br>";
        echo $manydocs['email']."<br>";
        echo "<br>";
    }
?>

*/