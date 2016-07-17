<?php

include("autoloader.php");
use \NlpTools\Tokenizers\WhitespaceTokenizer;
use \NlpTools\Similarity\JaccardIndex;
use \NlpTools\Similarity\CosineSimilarity;
use \NlpTools\Similarity\Simhash;
use Tga\SimHash\Fingerprint;
//$s1 = $s2 = '';
$s1 = $_POST['text1'];
//$s2 = $_POST['text2'];

//$fs1 = explode(' ',$s1);


?>
<?php include 'view/header.php';?>
<!-- Contact with Map - START -->
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="well well-sm">
                <form class="form-horizontal" action="" method="post">
                    <fieldset>
                        <legend class="text-center header">Text</legend>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <textarea class="form-control" id="text1" name="text1" placeholder="Enter your text." rows="7"><?=$s1;?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <label><input id="method" name="method" value="1" type="radio" class="form-control"> Method 1 </label>
                                <label><input id="method" name="method" value="2" type="radio" class="form-control"> Method 2 </label>  
                                <label><input id="method" name="method" value="3" type="radio" class="form-control"> Method 3 </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <button name="submit" type="submit" class="btn btn-primary btn-lg">Submit</button>

                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <?php
            if(isset($_POST['submit']))
            {
                $db = mysqli_connect('localhost','varjini','varjini', 'varjini');
                $result = mysqli_query($db, "SELECT * FROM article");
                ?>







                <div class="col-md-12"> 
                    <div class="row">
                        <div class="alert alert-danger" role="alert">
                            <b><?php //echo mysqli_num_rows($result);?></b> Similiar article(s) with more than 50% similarity was found.



                        </div>
                    </div>
                    <?php

                    while($row =  mysqli_fetch_assoc($result))
                    {       
                        switch($_POST['method'])
                        {
                            case '1':
                            {

                                $tok = new WhitespaceTokenizer();
                                $simhash = new Simhash(16); // 16 bits hash

                                $text = $tok->tokenize($_POST['text1']);
                                $body = $tok->tokenize($row['Body']);
                                $sh =  $simhash->similarity($body,$text);
                                $sh *=100;
                                if($sh >= 50)
                                {
                                    ?>


                                    <div class="row">


                                        <div class="alert alert-success" role="alert">
                                            <a href="showarticle.php?id=<?=$row['ID'];?>"><?=$row['Title'];?></a>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow=" <?=$sh;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$sh;?>%;">
                                                    Similarity precent:  <?=$sh;?>%
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <?php 
                                    $tok = null; 
                                    $simhash = null; 
                                    $text = null; 
                                }
                            }


                            case '2':
                            {
                                $var_1 = $row['Body']; 
                                $var_2 = $_POST['text1']; 

                                similar_text($var_1, $var_2, $percent); 

                                //echo $percent; 
                                // 27.272727272727 

                                /*similar_text($var_2, $var_1, $percent); 

                                echo $percent; */
                                // 18.181818181818 
                                if($percent >= 50)
                                {
                                    ?>


                                    <div class="row">


                                        <div class="alert alert-success" role="alert">
                                            <a href="showarticle.php?id=<?=$row['ID'];?>"><?=$row['Title'];?></a>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow=" <?=$percent;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$percent;?>%;">
                                                    Similarity precent:  <?=$percent;?>%
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <?php 
                                }
                            }
                              case '3':
                            {

                               // $tok = new WhitespaceTokenizer();
                                $simhash = new Simhash(32); // 16 bits hash

                                $text = $tok->tokenize($_POST['text1']);
                                $body = $tok->tokenize($row['Body']);
                               echo  $sh =  $simhash->dist($text,$body);
                                $sh *=100;
                                if($sh >= 50)
                                {
                                    ?>


                                    <div class="row">


                                        <div class="alert alert-success" role="alert">
                                            <a href="showarticle.php?id=<?=$row['ID'];?>"><?=$row['Title'];?></a>

                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow=" <?=$sh;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?=$sh;?>%;">
                                                    Similarity precent:  <?=$sh;?>%
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <?php 
                                    $tok = null; 
                                    $simhash = null; 
                                    $text = null; 
                                }
                            }
                        }
                    }
                }



                ?>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <div class="panel panel-default">
                    <div class="text-center header">Upload File</div>
                    <div class="panel-body text-center">

                        <form class="form-horizontal" method="post">
                            <fieldset>





                                <div class="form-group">
                                    <div class="col-md-10 col-md-offset-1" style="height: 150%" class="form-control">
                                        <input name="file" type="file" >
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg">Submit</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'view/footer.php';?>
